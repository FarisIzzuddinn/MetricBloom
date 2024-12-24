<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>State Performance Report</title>
    <style>
        /* Your custom styles for the PDF */
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .table td {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>State Performance Report</h1>
        <p>Performance Overview for State: {{ $state->name }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Institution Name</th>
                <th>KPI Statement</th>
                <th>Pencapaian</th>
                <th>Percentage</th>
                <th>Status</th>
                <th>Quarter</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ $report->entity_name }}</td>
                    <td>{{ $report->kpi_statement }}</td>
                    <td>{{ $report->pencapaian }}</td>
                    <td>{{ $report->peratus_pencapaian }}%</td>
                    <td>{{ ucfirst($report->status) }}</td>
                    <td>{{ $report->quarter }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
