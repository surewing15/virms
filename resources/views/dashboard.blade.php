@php
    use App\Models\ViolationEntries;
@endphp
<x-app-layout>
    <x-slot name="back"></x-slot>
    <x-slot name="btn">
    </x-slot>

    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-inner">
                        <h1 class="text-2xl text-dark">Welcome <b>{{ Auth::user()->name }} !</b></h1>
                    </div>
                </div>
            </div>
                <div class="col-md-6">
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
                                        <div class="amount">{{ $impoundings_count->whereNotNull('release_date')->count() }} / <b>{{ $impoundings_count->count() }}</b></div>
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
                <div class="col-md-6">
                    <div class="card alert alert-pro alert-primary p-0">
                        <div class="nk-ecwg nk-ecwg6">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Total Ticket Citation</h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="data-group">
                                        <div class="amount">{{ $citations->count() }}</div>
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


                <div class="col-md-12">
                    <div class="card">
                        <div class="card-inner">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <h1 class="text-2xl fw-bold">Violator and Vehicle Information</h1>
                            <hr class="mt-3 mb-3">
                            <table class="datatable-init nowrap table table-hover">
                                <thead>
                                    <th width="50">#</th>
                                    <th>Violator</th>
                                    <th>Specific Offense</th>
                                    <th width="150">Total Fine</th>
                                    <th> Vehicel <span class="fw-normal">(Year/Brand/Model)</span></th>
                                    <th width="150">Plate Number</th>
                                    <th width="100" class="text-center">Status</th>
                                    <th width="120" class="text-center">Total Day(s)</th>
                                    <th width="" class="text-center">Storage Fee</th>
                                    <th width="150">Date Impound</th>
                                    <th width="100" class="text-center">Action</th>
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
                                            if ($r <= 0){
                                                $storage_fee = 0;
                                            }else{
                                                $storage_fee = $d * 50;
                                            }
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
                                            <td>
                                                <button class="btn btn-block btn-xs btn-light btn-white text-dark">
                                                    <em class="icon ni ni-edit"></em>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                            <h1 class="text-2xl fw-bold">Citation Reports</h1>
                            <hr class="mt-3 mb-3">
                            <table class="datatable-init table table-hover">
                                <thead>
                                    <th width="50">#</th>
                                    <th width="150">Ordinance No.</th>
                                    <th>Violator</th>
                                    <th>Specific Offense</th>
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
                                            // Check if decoding was successful
                                            if ($get_violations !== null) {
                                                // Iterate through the array and access each violation ID
                                                foreach ($get_violations as $violation_id) {
                                                    $violation = ViolationEntries::select('violation as name')
                                                        ->where('id', $violation_id)
                                                        ->first();
                                                    $check_once++;
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
                                        <tr>
                                            <td>{{ $index + 1 }}.</td>
                                            <td>{{ $entry->municipal_ordinance_number }}</td>
                                            <td>{{ $entry->violator_name }}</td>
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

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-inner">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            
                            <h1 class="text-2xl fw-bold">Violation Entries</h1>
                            <hr class="mt-3 mb-3">
                           <table class="datatable-init table table-hover">
                                <thead>
                                    <th width="50">#</th>
                                    <th>Violation</th>
                                    <th width="150">Penalty</th>
                                    <th width="230">Created At</th>
                                    <th width="230">Updated At</th>
                                </thead>
                                <tbody>
                                    @foreach ($violations as $index => $entry)
                                        <tr>
                                            <td>{{ $index + 1 }}.</td>
                                            <td>{{ $entry->violation }}</td>
                                            <td>₱ {{ number_format($entry->penalty , 2) }}</td>
                                            <td>{{ date_format($entry->created_at , 'D, M. d, Y h:i A')}}</td>
                                            <td>{{ date_format($entry->updated_at , 'D, M. d, Y h:i A')}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                           </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
