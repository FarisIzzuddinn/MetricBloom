<!DOCTYPE html>
<html>
<head>
    <title>Custom KPI Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>KPI Report</h2>
    <table>
        <thead>
            <tr>
                <th>KPI Statement</th>
                <th>Owner</th>
                <th>Pencapaian</th>
                <th>Peratus Pencapaian</th>
                <th>Status</th>
                <th>Quarter</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reports as $report)
                <tr>
                    <td>{{ $report->kpi_statement }}</td>
                    <td>{{ $report->entity_name }}</td>
                    <td>{{ $report->pencapaian }}</td>
                    <td>{{ $report->peratus_pencapaian }}%</td>
                    <td>{{ $report->status }}</td>
                    <td>{{ $report->quarter }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
