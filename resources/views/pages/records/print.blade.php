<!DOCTYPE html>
<html lang="en">
@php
    use App\Models\ViolationEntries;
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic Citation and Vehicle Impounding</title>
    <!-- External Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .profile-card {
            padding: 20px;
            border-radius: 8px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin: auto;
        }

        .section-title {
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #343a40;
        }

        .btn-print {
            background-color: #7b4dfc;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
        }

        .btn-print:hover {
            background-color: #6c3fe3;
            color: white;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .status-unpaid {
            background-color: #f8d7da;
            color: #dc3545;
        }

        .status-impounded {
            background-color: #f0ad4e;
            color: white;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="containerx my-1">
        <!-- Profile Section -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="profile-card text-center">
                    <div class="profile-img">
                        <span>&#128100;</span> <!-- Placeholder for User Image -->
                    </div>
                    @php
                        $info = App\Models\TrafficCitation::where('violator_name', $name)->first();
                    @endphp
                    <table class="table mt-3">
                        <tr>
                            <th>Name :</th>
                            <td>{{ $name }}</td>
                        </tr>
                        <tr>
                            <th>Address :</th>
                            <td>{{ $info->address }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Traffic Citation Section -->
            <div class="col-md-8">
                <div class="profile-card">
                    <div class="section-title">Traffic Citation</div>

                    <table id="citationTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ordinance No.</th>
                                <th>Offenses</th>
                                <th>Total Fine</th>
                                <th>Plate Number</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($min_cite as $index => $entry)
                                @php
                                    $get_violations = json_decode($entry->specific_offense, true);
                                    $check_once = 0;
                                    $violation = '';
                                    $total_fine = 0;
                                    // Check if decoding was successful
                                    if ($get_violations !== null) {
                                        // Iterate through the array and access each violation ID
                                        foreach ($get_violations as $violation_id) {
                                            $violation = ViolationEntries::select('violation as name', 'penalty')
                                                ->where('id', $violation_id)
                                                ->first();
                                            $check_once++;
                                            $total_fine += $violation->penalty;
                                        }
                                    }
                                    $currentDate = new DateTime();
                                    $deadlineDate = new DateTime($entry->release_date ?? $entry->date_of_impounding);
                                    $difference = $currentDate->diff($deadlineDate);
                                    $daysLeft = $deadlineDate > $currentDate ? $difference->days : $difference->days;
                                @endphp
                                <tr style="cursor: pointer;"
                                    onclick="view({{ $entry->id }}, '{{ $entry->plate_number }}', '{{ $entry->violator_name }}', '{{ $entry->address }}', '{{ $entry->date }}', '{{ $entry->municipal_ordinance_number }}', '{{ $entry->specific_offense }}', '{{ $entry->remarks }}', '{{ $entry->status }}')"
                                    data-bs-toggle="modal" data-bs-target="#edit">
                                    <td>{{ $index + 1 }}.</td>
                                    <td>{{ $entry->municipal_ordinance_number }}</td>
                                    <td>
                                        <ul class="project-users g-1">
                                            <li>
                                                {{ $violation->name }}
                                            </li>
                                            <li>
                                                @if ($check_once != 1)
                                                    <div class="user-avatar bg-light sm">
                                                        <span>+{{ $check_once - 1 }}</span>
                                                    </div>
                                                @endif
                                            </li>
                                        </ul>
                                    </td>
                                    <td class="pt-2 fw-bold text-dark">₱ {{ number_format($total_fine, 2) }}</td>
                                    <td>{{ $entry->plate_number }}</td>
                                    <td>
                                        <span style="width: 100%"
                                            class="badge badge-sm badge-dot has-bg bg-{{ $entry->status ? 'success' : 'danger' }} d-none d-sm-inline-flex">
                                            {{ $entry->status ? 'Paid' : 'Unpaid' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Vehicle Impounding Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="profile-card">
                    <div class="section-title">Vehicle Impounding</div>

                    <table id="impoundTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Specific Offense</th>
                                <th>Total Fine</th>
                                <th>Vehicle</th>
                                <th>Plate Number</th>
                                <th>Status</th>
                                <th>Total Day(s)</th>
                                <th>Storage Fee</th>
                                <th>Date Impound</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($min_v as $index => $entry)
                                @php
                                    $get_violations = json_decode($entry->violation_id, true);

                                    $check_once = 0;
                                    $violation = '';
                                    $total_fine = 0;
                                    // Check if decoding was successful
                                    if ($get_violations !== null) {
                                        // Iterate through the array and access each violation ID
                                        foreach ($get_violations as $violation_id) {
                                            $violation = ViolationEntries::select('violation as name', 'penalty')
                                                ->where('id', $violation_id)
                                                ->first();
                                            $check_once++;
                                            $total_fine += $violation->penalty;
                                        }
                                    }

                                    $currentDate = new DateTime();
                                    $deadlineDate = new DateTime($entry->release_date ?? $entry->date_of_impounding);
                                    $difference = $currentDate->diff($deadlineDate);
                                    $daysLeft = $deadlineDate > $currentDate ? $difference->days : $difference->days;

                                @endphp
                                {{-- // 'license_no',
                                            // 'address',
                                            // 'birthdate',
                                            // 'phone',
                                            // 'reason_of_impoundment',
                                            // 'reason_of_impoundment_reason',
                                            // 'incident_address',
                                            // 'condition_x', --}}
                                @php
                                    $d = $daysLeft - 1;
                                    $r = $d * 50;
                                    if ($r <= 0) {
                                        $storage_fee = 0;
                                    } else {
                                        $storage_fee = $d * 50;
                                    }
                                @endphp

                                <tr style="cursor: pointer;"
                                    onclick="view1({{ $entry->id }}, '{{ $entry->owner_name }}', '{{ $entry->vehicle_type }}', '{{ $entry->vehicle_number }}', '{{ $entry->violation_id }}', '{{ $entry->date_of_impounding }}', '{{ $entry->reason_for_impounding }}', '{{ $entry->fine_amount }}', '{{ $entry->release_date }}', '{{ $entry->license_no }}', '{{ $entry->address }}', '{{ $entry->birthdate }}', '{{ $entry->phone }}', '{{ $entry->reason_of_impoundment }}', '{{ $entry->reason_of_impoundment_reason }}', '{{ $entry->incident_address }}', '{{ $entry->condition_x }}', '{{ $storage_fee }}', '{{ $entry->officer_name }}', '{{ $entry->officer_rank }}', '{{ $entry->photo_attachment }}')"
                                    data-bs-toggle="modal" data-bs-target="#entries">
                                    <td class="pt-2">{{ $index + 1 }}.</td>
                                    <td>
                                        <ul class="project-users g-1">
                                            <li>
                                                {{ $violation->name }}
                                            </li>
                                            <li>
                                                @if ($check_once != 1)
                                                    <div class="user-avatar bg-light sm">
                                                        <span>+{{ $check_once - 1 }}</span>
                                                    </div>
                                                @endif
                                            </li>
                                        </ul>
                                    </td>
                                    <td class="pt-2 fw-bold text-dark">₱ {{ number_format($total_fine, 2) }}</td>
                                    <td class="pt-2">{{ $entry->vehicle_type }}</td>
                                    <td class="pt-2">{{ $entry->vehicle_number }}</td>
                                    <td>
                                        <span style="width: 100%"
                                            class="badge badge-sm badge-dot has-bg bg-{{ $entry->release_date ? 'success' : 'danger' }} d-none d-sm-inline-flex">
                                            @if ($daysLeft != 0)
                                                @php
                                                    $d = $daysLeft - 1;
                                                @endphp
                                                @if ($d >= 60)
                                                    Disposal
                                                @else
                                                    {{ $entry->release_date ? 'Released' : 'Impounded' }}
                                                @endif
                                            @else
                                                {{ $entry->release_date ? 'Released' : 'Impounded' }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="pt-2 text-center text-dark">
                                        <b>{{ $daysLeft != 0 ? $daysLeft - 1 : $daysLeft }}</b> Days
                                    </td>
                                    <td>
                                        @if ($r <= 0)
                                            ₱ 0.00
                                        @else
                                            ₱ {{ number_format($d * 50, 2) }}
                                        @endif
                                    </td>
                                    <td class="pt-2">
                                        {{ date_format(date_create($entry->date_of_impounding), 'D, M. d, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- External Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Custom JS -->
    <script>
        $(document).ready(function() {
            // Initialize DataTables for both tables
            $('#citationTable').DataTable({
                searching: true,
                paging: true,
                lengthChange: false
            });

            $('#impoundTable').DataTable({
                searching: true,
                paging: true,
                lengthChange: false
            });
        });
    </script>
</body>

</html>
