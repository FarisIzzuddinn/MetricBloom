<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPI Visual Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        h1, h2, h3 {
            margin: 0;
            text-align: center;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            background-color: #17a2b8;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 15px;
        }
        .row {
            display: table;
            width: 100%;
            table-layout: fixed;
            margin-bottom: 15px;
        }
        .card {
            display: inline-block;
            width: 30%; /* Adjust card width for three columns */
            margin: 1%;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            background-color: #f9f9f9;
            page-break-inside: avoid; /* Prevent breaking cards across pages */
        }
        .card-header {
            font-size: 16px;
            font-weight: bold;
            background-color: #6c757d;
            color: #fff;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .badge-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        .badge {
            display: inline-block;
            width: 50px;
            height: 50px;
            line-height: 50px;
            font-size: 16px;
            color: #fff;
            border-radius: 5px;
            font-weight: bold;
        }
        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }
        .bg-primary { background-color: #007bff; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KPI Report</h1>
        <p>Pecahan Pencapaian Mengikut Negeri, Institusi, dan Bahagian</p>
    </div>

    <!-- Section for States -->
    <div class="section">
        <div class="section-title">Pecahan Pencapaian Mengikut Negeri</div>
        <div class="row">
            @foreach ($statesGroupedData as $stateName => $data)
            <div class="card">
                <div class="card-header">{{ $stateName }}</div>
                <div class="badge-container">
                    <div class="badge bg-success">{{ $data['achieved'] }}</div>
                    <div class="badge bg-danger">{{ $data['not_achieved'] }}</div>
                    <div class="badge bg-primary">{{ $data['pending'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Section for Institutions -->
    <div class="section">
        <div class="section-title">Pecahan Pencapaian Mengikut Institusi</div>
        <div class="row">
            @foreach ($institutionsGroupedData as $institutionName => $data)
            <div class="card">
                <div class="card-header">{{ $institutionName }}</div>
                <div class="badge-container">
                    <div class="badge bg-success">{{ $data['achieved'] }}</div>
                    <div class="badge bg-danger">{{ $data['not_achieved'] }}</div>
                    <div class="badge bg-primary">{{ $data['pending'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Section for Bahagian -->
    <div class="section">
        <div class="section-title">Pecahan Pencapaian Mengikut Bahagian</div>
        <div class="row">
            @foreach ($bahagianGroupedData as $bahagianName => $data)
            <div class="card">
                <div class="card-header">{{ $bahagianName }}</div>
                <div class="badge-container">
                    <div class="badge bg-success">{{ $data['achieved'] }}</div>
                    <div class="badge bg-danger">{{ $data['not_achieved'] }}</div>
                    <div class="badge bg-primary">{{ $data['pending'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>