<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPI Report</title>
    <style>
        /* Basic reset for margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* General body styles */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 30px;
        }

        /* Header styling */
        .report-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .report-header h1 {
            font-size: 30px;
            margin-bottom: 5px;
        }

        .report-header p {
            font-size: 18px;
            font-weight: normal;
        }

        /* Table styling */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #ddd;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f4f4f4;
            color: #444;
        }

        .table td {
            color: #555;
        }

        .table tr:hover {
            background-color: #f9f9f9;
        }

        /* Summary Section */
        .summary {
            margin-top: 30px;
        }

        .summary h2 {
            font-size: 22px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .summary table {
            width: 50%;
            margin: 0 auto;
            border: 1px solid #ddd;
        }

        .summary th,
        .summary td {
            padding: 8px;
            text-align: center;
        }

        .summary th {
            background-color: #f4f4f4;
            color: #444;
        }

        .summary td {
            font-size: 18px;
            font-weight: normal;
        }

        /* KPI Details Section */
        .kpi-details {
            margin-top: 30px;
        }

        .kpi-details h2 {
            font-size: 22px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 14px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <!-- Report Header -->
    <div class="report-header">
        <h1>KPI Report for {{ $user->name }}</h1>
        <p>Total KPIs: {{ $statusCounts['achieved'] + $statusCounts['pending'] + $statusCounts['not achieved'] }}</p>
    </div>

    <!-- Summary Section -->
    <div class="summary">
        <h2>Summary of KPI Status</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Achieved</td>
                    <td>{{ $statusCounts['achieved'] }}</td>
                </tr>
                <tr>
                    <td>Pending</td>
                    <td>{{ $statusCounts['pending'] }}</td>
                </tr>
                <tr>
                    <td>Not Achieved</td>
                    <td>{{ $statusCounts['not achieved'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- KPI Details Section -->
    <div class="kpi-details">
        <h2>Details of KPI Performance</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>KPI</th>
                    <th>Owner</th>
                    <th>Status</th>
                    <th>Achievement (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kpiData as $access)
                    @foreach ($access->kpi->bahagians as $bahagian)
                        <tr>
                            <td>{{ $access->kpi->pernyataan_kpi }}</td>
                            <td>{{ $bahagian->nama_bahagian }}</td>
                            <td>{{ $bahagian->pivot->status }}</td>
                            <td>{{ $bahagian->pivot->peratus_pencapaian }}%</td>
                        </tr>
                    @endforeach
                    @foreach ($access->kpi->states as $state)
                        <tr>
                            <td>{{ $access->kpi->pernyataan_kpi }}</td>
                            <td>{{ $state->name }}</td>
                            <td>{{ $state->pivot->status }}</td>
                            <td>{{ $state->pivot->peratus_pencapaian }}%</td>
                        </tr>
                    @endforeach
                    @foreach ($access->kpi->institutions as $institution)
                        <tr>
                            <td>{{ $access->kpi->pernyataan_kpi }}</td>
                            <td>{{ $institution->name }}</td>
                            <td>{{ $institution->pivot->status }}</td>
                            <td>{{ $institution->pivot->peratus_pencapaian }}%</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>This report was automatically generated using computer</p>
    </div>

</body>
</html>
