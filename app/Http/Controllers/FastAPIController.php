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
        // Increase PHP execution time limit for AI processing (10 minutes)
        ini_set('max_execution_time', 600);
        
        try {
            $analyzeUrl = $this->getAnalyzeUrl();
            $apiKey = $this->getApiKey();

            // Validate file exists
            if (!$request->hasFile('file')) {
                return response()->json([
                    'error' => 'No file provided'
                ], 400);
            }

            $file = $request->file('file');

            // Send file to analyze endpoint with API key authentication
            // FastAPI backend requires X-API-Key header (see src/deps/security.py)
            $response = Http::withHeaders([
                'X-API-Key' => $apiKey,
            ])->timeout(6000) // 5 minutes timeout for file analysis
              ->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
              ->post($analyzeUrl);

            if ($response->successful()) {
                $responseData = $response->json();
                
                // Transform FastAPI response to match frontend expectations
                // FastAPI returns: { "status": "success", "reports": [{ "analysis": {...}, ... }] }
                // Frontend expects: { "analysis": {...}, ... } (single report object)
                if (isset($responseData['reports']) && is_array($responseData['reports']) && count($responseData['reports']) > 0) {
                    // Return the first report with analysis data
                    $firstReport = $responseData['reports'][0];
                    
                    // Transform to match frontend expectations - pass the entire report as analysis
                    // Frontend expects: { analysis: { analysis: {...}, graph_suggestions: {...}, ... } }
                    return response()->json([
                        'analysis' => $firstReport,  // Full report object with analysis, graph_suggestions, etc.
                        'status' => $responseData['status'] ?? 'success',
                        'total_reports' => $responseData['total_reports'] ?? 1,
                        'cache_id' => $responseData['cache_id'] ?? null, // Include cache_id for save operation
                        'report_metadata' => [
                            'file_name' => $firstReport['file_name'] ?? 'Unknown',
                            'form_type' => $firstReport['form_type'] ?? 'Unknown',
                            'report_number' => $firstReport['report_number'] ?? 1
                        ]
                    ]);
                }
                
                // If structure is different, return as-is
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
     * Proxy analysis search request to FastAPI
     */
    public function analysisSearch(Request $request)
    {
        try {
            // Get base URL and remove /api/agent if present
            $baseUrl = $this->getAnalyzeUrl();
            $baseUrl = preg_replace('/\/api\/agent$/', '', $baseUrl);
            $apiKey = $this->getApiKey();

            // Validate request
            $request->validate([
                'query' => 'required|string|min:1',
                'top_k' => 'sometimes|integer|min:1|max:50'
            ]);

            $searchUrl = "{$baseUrl}/api/analysis-search";
            
            // Send search request to FastAPI with API key authentication
            $response = Http::withHeaders([
                'X-API-Key' => $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30) // 30 seconds timeout for search
              ->post($searchUrl, [
                  'query' => $request->input('query'),
                  'top_k' => $request->input('top_k', 10)
              ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'error' => $response->json()['detail'] ?? 'Search failed',
                'status' => $response->status()
            ], $response->status());

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('AI Agent analysis-search error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to connect to search service',
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
}

