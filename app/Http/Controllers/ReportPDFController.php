<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportPDFController extends Controller
{
    public function exportPDF(Request $request)
    {
        // Frontend sends both "report" and "charts"
        $report = $request->input('report', []);
        $charts = $request->input('charts', []);

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
    }
}
