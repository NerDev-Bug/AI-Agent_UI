<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIController extends Controller
{
    public function analyze(Request $request)
    {
        // 🔒 Validate file upload
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpeg,jpg,png|max:5120',
        ]);

        $file = $request->file('file');
        $aiUrl = env('API_AI_AGENT_URL');
        $apiKey = env('AI_AGENT_KEY');

        // 🔐 Send to AI Agent securely
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->attach(
            'file',
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName()
        )->post($aiUrl);

        if ($response->failed()) {
            return response()->json(['error' => 'AI analysis failed'], 500);
        }

        return response()->json([
            'status' => 'success',
            'analysis' => $response->json(),
        ]);
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'confirm' => 'required|in:true',
        ]);

        $aiUrl = env('API_AI_AGENT_CONFIRM_URL');
        $apiKey = env('AI_AGENT_KEY');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post($aiUrl, [
            'confirm' => true,
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Confirmation failed'], 500);
        }

        return response()->json(['status' => 'saved']);
    }
}
