<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FastAPIController extends Controller
{
    /**
     * Get Analyze API URL from environment
     */
    private function getAnalyzeUrl(): string
    {
        return config('services.ai_agent.analyze_url', env('API_AI_AGENT_URL', 'http://localhost:8002/api/agent'));
    }

    private function getAnalysisSearchURL(): string
    {
        return config('services.ai_agent.analyze_url', env('API_AI_AGENT_URL', 'http://localhost:8002/api/analysis-search'));
    }
    /**
     * Get Confirm API URL from environment
     */
    private function getConfirmUrl(): string
    {
        return config('services.ai_agent.confirm_url', env('API_AI_AGENT_CONFIRM_URL', 'http://localhost:8002/api/storage/approve-simple'));
    }

    /**
     * Get API key from environment
     * 
     * Note: This key must match the API_KEY in FastAPI backend .env file
     * FastAPI expects X-API-Key header for authentication (see security.py)
     */
    private function getApiKey(): string
    {
        return config('services.ai_agent.api_key', env('AI_AGENT_KEY', ''));
    }

    /**
     * Proxy file analysis request to FastAPI
     */
public function analyzeFile(Request $request)
{
    ini_set('max_execution_time', 600);
    
    try {
        $analyzeUrl = $this->getAnalyzeUrl();
        $apiKey = $this->getApiKey();

        if (!$request->hasFile('file')) {
            return response()->json([
                'error' => 'No file provided'
            ], 400);
        }

        $file = $request->file('file');
        $background = $request->input('background', 'false'); // Get as string
        
        // ✅ FIXED: Properly send background as query parameter or form field
        $httpRequest = Http::withHeaders([
            'X-API-Key' => $apiKey,
        ])->timeout(600);
        
        // Build multipart request
        $multipart = [
            [
                'name' => 'file',
                'contents' => file_get_contents($file->getRealPath()),
                'filename' => $file->getClientOriginalName()
            ]
        ];
        
        // Add background parameter as query param in URL
        $url = $analyzeUrl;
        if ($background === 'true') {
            $url .= '?background=true';
        }
        
        $response = $httpRequest->attach(
            'file', 
            file_get_contents($file->getRealPath()), 
            $file->getClientOriginalName()
        )->post($url);

        if ($response->successful()) {
            $responseData = $response->json();
            
            // If background mode, return job info immediately
            if (isset($responseData['status']) && $responseData['status'] === 'queued') {
                return response()->json([
                    'status' => 'queued',
                    'job_id' => $responseData['job_id'],
                    'session_id' => $responseData['session_id'] ?? null,
                    'message' => $responseData['message'] ?? 'Processing started in background',
                    'progress_url' => $responseData['progress_url'] ?? "/api/ai-agent/progress/{$responseData['job_id']}"
                ]);
            }
            
            // Transform FastAPI response for synchronous mode
            if (isset($responseData['reports']) && is_array($responseData['reports']) && count($responseData['reports']) > 0) {
                $firstReport = $responseData['reports'][0];
                
                return response()->json([
                    'analysis' => $firstReport,
                    'status' => $responseData['status'] ?? 'success',
                    'total_reports' => $responseData['total_reports'] ?? 1,
                    'cache_id' => $firstReport['cache_id'] ?? null, // ✅ Extract from first report
                    'report_metadata' => [
                        'file_name' => $firstReport['file_name'] ?? 'Unknown',
                        'form_type' => $firstReport['form_type'] ?? 'Unknown',
                        'report_number' => $firstReport['report_number'] ?? 1
                    ]
                ]);
            }
            
            return response()->json($responseData);
        }

        return response()->json([
            'error' => $response->json()['detail'] ?? 'Analysis failed',
            'status' => $response->status()
        ], $response->status());

    } catch (\Exception $e) {
        Log::error('AI Agent analyze-file error: ' . $e->getMessage());
        return response()->json([
            'error' => 'Failed to connect to analysis service',
            'message' => $e->getMessage()
        ], 500);
    }
}

public function getProgress($jobId)
{
    try {
        $baseUrl = $this->getAnalyzeUrl();
        $baseUrl = preg_replace('/\/api\/agent$/', '', $baseUrl);
        $apiKey = $this->getApiKey();

        $progressUrl = "{$baseUrl}/api/progress/{$jobId}";
        
        $response = Http::withHeaders([
            'X-API-Key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(10)
          ->get($progressUrl);

        if ($response->successful()) {
            $data = $response->json();
            
            // ✅ Handle failed jobs - pass through error information
            if (isset($data['status']) && $data['status'] === 'failed') {
                // Job failed - return error information to frontend
                return response()->json([
                    'status' => 'failed',
                    'error' => $data['error'] ?? $data['message'] ?? 'Job processing failed',
                    'message' => $data['message'] ?? $data['error'] ?? 'Job processing failed',
                    'job_id' => $data['job_id'] ?? $jobId,
                    'progress' => 0
                ]);
            }
            
            // ✅ Transform result structure to match frontend expectations (only for successful jobs)
            if (isset($data['result']) && isset($data['result']['reports'])) {
                // Extract first report and cache_id
                $reports = $data['result']['reports'];
                if (!empty($reports)) {
                    $firstReport = $reports[0];
                    
                    // Add cache_id from result if available
                    if (isset($data['result']['cache_id'])) {
                        $firstReport['cache_id'] = $data['result']['cache_id'];
                    }
                    
                    $data['result'] = [
                        'analysis' => $firstReport,
                        'status' => $data['result']['status'] ?? 'success',
                        'total_reports' => count($reports),
                        'cache_id' => $firstReport['cache_id'] ?? null
                    ];
                }
            }
            
            return response()->json($data);
        }

        return response()->json([
            'error' => $response->json()['detail'] ?? 'Failed to get progress',
            'status' => $response->status()
        ], $response->status());

    } catch (\Exception $e) {
        Log::error('AI Agent get-progress error: ' . $e->getMessage());
        return response()->json([
            'error' => 'Failed to get job progress',
            'message' => $e->getMessage()
        ], 500);
    }
}
    /**
     * Proxy confirm analysis request to FastAPI
     */
    public function confirmAnalysis(Request $request)
    {
        // Increase PHP execution time limit for confirmation (5 minutes)
        ini_set('max_execution_time', 300);
        
        try {
            $confirmUrl = $this->getConfirmUrl();
            $apiKey = $this->getApiKey();

            // Send confirmation to approve endpoint with API key authentication
            // FastAPI backend requires X-API-Key header (see src/deps/security.py)
            $response = Http::withHeaders([
                'X-API-Key' => $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(300) // 5 minutes timeout for confirmation
              ->post($confirmUrl, $request->all());

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'error' => $response->json()['detail'] ?? 'Confirmation failed',
                'status' => $response->status()
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('AI Agent confirm-analysis error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to connect to analysis service',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generic proxy method for other FastAPI endpoints
     */
    public function proxy(Request $request, $endpoint)
    {
        // Increase PHP execution time limit for proxy requests (5 minutes)
        ini_set('max_execution_time', 300);
        
        try {
            // For generic proxy, use analyze URL as base (remove /api/agent if present)
            $baseUrl = $this->getAnalyzeUrl();
            $baseUrl = preg_replace('/\/api\/agent$/', '', $baseUrl);
            $apiKey = $this->getApiKey();

            $method = strtolower($request->method());
            $url = "{$baseUrl}/api/{$endpoint}";

            $httpRequest = Http::withHeaders([
                'X-API-Key' => $apiKey,
                'Content-Type' => $request->header('Content-Type', 'application/json'),
            ])->timeout(300); // 5 minutes timeout for proxy requests

            // Handle different HTTP methods
            switch ($method) {
                case 'get':
                    $response = $httpRequest->get($url, $request->query());
                    break;
                case 'post':
                    if ($request->hasFile('file')) {
                        $file = $request->file('file');
                        $response = $httpRequest->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                                              ->post($url, $request->except('file'));
                    } else {
                        $response = $httpRequest->post($url, $request->all());
                    }
                    break;
                case 'put':
                    $response = $httpRequest->put($url, $request->all());
                    break;
                case 'patch':
                    $response = $httpRequest->patch($url, $request->all());
                    break;
                case 'delete':
                    $response = $httpRequest->delete($url);
                    break;
                default:
                    return response()->json(['error' => 'Method not allowed'], 405);
            }

            if ($response->successful()) {
                return response()->json($response->json(), $response->status());
            }

            return response()->json([
                'error' => $response->json()['detail'] ?? 'Request failed',
                'status' => $response->status()
            ], $response->status());

        } catch (\Exception $e) {
            Log::error("FastAPI proxy error for {$endpoint}: " . $e->getMessage());
            return response()->json([
                'error' => 'Failed to connect to analysis service',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
 * Get progress of background job
 */


}



