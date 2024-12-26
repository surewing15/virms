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
<x-app-layout>
    <x-slot name="back"></x-slot>
    <x-slot name="btn"> </x-slot>

    <div class="nk-block-head-content mb-3 ">
        <div class="toggle-wrap nk-block-tools-toggle">
            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                    class="icon ni ni-more-v"></em></a>
            <div class="toggle-expand-content" data-content="pageMenu">
                <ul class="nk-block-tools g-3">
                    <li class="nk-block-tools-opt">
                        <span><label for="#" class="fw-bold pt-1 px-3">Filter Date :
                            </label></span>
                        {{-- <span><input type="date" class="form-control"></span>
                        <span class="px-3 pt-1"> | </span> --}}

                        <form method="GET" action="/generate-report">
                            <div style="float: right">
                                <button type="submit" class="btn btn-light bg-white">
                                    Generate Date
                                </button>
                            </div>
                            <div style="float: right; margin-right: 10px;">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <div class="input-daterange date-picker-range input-group">
                                            <input type="text" name="from"
                                                value="{{ request('from') ?? date('01/01/Y') }}" class="form-control" />
                                            <div class="input-group-addon">TO</div>
                                            <input type="text" name="to"
                                                value="{{ request('to') ?? date('m/d/Y') }}" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </li>
                    {{-- <li class="px-0">
                        <select name="" id="" class="form-select">
                            <option value="-" disabled selected>- Year - </option>
                            @for ($year = date('Y'); $year >= 2000; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </li>
                    <li>
                        <select name="" id="" class="form-select">
                            <option value="-" disabled selected>- Month -</option>
                            @for ($month = 1; $month <= 12; $month++)
                                <option value="{{ $month }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                            @endfor
                        </select>
                    </li>
                    <li>
                        <button class="btn btn-light bg-white text-dark">
                            <em class="icon ni ni-calendar"></em>&ensp;
                            Generate Report
                        </button>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>


    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-inner">
                        <h1 class="text-2xl text-dark"><b>Generate Reports</b> as of {{ date('D, F d, Y h:i A') }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-inner">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <h1 class="text-2xl fw-bold">Vehicle Impounding</h1>
                        <p>You can print the vehicle impounding here.</p>
                        <hr class="mt-3 mb-3">
                        <span style="float: right">
                            <button onclick="printOut()" class="btn btn-md btn-secondary mx-2">
                                <em class="icon ni ni-printer"></em>
                            </button>&ensp;
                        </span>
                        <span style="float: right">
                            <select name="" id="" onchange="filter_vehicle(this.value)"
                                class="form-control">
                                <option value="-" selected disabled>-</option>
                                <option value="All">All</option>
                                <option value="Released">Released</option>
                                <option value="Impound">Impound</option>
                            </select>
                        </span>

                        <script>
                            function filter_vehicle(type) {
                                window.location.href = '?v=' + type;
                            }

                            function printOut() {
                                @if (isset($_GET['v']))
                                    window.location.href = "/generate-report/print?v={{ $_GET['v'] }}";
                                    @else
                                    window.location.href = "/generate-report/print";
                                @endif
                            }
                        </script>
                        <table class="datatable-init table table-hover">
                            <thead>
                                <th width="50">#</th>
                                <th width="100">Date</th>
                                <th>Violator</th>
                                <th>Specific Offense</th>
                                <th> Vehicel <span class="fw-normal">(Year/Brand/Model)</span></th>
                                <th width="150">Plate Number</th>
                                <th width="100" class="text-center">Status</th>
                            </thead>
                            <tbody>
                                @php
                                    $revenue = 0;
                                @endphp
                                @foreach ($impoundings as $index => $entry)
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
                                        $deadlineDate = new DateTime(
                                            $entry->release_date ?? $entry->date_of_impounding,
                                        );
                                        $difference = $currentDate->diff($deadlineDate);
                                        $daysLeft =
                                            $deadlineDate > $currentDate ? $difference->days : $difference->days;

                                        $revenue += $total_fine;
                                    @endphp

                                    <tr>
                                        <td class="pt-2">{{ $index + 1 }}.</td>
                                        <td class="pt-2">
                                            {{ date_format(date_create($entry->date_of_impounding), 'M, d Y') }}</td>
                                        <td class="pt-2">{{ $entry->owner_name }}</td>
                                        <td>
                                            @php
                                                if ($get_violations !== null) {
                                                    // Iterate through the array and access each violation ID
                                                    foreach ($get_violations as $violation_id) {
                                                        $violation = ViolationEntries::select(
                                                            'violation as name',
                                                            'penalty',
                                                        )
                                                            ->where('id', $violation_id)
                                                            ->first();
                                                        echo $violation->name . ', ';
                                                    }
                                                }
                                            @endphp

                                        </td>
                                        <td class="pt-2">{{ $entry->vehicle_type }}</td>
                                        <td class="pt-2">{{ $entry->vehicle_number }}</td>
                                        <td>
                                            <span style="width: 100%"
                                                class="badge badge-sm badge-dot has-bg bg-{{ $entry->release_date ? 'success' : 'danger' }} d-none d-sm-inline-flex">
                                                {{ $entry->release_date ? 'Released' : 'Impounded' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-inner">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <h1 class="text-2xl fw-bold">Trafic Citations</h1>
                        <p>You can print the traffic citations here.</p>
                        <hr class="mt-3 mb-3">
                        <table class="datatable-init-export table table-hover">
                            <thead>
                                <th width="50">#</th>
                                <th width="100">Date</th>
                                <th width="150">Ordinance No.</th>
                                <th>Violator</th>
                                <th>Specific Offense</th>
                                <th width="150">Total Fine</th>
                                <th width="150">Plate Number</th>
                                <th width="150">Remarks</th>
                                <th width="230">Updated At</th>
                            </thead>
                            <tbody>
                                @foreach ($citations as $index => $entry)
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
                                        $deadlineDate = new DateTime(
                                            $entry->release_date ?? $entry->date_of_impounding,
                                        );
                                        $difference = $currentDate->diff($deadlineDate);
                                        $daysLeft =
                                            $deadlineDate > $currentDate ? $difference->days : $difference->days;
                                    @endphp
                                    <tr style="cursor: pointer;"
                                        onclick="view({{ $entry->id }}, '{{ $entry->plate_number }}', '{{ $entry->violator_name }}', '{{ $entry->address }}', '{{ $entry->date }}', '{{ $entry->municipal_ordinance_number }}', '{{ $entry->specific_offense }}', '{{ $entry->remarks }}')"
                                        data-bs-toggle="modal" data-bs-target="#edit">
                                        <td>{{ $index + 1 }}.</td>
                                        <td>{{ date_format(date_create($entry->date), 'M, d Y') }}</td>
                                        <td>{{ $entry->municipal_ordinance_number }}</td>
                                        <td>{{ $entry->violator_name }}</td>
                                        <td>
                                            @php
                                                if ($get_violations !== null) {
                                                    // Iterate through the array and access each violation ID
                                                    foreach ($get_violations as $violation_id) {
                                                        $violation = ViolationEntries::select(
                                                            'violation as name',
                                                            'penalty',
                                                        )
                                                            ->where('id', $violation_id)
                                                            ->first();
                                                        echo $violation->name . ', ';
                                                    }
                                                }
                                            @endphp

                                        </td>
                                        <td class="pt-2 fw-bold text-dark">₱ {{ number_format($total_fine, 2) }}</td>
                                        <td>{{ $entry->plate_number }}</td>
                                        <td>{{ $entry->remarks }}</td>
                                        <td>{{ date_format($entry->created_at, 'D, M. d, Y h:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.revenue.chart')

</x-app-layout>
