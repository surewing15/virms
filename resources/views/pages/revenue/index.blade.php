@php
    use App\Models\ViolationEntries;
    date_default_timezone_set('Asia/Manila');
@endphp
<x-app-layout>
    <x-slot name="back"></x-slot>
    <x-slot name="btn">

    </x-slot>

    <div class="nk-block-head-content mb-3 ">
        <div class="toggle-wrap nk-block-tools-toggle">
            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                    class="icon ni ni-more-v"></em></a>
            <div class="toggle-expand-content" data-content="pageMenu">
                <ul class="nk-block-tools g-3">
                    {{-- <li class="nk-block-tools-opt">
                        <span><label for="#" class="fw-bold pt-1 px-3">Filter Specific Date :
                            </label></span>
                        <span><input type="date" class="form-control"></span>
                        <span class="px-3 pt-1"> | </span>
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
                        <h1 class="text-2xl text-dark"><b>Revenue Reports</b> as of {{ date('D, F d, Y h:i A') }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card" style="min-height: 600px">
                    <div class="card-inner">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @php
                            $revenue = 0;
                            $storage_fee_x = 0;
                        @endphp
                        <table class="datatable-init nowrap table table-hover">
                            <thead>
                                <th width="50">#</th>
                                <th>Violator</th>
                                <th>Specific Offense</th>
                                <th width="150">Total Fine</th>
                                <th width="120" class="text-center">Total Day(s)</th>
                                <th width="" class="text-center">Storage Fee</th>
                                <th width="100" class="text-center">Status</th>
                            </thead>
                            <tbody>
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

                                        $date1 = new DateTime($entry->date_of_impounding);
                                        $date2 = new DateTime($entry->release_date);

                                        // Calculate the difference
                                        $interval = $date1->diff($date2);

                                        // Get the number of days
                                        $days_between = $interval->days;

                                        // Display the result
                                        $storage_fee_x += $days_between * 50;
                                    @endphp

                                    <tr style="cursor: pointer;"
                                        onclick="view({{ $entry->id }}, '{{ $entry->owner_name }}', '{{ $entry->vehicle_type }}', '{{ $entry->vehicle_number }}', '{{ $entry->violation_id }}', '{{ $entry->date_of_impounding }}', '{{ $entry->reason_for_impounding }}', '{{ $entry->fine_amount }}', '{{ $entry->release_date }}', '{{ $entry->license_no }}', '{{ $entry->address }}', '{{ $entry->birthdate }}', '{{ $entry->phone }}', '{{ $entry->reason_of_impoundment }}', '{{ $entry->reason_of_impoundment_reason }}', '{{ $entry->incident_address }}', '{{ $entry->condition_x }}', '{{ $storage_fee }}', '{{ $entry->officer_name }}', '{{ $entry->officer_rank }}', '{{ $entry->photo_attachment }}')"
                                        data-bs-toggle="modal" data-bs-target="#entries">
                                        <td class="pt-2">{{ $index + 1 }}.</td>
                                        <td class="pt-2">{{ $entry->owner_name }}</td>
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
                                        <td class="pt-2 text-center text-dark">
                                            <b>{{ $daysLeft != 0 ? $daysLeft - 1 : $daysLeft }}</b> Days
                                        </td>
                                        <td>
                                            @if ($r <= 0)
                                                ₱ 0.00
                                            @else
                                                ₱ {{ number_format($days_between * 50, 2) }}
                                            @endif
                                        </td>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12 ">
                    <div class="card alert alert-pro alert-success p-0">
                        <div class="nk-ecwg nk-ecwg6">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Total Amount Revenue</h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="data-group">
                                        <div class="amount">₱ {{ number_format(($revenue * 0.1) + $storage_fee_x , 2) }}</div>
                                        <div class="nk-ecwg6-ck">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="card alert alert-pro alert-danger p-0">
                        <div class="nk-ecwg nk-ecwg6">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Total Impounded & Release Vehicles</h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="data-group">
                                        <div class="amount">
                                            {{ $impoundings_count->whereNotNull('release_date')->count() }} /
                                            <b>{{ $impoundings_count->count() }}</b>
                                        </div>
                                        <div class="nk-ecwg6-ck">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="card card-full overflow-hidden">
                        <div class="nk-ecwg nk-ecwg7 h-100">
                            <div class="card-inner flex-grow-1">
                                <div class="card-title-group mb-4">
                                    <div class="card-title">
                                        <h6 class="title">Data Analytics</h6>
                                    </div>
                                </div>
                                <div class="nk-ecwg7-ck">
                                    <canvas class="ecommerce-doughnut-s1" id="orderStatistics"></canvas>
                                </div>
                                <ul class="nk-ecwg7-legends">
                                    <li>
                                        <div class="title">
                                            <span class="dot dot-lg sq" data-bg="#1EE0AC"></span>
                                            <span>Paid Violations</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">
                                            <span class="dot dot-lg sq" data-bg="#E85347"></span>
                                            <span>Unpaid Violations</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.revenue.chart')

</x-app-layout>
