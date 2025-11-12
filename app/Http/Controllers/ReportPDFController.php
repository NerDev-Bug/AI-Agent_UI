<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class ReportPDFController extends Controller
{
    public function exportPDF(Request $request)
    {
        try {
            // Check if GD extension is installed
            if (!extension_loaded('gd')) {
                Log::error('PHP GD extension is not installed. PDF export requires GD extension.');
                return response()->json([
                    'error' => 'PDF export requires PHP GD extension. Please install/enable the GD extension in your PHP configuration.',
                    'details' => 'The GD extension is needed to process images in PDF files.'
                ], 500);
            }

            // Frontend sends both "report" and "charts"
            $report = $request->input('report', []);
            $charts = $request->input('charts', []);

            if (empty($report)) {
                return response()->json([
                    'error' => 'No report data provided.'
                ], 400);
            }

            // Use form_type as filename (fallback to "Report")
            $reportTitle = $report['form_type'] ?? 'Report';
            $filename = preg_replace('/[\/\\\\]/', '-', $reportTitle) . '.pdf';

            // Get paper size from request or default to A4
            $paperSize = $request->input('paper_size', 'a4'); // a4, letter, legal, etc.
            $orientation = $request->input('orientation', 'portrait'); // portrait or landscape

            // Pass both data sets to Blade view
            $pdf = Pdf::loadView('pdf.report', compact('report', 'charts'))
                      ->setPaper($paperSize, $orientation)
                      ->setOption('enable-local-file-access', true)
                      ->setOption('isRemoteEnabled', true)
                      ->setOption('dpi', 200) // Higher DPI for sharper images and text
                      ->setOption('isHtml5ParserEnabled', true)
                      ->setOption('isPhpEnabled', false);

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('PDF Export Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to generate PDF: ' . $e->getMessage(),
                'details' => 'Please check server logs for more details.'
            ], 500);
        }
    }
}
