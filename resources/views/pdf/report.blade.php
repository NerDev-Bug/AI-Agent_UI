<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>{{ $report['form_type'] ?? 'Report' }}</title>
  <style>
    @page {
      margin: 15mm;
      size: auto;
    }

    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 11pt;
      color: #333;
      margin: 0;
      padding: 0;
      line-height: 1.5;
    }

    .form-title {
      font-size: 16pt;
      font-weight: bold;
      text-align: center;
      margin-bottom: 12px;
      page-break-after: avoid;
    }

    h1,
    h2,
    h3,
    h4 {
      margin-bottom: 8px;
      color: #2c3e50;
      page-break-after: avoid;
      font-weight: bold;
    }

    h2 {
      font-size: 13pt;
      font-weight: bold;
      page-break-after: avoid;
    }

    .section {
      margin-bottom: 20px;
      page-break-inside: avoid;
      orphans: 3;
      widows: 3;
    }

    .section h3 {
      color: #4B5563;
      border-bottom: 2px solid #ccc;
      padding-bottom: 5px;
      margin-bottom: 10px;
      page-break-after: avoid;
      font-size: 13pt;
      font-weight: bold;
    }

    .title-content {
      font-size: 13pt;
      font-weight: bold;
      page-break-after: avoid;
    }

    .info {
      page-break-inside: avoid;
    }

    .info p {
      margin: 4px 0;
      font-size: 11pt;
      line-height: 1.5;
    }

    .info strong {
      color: #374151;
      font-size: 11pt;
      font-weight: bold;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 6px;
      page-break-inside: avoid;
      font-size: 10pt;
    }

    .summary-ex {
      font-size: 11pt;
      page-break-inside: avoid;
      line-height: 1.5;
      text-align: justify;
    }

    th,
    td {
      border: 1px solid #ccc;
      padding: 8px 10px;
      text-align: left;
      page-break-inside: avoid;
      font-size: 10pt;
    }

    tr {
      page-break-inside: avoid;
      page-break-after: auto;
    }

    thead {
      display: table-header-group;
    }

    tfoot {
      display: table-footer-group;
    }

    th {
      background: #e9ecef;
      font-size: 10pt;
      font-weight: bold;
    }

    ul {
      margin: 0;
      padding-left: 20px;
      page-break-inside: avoid;
      font-size: 11pt;
    }

    li {
      page-break-inside: avoid;
      margin-bottom: 4px;
      font-size: 11pt;
      line-height: 1.5;
    }

    .chart {
      text-align: center;
      margin-bottom: 20px;
      page-break-inside: avoid;
      page-break-before: auto;
      page-break-after: auto;
      background-color: #ffffff;
      orphans: 3;
      widows: 3;
    }

    .chart img {
      max-width: 100%;
      height: auto;
      max-height: 550px;
      width: auto;
      object-fit: contain;
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-top: 10px;
      background-color: #ffffff;
      page-break-inside: avoid;
    }

    .chart p {
      font-size: 9pt;
      margin-top: 8px;
      line-height: 1.5;
      font-style: italic;
      page-break-before: avoid;
    }

    /* Prevent breaking inside these elements */
    .no-break {
      page-break-inside: avoid;
    }

    /* Allow natural flow for charts */
    .chart + .chart {
      page-break-before: auto;
    }

    /* Allow page break after charts section */
    .chart + .section {
      page-break-before: auto;
    }

    /* Ensure chart title stays with chart */
    .chart h4 {
      page-break-after: avoid;
      page-break-inside: avoid;
    }

    /* Data Visualization section wrapper - allow natural flow */
    h2 + .chart {
      page-break-before: auto;
      margin-top: 10px;
    }
  </style>
</head>

