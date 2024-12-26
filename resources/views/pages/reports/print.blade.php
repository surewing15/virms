<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Printout</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Header */
        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-header img {
            height: 80px;
            margin-bottom: 10px;
        }

        .form-header h3, p {
            margin: 5px 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        /* Table Styling */
        .custom-table {
            width: 100%;
            border: 1px solid black;
        }

        .custom-table th, .custom-table td {
            vertical-align: middle;
            text-align: center;
            border: 1px solid black;
            padding: 8px;
        }

        .custom-table thead {
            background-color: #004085;
            color: white;
            font-weight: bold;
        }

        .custom-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Footer */
        .form-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            font-size: 12px;
        }

        .footer-section {
            text-align: center;
            width: 45%;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .custom-table thead {
                background-color: #004085 !important;
                color: white !important;
                -webkit-print-color-adjust: exact; /* Ensure color is printed */
            }
        }
    </style>
</head>
@php
    use App\Models\ViolationEntries;
    use App\Models\VehicleImpounding;
    use Carbon\Carbon;

    date_default_timezone_set('Asia/Manila');
@endphp
@php
    if (isset($_GET['from'])) {
        $from = $_GET['from'] ? Carbon::createFromFormat('m/d/Y', $_GET['from']) : Carbon::now()->startOfYear();
        $to = $_GET['to'] ? Carbon::createFromFormat('m/d/Y', $_GET['to']) : Carbon::now();

        $citations = App\Models\TrafficCitation::whereBetween('date', [$from, $to])->get();
        $impoundings = App\Models\VehicleImpounding::whereBetween('date_of_impounding', [$from, $to])->get();
    } else {
        if (isset($_GET['v'])) {
            $v = $_GET['v'];
            if ($v == 'Released') {
                $impoundings = VehicleImpounding::where('release_date', '<>', null)->get();
            } elseif ($v == 'Impound') {
                $impoundings = VehicleImpounding::where('release_date', '=', null)->get();
            } else {
                $impoundings = VehicleImpounding::get();
            }
        } else {
            $impoundings = VehicleImpounding::get();
        }

        $citations = App\Models\TrafficCitation::get();
    }

@endphp
<body>

    <!-- Header Section -->
    <div class="form-header">
        <img src="/images/header.png" style="height: 250px" alt="Logo">
    </div>

    <!-- Main Form Section -->
    <div class="containerx" style="padding: 15px">
        <p class="text-end"><strong>Date:</strong> ____________________________</p>
        <table class="custom-table">
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th width="120">Date</th>
                    <th>Violator</th>
                    <th>Specific Offense</th>
                    <th>Vehicle <span class="fw-normal">(Year/Brand/Model)</span></th>
                    <th width="150">Plate Number</th>
                    <th width="100">Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $revenue = 0;
                @endphp
                @foreach ($impoundings as $index => $entry)
                    @php
                        $get_violations = json_decode($entry->violation_id, true);
                        $total_fine = 0;
                        $violation_names = [];

                        if ($get_violations !== null) {
                            foreach ($get_violations as $violation_id) {
                                $violation = ViolationEntries::select('violation as name', 'penalty')
                                    ->where('id', $violation_id)
                                    ->first();
                                $total_fine += $violation->penalty;
                                $violation_names[] = $violation->name;
                            }
                        }
                        $revenue += $total_fine;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ date_format(date_create($entry->date_of_impounding), 'M, d Y') }}</td>
                        <td>{{ $entry->owner_name }}</td>
                        <td>{{ implode(', ', $violation_names) }}</td>
                        <td>{{ $entry->vehicle_type }}</td>
                        <td>{{ $entry->vehicle_number }}</td>
                        <td>
                            <span class="badge bg-{{ $entry->release_date ? 'success' : 'danger' }}">
                                {{ $entry->release_date ? 'Released' : 'Impounded' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer Section -->
    <div class="form-footer">
        <div class="footer-section">
            <p><strong>Released By:</strong></p>
            <p>PMSg Acero, AJ</p>
            <p>Traffic Investigator</p>
        </div>
        <div class="footer-section">
            <p><strong>Noted By:</strong></p>
            <p>RALPH REXSON LOPEZ LAYUG</p>
            <p>Police Captain</p>
            <p>Officer In Charge</p>
        </div>
    </div>

</body>
</html>