<body>

  <h1 class="form-title">{{ $report['form_type'] ?? 'Agent Product Trial Report' }}</h1>

  {{-- 🌾 Basic Info --}}
  @if(!empty($report['analysis']['basic_info']))
    <div class="section no-break">
      <h3 class="title-content">Basic Information</h3>
      <div class="info">
        <p><strong>Cooperator:</strong> {{ $report['analysis']['basic_info']['cooperator'] ?? '-' }}</p>
        <p><strong>Product:</strong> {{ $report['analysis']['basic_info']['product'] ?? '-' }}</p>
        <p><strong>Location:</strong> {{ $report['analysis']['basic_info']['location'] ?? '-' }}</p>
        <p><strong>Crop:</strong> {{ $report['analysis']['basic_info']['crop'] ?? '-' }}</p>
        <p><strong>Application Date:</strong> {{ $report['analysis']['basic_info']['application_date'] ?? '-' }}</p>
        <p><strong>Planting Date:</strong> {{ $report['analysis']['basic_info']['planting_date'] ?? '-' }}</p>
      </div>
    </div>
  @endif

  {{-- Performance Metrics --}}
  @if(!empty($report['analysis']['performance_analysis']))
    @php
      $metrics = $report['analysis']['performance_analysis']['calculated_metrics'] ?? [];
      $stat = $report['analysis']['performance_analysis']['statistical_assessment'] ?? [];
    @endphp
    <div class="section no-break">
      <h3 class="title-content">Performance Metrics</h3>
      <table>
        <thead>
          <tr>
            <th>Control Avg</th>
            <th>Leads Agri Avg</th>
            <th>Abs Diff</th>
            <th>Rel. Improvement (%)</th>
            <th>Significance</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ number_format($metrics['control_average'] ?? 0, 2) }}</td>
            <td>{{ number_format($metrics['leads_average'] ?? 0, 2) }}</td>
            <td>{{ number_format($metrics['absolute_difference'] ?? 0, 2) }}
              {{ $metrics['absolute_difference_unit'] ?? '' }}
            </td>
            <td>{{ number_format($metrics['relative_improvement_percent'] ?? 0, 2) }}%</td>
            <td>{{ ucfirst($stat['improvement_significance'] ?? '-') }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  @endif

  {{-- Treatment Comparison --}}
  @if(!empty($report['analysis']['treatment_comparison']))
    <div class="section no-break">
      <h3 class="title-content">Treatment Comparison</h3>
      <table>
        <thead>
          <tr>
            <th>Attribute</th>
            <th>Standard Practice</th>
            <th>Leads Agri</th>
          </tr>
        </thead>
        <tbody>
          @foreach($report['analysis']['treatment_comparison'] as $key => $val)
            @if(is_array($val))
              @foreach($val as $attr => $value)
                <tr>
                  <td>{{ ucfirst($attr) }}</td>
                  <td>{{ $report['analysis']['treatment_comparison']['control'][$attr] ?? '-' }}</td>
                  <td>{{ $report['analysis']['treatment_comparison']['leads_agri'][$attr] ?? '-' }}</td>
                </tr>
              @endforeach
              @break
            @endif
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  {{-- Charts/Graphs --}}
  @if(!empty($charts))
    <h2>Data Visualization</h2>
    @foreach($charts as $chart)
      <div class="chart">
        @if(!empty($chart['title']))
          <h4 style="font-size: 11pt; margin-bottom: 8px; color: #2c3e50; font-weight: bold;">{{ $chart['title'] }}</h4>
        @endif
        <img src="{{ $chart['data'] }}" alt="Chart Image">

        {{-- Add chart description if available --}}
        @if(!empty($chart['description']))
          <p style="font-size: 9pt; color: #000; margin-top: 8px; line-height: 1.5; font-style: italic;">
            {{ $chart['description'] }}
          </p>
        @endif
      </div>
    @endforeach
  @endif

  {{-- Executive Summary --}}
  @if(!empty($report['analysis']['executive_summary']))
    <div class="section no-break">
      <h3 class="title-content">Executive Summary</h3>
      <p class="summary-ex">{{ $report['analysis']['executive_summary'] }}</p>
    </div>
  @endif

  {{-- Opportunities --}}
  @if(!empty($report['analysis']['opportunities']))
    <div class="section no-break">
      <h3 class="title-content">Opportunities</h3>
      <ul>
        @foreach($report['analysis']['opportunities'] as $op)
          <li><strong>{{ $op['opportunity'] }}</strong> — {{ $op['data_basis'] }} (Potential: {{ $op['potential'] }})</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Risks --}}
  @if(!empty($report['analysis']['risk_factors']))
    <div class="section no-break">
      <h3 class="title-content">Risks / Limitations</h3>
      <ul>
        @foreach($report['analysis']['risk_factors'] as $risk)
          <li><strong>{{ $risk['risk'] }}</strong> — {{ $risk['data_basis'] }} (Severity: {{ $risk['severity'] }})</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Recommendations --}}
  @if(!empty($report['analysis']['recommendations']))
    <div class="section no-break">
      <h3 class="title-content">Recommendations</h3>
      <ul>
        @foreach($report['analysis']['recommendations'] as $rec)
          <li><b>{{ strtoupper($rec['priority']) }}</b> — {{ $rec['recommendation'] }} <br>
            <i>Data Basis:</i> {{ $rec['data_basis'] }} |
            <i>Expected Impact:</i> {{ $rec['expected_impact'] }}
          </li>
        @endforeach
      </ul>
    </div>
  @endif

</body>

</html>