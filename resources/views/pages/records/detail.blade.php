@php
    use App\Models\ViolationEntries;
@endphp
<x-app-layout>
    <x-slot name="back"></x-slot>
    <x-slot name="header">{{ __('Violator') }} / <strong class="text-primary small">
            {{ $name }}</strong></x-slot>
    <x-slot name="subHeader">{{ __('You can manage the traffic citations and impounding here.') }}</x-slot>
    <x-slot name="btn">
        {{-- <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" data-bs-toggle="modal" data-bs-target="#entries"
                    class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                        class="icon ni ni-menu-alt-r"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt d-none d-sm-block">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#entries" class="btn btn-danger">
                                <em class="icon ni ni-plus"></em>
                                <span>Add New Record</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div> --}}
    </x-slot>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <center>
                        <img src="http://127.0.0.1:8000/storage/no.jpg"  style="width: 185px !important; height: 180px; border-radius: 50%; object-fit: cover; ">
                    </center>
                    <hr class="mt-3 mb-3">
                    @php
                        $info = App\Models\TrafficCitation::where('violator_name', $name)->first();
                    @endphp
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="100" class="text-end">Name : </th>
                                <td>{{ $name }}</td>
                            </tr>
                            <tr>
                                <th width="100" class="text-end">Address : </th>
                                <td>{{ $info->address }}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <br>
            <a href="/violators/print/{{ $name }}" target="_blank" class="btn btn-primary btn-block">
                <em class="icon ni ni-printer"></em>
                &ensp; Print Profile
            </a>
        </div>
        <div class="col-md-8">
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
                                <h1 class="text-2xl fw-bolder">Traffic Citation</h1>
                                <hr class="mt-3 mb-3">
                                <table class="datatable-init-export table table-hover">
                                    <thead>
                                        <th width="50">#</th>
                                        <th width="150">Ordinance No.</th>
                                        <th> Offenses</th>
                                        <th width="150">Total Fine</th>
                                        <th width="150">Plate Number</th>
                                        <th width="100">Status</th>
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
                                                $deadlineDate = new DateTime(
                                                    $entry->release_date ?? $entry->date_of_impounding,
                                                );
                                                $difference = $currentDate->diff($deadlineDate);
                                                $daysLeft =
                                                    $deadlineDate > $currentDate ? $difference->days : $difference->days;
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
                                <h1 class="text-2xl fw-bolder">Vechicle Impounding</h1>
                                <hr class="mt-3 mb-3">
                                <table class="datatable-init-export nowrap table table-hover">
                                    <thead>
                                        <th width="50">#</th>
                                        <th>Specific Offense</th>
                                        <th width="150">Total Fine</th>
                                        <th> Vehicel <span class="fw-normal">(Year/Brand/Model)</span></th>
                                        <th width="150">Plate Number</th>
                                        <th width="100" class="text-center">Status</th>
                                        <th width="120" class="text-center">Total Day(s)</th>
                                        <th width="" class="text-center">Storage Fee</th>
                                        <th width="150">Date Impound</th>
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
            </div>
        </div>
    </div>
    


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @include('pages.citations.modals.modal')
    
    
    <div class="modal fade" tabindex="-1" role="dialog" id="entries">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal">
                    <em class="icon ni ni-cross-sm"></em>
                </a>
                <div class="modal-body">
                    <h1 class="nk-block-title page-title text-2xl" id="modal-title-label">
                        Add New Vehicle Impound
                    </h1>
                    <p>You can <span id="modal-sub-label">add</span> a vehicle impound entry to monitor impounding.</p>
                    <hr class="mt-2 mb-2">
    
                    <form action="{{ route('vehicle-impoundings.store') }}" method="POST" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
    
                        <!-- Owner Name -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="license_no">License Number <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Enter here..</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="license_no" name="license_no"
                                        placeholder="Enter here..">
                                </div>
                            </div>
                        </div>
    
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="owner_name">Owner Name <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Enter the owner's name.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="owner_name" name="owner_name"
                                        placeholder="Enter owner name" required>
                                </div>
                            </div>
                        </div>
    
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="address">Address <b class="text-danger">*</b></label>
                                    <span class="form-note">Enter here..</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Enter here..">
                                </div>
                            </div>
                        </div>
    
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="birthdate">Birthdate <b class="text-danger">*</b></label>
                                    <span class="form-note">Enter here..</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="birthdate" name="birthdate"
                                        placeholder="Enter here..">
                                </div>
                            </div>
                        </div>
    
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="phone">Phone No. <b class="text-danger">*</b></label>
                                    <span class="form-note">Enter here..</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Enter here..">
                                </div>
                            </div>
                        </div>
    
                        <!-- Vehicle Type -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="vehicle_type">Vehicle (Year/Brand/Model) <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Specify the type of vehicle.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="vehicle_type" name="vehicle_type"
                                        placeholder="Enter vehicle type" required>
                                </div>
                            </div>
                        </div>
    
                        <!-- Vehicle Number -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="vehicle_number">Vehicle Number <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Enter the vehicle number.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="vehicle_number" name="vehicle_number"
                                        placeholder="Enter vehicle number" required>
                                </div>
                            </div>
                        </div>
    
                        <!-- Violation -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="violation_id">Violation <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Select the violation.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <select class="form-control js-select2" multiple id="violation_id"
                                        onchange="updateTotal_1()" name="violation_id[]" placeholder="Search Violation.."
                                        required>
                                        @foreach ($violations as $violation)
                                            <option value="{{ $violation->id }}">{{ $violation->violation }} (₱
                                                {{ number_format($violation->penalty, 2) }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
    
                        <!-- Violation -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="violation_id">Total Penalty <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Computation of Violations.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <h1 class="text-2xl fw-bold"> ₱ <span id="totalPenalty">0.00</span></h1>
                                </div>
                            </div>
                        </div>
    
                        <!-- Date of Impounding -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="date_of_impounding">Date of Impounding <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Specify the date the vehicle was impounded.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="date" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}"
                                        class="form-control" id="date_of_impounding" name="date_of_impounding" required>
                                </div>
                            </div>
                        </div>
    
                        <h5 class="mb-3">REASON OF IMPOUNDMENT</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment" value="ACCIDENT"
                                        type="checkbox" id="accident">
                                    <label class="form-check-label" for="accident">ACCIDENT</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment" value="BURNED"
                                        type="checkbox" id="burned">
                                    <label class="form-check-label" for="burned">BURNED</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment" value="DWI"
                                        type="checkbox" id="dwi">
                                    <label class="form-check-label" for="dwi">DWI</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment" value="OTHER"
                                        type="checkbox" id="other">
                                    <label class="form-check-label" for="other">OTHER (Specify)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment" value="ABANDONED"
                                        type="checkbox" id="abandoned">
                                    <label class="form-check-label" for="abandoned">ABANDONED</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment" value="ILLEGALLY PARKED"
                                        type="checkbox" id="illegally-parked">
                                    <label class="form-check-label" for="illegally-parked">ILLEGALLY PARKED</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment" value="STOLEN"
                                        type="checkbox" id="stolen">
                                    <label class="form-check-label" for="stolen">STOLEN</label>
                                </div>
                            </div>
                        </div>
    
    
                        <div class="mb-3">
                            <input class="form-control" rows="2" name="reason_of_impoundment_reason"
                                placeholder="Specify reason if OTHER">
                        </div>
                        <div class="mb-3" style="display: none">
                            <label for="incident_address" class="form-label">Incident Location / Address</label>
                            <input class="form-control" id="incident_address" name="incident_address" rows="2"
                                placeholder="Text box">
                        </div>
                        <div class="mb-3" style="display: none">
                            <label for="condition-of-vehicle" class="form-label">
                                Condition of Vehicle (Attach Additional pages if more space is needed)
                            </label>
                            <input class="form-control" id="condition_x" name="condition_x" rows="2"
                                placeholder="Text box">
                        </div>
    
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="incident_location">Incident Location / Address</label>
                                    <span class="form-note">Specify the incident location or address.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="incident_location"
                                        name="incident_location" placeholder="Enter the location or address" required>
                                </div>
                            </div>
                        </div>
    
    
    
                        <!-- Attach Images / Photo -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="photo_attachment">Attach Images / Photos</label>
                                    <span class="form-note">Attach images here.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="file" class="form-control" accept=".jpg, .png, .jpeg, .gif"
                                        id="photo_attachment" name="photo_attachment[]" multiple>
                                </div>
                            </div>
                        </div>
    
                        <!-- Reason for Impounding -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="reason_for_impounding">Reason for Impounding</label>
                                    <span class="form-note">Provide the reason for impounding (if any).</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="reason_for_impounding"
                                        name="reason_for_impounding" placeholder="Enter reason (optional)">
                                </div>
                            </div>
                        </div>
    
                        <!-- Fine Amount -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="fine_amount">Storage Fee</label>
                                    <span class="form-note">Specify the fine amount (if applicable).</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="number" step="0.01" class="form-control" id="fine_amount"
                                        name="fine_amount" placeholder="Enter fine amount (optional)">
                                </div>
                            </div>
                        </div>
    
                        <!-- Release Date -->
    
                        <div class="row mt-2 align-center" style="display: none">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="officer_name">Officer Name</label>
                                    <span class="form-note">Specify the officer name (optional).</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="officer_name" name="officer_name">
                                </div>
                            </div>
                        </div>
    
                        <div class="row mt-2 align-center" style="display: none">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="officer_rank">Officer Rank</label>
                                    <span class="form-note">Specify the officer rank (optional).</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="officer_rank" name="officer_rank">
                                </div>
                            </div>
                        </div>
    
    
                        <div class="row mt-2 align-center" style="display: none">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="release_date">Release Date</label>
                                    <span class="form-note">Specify the release date (optional).</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="date" class="form-control" id="release_date" name="release_date">
                                </div>
                            </div>
                        </div>
    
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="document_attachment">Supporting Documents</label>
                                    <span class="form-note">Attach supporting documents (optional).</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="file" class="form-control" id="document_attachment"
                                        name="document_attachment[]" multiple>
                                </div>
                            </div>
                        </div>
    
                        <div class="row mt-2 align-center">
                            <div class="col-lg-12">
                                <hr class="mt-4 mb-4">
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-12">
                                <div id="file-container"></div>
                            </div>
                        </div>
    
                        <div class="row mt-2 align-center">
                            <div class="col-lg-12">
                                <hr class="mb-4">
                            </div>
                        </div>
    
    
    
                        <!-- Buttons -->
                        <div class="col-lg-4"></div>
                        <div class="col-lg-8" style="float: right">
                            <div class="form-group mt-2 mb-2 justify-end">
                                <button onclick="remove_1()" style="display: none;" id="remove" type="button"
                                    class="btn btn-danger">
                                    <em class="icon ni ni-trash"></em>
                                    &ensp;Remove
                                </button>&ensp;&ensp;
                                <input type="hidden" id="id_x">
                                <button type="button"
                                    onclick="go_to('/impoundings/print/' + document.getElementById('id_x').value )"
                                    class="btn btn-primary">
                                    <em class="icon ni ni-printer"></em>
                                    &ensp;Print
                                </button>&ensp;
                                &ensp;
                                <button type="reset" id="reset" class="btn btn-light bg-white mx-3">
                                    <em class="icon ni ni-repeat"></em>&ensp;
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <em class="icon ni ni-save"></em>&ensp;
                                    Submit Record
                                </button>
                            </div>
                        </div>
                    </form>
    
                </div>
            </div>
        </div>
    </div>
    
    <style>
        li {
            color: #000;
        }
    </style>
    
    <script>
        function updateTotal_1() {
            // Get all selected options
            let selectedOptions = document.querySelectorAll('#violation_id option:checked');
            let totalAmount = 0;
    
            selectedOptions.forEach(option => {
                // Extract text inside the option
                let text = option.textContent;
    
                // Use regex to extract the amount (like ₱ 1,000.00)
                let match = text.match(/₱\s*([0-9,]+\.\d{2})/);
    
                if (match) {
                    // Remove commas from the extracted amount and convert to float
                    let amount = parseFloat(match[1].replace(/,/g, ''));
                    totalAmount += amount;
                }
            });
    
            // Update the totalPenalty span with the formatted total amount (with commas)
            document.getElementById('totalPenalty').textContent = totalAmount.toLocaleString('en', {
                minimumFractionDigits: 2
            });
        }
    
    
        var default_id = 0;
    
        function remove_reset() {
            document.getElementById('reset').style.display = 'block';
            document.getElementById('remove').style.display = 'none';
        }
    
        function view1(id, owner, vehicle, vnumber, violations, impound, reason, fine, release, license_no, address,
            birthdate, phone, reason_of_impoundment, reason_of_impoundment_reason, incident_address, condition_x,
            storage_fee, officer_name, officer_rank, files) {

            document.getElementById('id_x').value = id;

            const filesArray = typeof files === 'string' ? JSON.parse(files) : files;

            // Reference the container
            const container = document.getElementById('file-container');

            // Clear previous content in the container (if needed)
            container.innerHTML = '';

            // Create a <table> element with Bootstrap classes
            const table = document.createElement('table');
            table.className = 'table table-bordered'; // Apply Bootstrap table classes

            // Create a table header
            const thead = document.createElement('thead');
            const headerRow = document.createElement('tr');
            const nameHeader = document.createElement('th');
            nameHeader.textContent = 'File Name';
            const linkHeader = document.createElement('th');
            linkHeader.textContent = 'Action';
            headerRow.appendChild(nameHeader);
            headerRow.appendChild(linkHeader);
            thead.appendChild(headerRow);
            table.appendChild(thead);

            // Create a table body
            const tbody = document.createElement('tbody');

            // Iterate through the filesArray and create rows
            filesArray.forEach(file => {
                const row = document.createElement('tr');

                // File name cell
                const nameCell = document.createElement('td');
                nameCell.textContent = file;

                // Action cell with a link
                const linkCell = document.createElement('td');
                const link = document.createElement('a');
                link.href = '/storage/' + file; // Set the file path as the href
                link.textContent = 'View'; // Display "Open" as the link text
                link.target = '_blank'; // Open the link in a new tab
                linkCell.appendChild(link);

                // Append cells to the row
                row.appendChild(nameCell);
                row.appendChild(linkCell);

                // Append the row to the table body
                tbody.appendChild(row);
            });

            // Append the table body to the table
            table.appendChild(tbody);

            // Append the table to the container
            container.appendChild(table);


            // document.getElementById('reset').style.display = 'none';
            // document.getElementById('remove').style.display = 'block';

            const title = document.getElementById('modal-title-label');
            const sub_title = document.getElementById('modal-sub-label');

            // Get input elements for each field
            const text_violator_name = document.getElementById('owner_name');
            const text_vehicle_type = document.getElementById('vehicle_type');
            const text_plate_number = document.getElementById('vehicle_number');

            const text_date_impound = document.getElementById('date_of_impounding');
            const text_reason_impound = document.getElementById('reason_for_impounding');
            const text_add_fine = document.getElementById('fine_amount');
            const text_date_release = document.getElementById('release_date');

            const t_license_no = document.getElementById('license_no');
            const t_address = document.getElementById('address');
            const t_birthdate = document.getElementById('birthdate');
            const t_phone = document.getElementById('phone');
            const t_reason_of_impoundment = document.getElementById('reason_of_impoundment');
            const t_reason_of_impoundment_reason = document.getElementById('reason_of_impoundment');
            const t_ncident_address = document.getElementById('incident_address');
            const t_condition_x = document.getElementById('condition_x');

            const t_officer_name = document.getElementById('officer_name');
            const t_officer_rank = document.getElementById('officer_rank');

            // 'license_no',
            // 'address',
            // 'birthdate',
            // 'phone',
            // 'reason_of_impoundment',
            // 'reason_of_impoundment_reason',
            // 'incident_address',
            // 'condition_x',

            // Set modal title
            title.innerHTML = `${vehicle}`;
            sub_title.innerHTML = `update`;

            t_officer_name.value = officer_name;
            t_officer_rank.value = officer_rank;

            // Set the values of the form inputs
            text_violator_name.value = owner;
            text_vehicle_type.value = vehicle;
            text_plate_number.value = vnumber;
            //text_violations.innerHTML = violations;
            text_date_impound.value = impound;
            text_reason_impound.value = reason;
            text_add_fine.value = storage_fee;
            text_date_release.value = release;

            t_license_no.value = license_no;
            t_address.value = address;
            t_birthdate.value = birthdate;
            t_phone.value = phone;
            //t_reason_of_impoundment.value = reason_of_impoundment;
            // t_reason_of_impoundment_reason.value = reason_of_impoundment_reason;
            t_ncident_address.value = incident_address;
            t_condition_x.value = condition_x;

            // Update the form's action attribute for submitting the changes
            var form = document.querySelector('#entries form');
            form.action = `#`;

            // Store the default ID if needed for further logic
            //console.log(violations)

            // Assuming `violations` is a JSON string, first parse it
            // Assuming `violations` is a JSON string, parse it into an array
            const violationsArray = JSON.parse(violations);

            // Reference the actual select box element by its ID 'violation_id'
            const selectBox = document.getElementById('violation_id');

            // Loop through the select box options
            for (let i = 0; i < selectBox.options.length; i++) {
                // Check if the option value exists in the violationsArray
                if (violationsArray.includes(selectBox.options[i].value)) {
                    selectBox.options[i].selected = true; // Mark as selected
                } else {
                    selectBox.options[i].selected = false; // Deselect if not in violationsArray
                }
            }

            // Trigger change event to refresh Select2 UI
            $('#violation_id').trigger('change');

            default_id = id;
        }
    
        function remove_1() {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('impounding.remove') }}',
                        type: 'POST',
                        data: {
                            id: default_id,
                            _token: "{{ csrf_token() }}" // Pass the CSRF token here
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your record has been deleted.",
                                icon: "success"
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error!",
                                text: "There was a problem deleting the record.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        }
    </script>



    {{-- <div class="modal fade" tabindex="-1" role="dialog" id="edit">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal">
                    <em class="icon ni ni-cross-sm"></em>
                </a>
                <div class="modal-body">
                    <h1 class="nk-block-title page-title text-2xl">
                        <b id="modal-title-label"></b>
                    </h1>
                    <p>You can edit citation entry to monitor the citation.</p>
                    <hr class="mt-2 mb-2">

                    <form action="" method="POST" autocomplete="off">
                        @csrf

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="ticket_number">Generate Ticket No. <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Specify the Generate Ticket No here.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-right">
                                            <em class="icon ni ni-info"></em>
                                        </div>
                                        <input type="text" id="ticket_number" required
                                            class="form-control fw-bold" readonly name="ticket_number"
                                            placeholder="Enter (Required) Generate Ticket No. here..">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="plate_number">Plate Number <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Specify the Plate Number here.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-right">
                                            <em class="icon ni ni-info"></em>
                                        </div>
                                        <input type="text" id="plate_number" required class="form-control"
                                            name="plate_number" placeholder="Enter (Required) Plate Number here..">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="violator_name">Violator Name <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Specify the Violator Name here.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-right">
                                            <em class="icon ni ni-info"></em>
                                        </div>
                                        <input type="text" id="violator_name" required class="form-control"
                                            name="violator_name" placeholder="Enter (Required) Violator Name here..">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="address">Address <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Specify the Address here.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-right">
                                            <em class="icon ni ni-info"></em>
                                        </div>
                                        <input type="text" id="address" required class="form-control"
                                            name="address" placeholder="Enter (Required) Address here..">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="date">Date <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Specify the Date of citation.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <input type="date" id="date" required class="form-control"
                                            name="date">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="municipal_ordinance_number">Municipal Ordinance
                                        Number
                                        <b class="text-danger">*</b></label>
                                    <span class="form-note">Specify the Municipal Ordinance Number here.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-right">
                                            <em class="icon ni ni-info"></em>
                                        </div>
                                        <input type="text" id="municipal_ordinance_number" required
                                            class="form-control" name="municipal_ordinance_number"
                                            placeholder="Enter (Required) Municipal Ordinance Number here..">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="specific_offense">Specific Offense <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Specify the Specific Offense here.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <select class="form-control js-select2" multiple id="specific_offense"
                                            onchange="updateTotal()" name="specific_offense[]"
                                            placeholder="Search Violation.." required>
                                            @foreach ($violations as $violation)
                                                <option value="{{ $violation->id }}">{{ $violation->violation }} (₱
                                                    {{ number_format($violation->penalty, 2) }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="violation_id">Total Penalty <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Computation of Violations.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <h1 class="text-2xl fw-bold"> ₱ <span id="totalPenalty">0.00</span></h1>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="remarks">Remarks</label>
                                    <span class="form-note">Specify any additional remarks here.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-right">
                                            <em class="icon ni ni-info"></em>
                                        </div>
                                        <input type="text" req id="remarks" class="form-control" name="remarks"
                                            placeholder="Enter any remarks here..">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label">Payment Status</label>
                                    <span class="form-note">Specify any payment status here.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-right">
                                            <em class="icon ni ni-info"></em>
                                        </div>
                                        <select name="inp_status" id="inp_status_edit" class="form-control">
                                            <option value="">Unpaid</option>
                                            <option value="Paid">Paid</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">

                        </div>
                        <div class="col-lg-8" style="float: right">
                            <hr class="mt-2 mb-2">
                        </div>

                        <div class="col-lg-5">
                        </div>
                        <div class="col-lg-7 justify-end" style="float: right">
                            <div class="form-group mt-2 mb-2 justify-end">
                                <input type="hidden" id="id_x">
                                <button type="button"
                                    onclick="go_to('/violators/print/' + document.getElementById('id_x').value )"
                                    class="btn btn-primary">
                                    <em class="icon ni ni-printer"></em>
                                    &ensp;Print
                                </button> &ensp;
                                <button type="button"
                                    onclick="go_to('/violators/impound/' + document.getElementById('id_x').value )"
                                    class="btn btn-warning">
                                    <em class="icon ni ni-truck"></em>
                                    &ensp;Impound
                                </button>&ensp;
                                <button onclick="remove()" type="button" class="btn btn-danger">
                                    <em class="icon ni ni-trash"></em>
                                    &ensp;Remove
                                </button>
                                &ensp;
                                <button type="submit" class="btn btn-info">
                                    <em class="icon ni ni-save"></em>
                                    &ensp;Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

{{-- 
    <div class="modal fade" tabindex="-1" role="dialog" id="entries">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal">
                    <em class="icon ni ni-cross-sm"></em>
                </a>
                <div class="modal-body">
                    <h1 class="nk-block-title page-title text-2xl" id="modal-title-label">
                        Add New Vehicle Impound
                    </h1>
                    <p>You can <span id="modal-sub-label">add</span> a vehicle impound entry to monitor impounding.</p>
                    <hr class="mt-2 mb-2">

                    <form action="{{ route('vehicle-impoundings.store') }}" method="POST"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf

                        <!-- Owner Name -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="license_no">License Number <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Enter here..</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="license_no" name="license_no"
                                        placeholder="Enter here..">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="owner_name">Owner Name <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Enter the owner's name.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="owner_name" name="owner_name"
                                        placeholder="Enter owner name" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="address">Address <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Enter here..</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Enter here..">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="birthdate">Birthdate <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Enter here..</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="birthdate" name="birthdate"
                                        placeholder="Enter here..">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="phone">Phone No. <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Enter here..</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Enter here..">
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Type -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="vehicle_type">Vehicle (Year/Brand/Model) <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Specify the type of vehicle.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="vehicle_type" name="vehicle_type"
                                        placeholder="Enter vehicle type" required>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Number -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="vehicle_number">Vehicle Number <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Enter the vehicle number.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="vehicle_number"
                                        name="vehicle_number" placeholder="Enter vehicle number" required>
                                </div>
                            </div>
                        </div>

                        <!-- Violation -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="violation_id">Violation <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Select the violation.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <select class="form-control js-select2" multiple id="violation_id"
                                        onchange="updateTotal1x()" name="violation_id[]"
                                        placeholder="Search Violation.." required>
                                        @foreach ($violations as $violation)
                                            <option value="{{ $violation->id }}">{{ $violation->violation }} (₱
                                                {{ number_format($violation->penalty, 2) }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Violation -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="violation_id">Total Penalty <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Computation of Violations.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <h1 class="text-2xl fw-bold"> ₱ <span id="totalPenalty_x">0.00</span></h1>
                                </div>
                            </div>
                        </div>

                        <!-- Date of Impounding -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="date_of_impounding">Date of Impounding <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Specify the date the vehicle was impounded.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="date" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}"
                                        class="form-control" id="date_of_impounding" name="date_of_impounding"
                                        required>
                                </div>
                            </div>
                        </div>

                        <h5 class="mb-3">REASON OF IMPOUNDMENT</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment" value="ACCIDENT"
                                        type="checkbox" id="accident">
                                    <label class="form-check-label" for="accident">ACCIDENT</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment" value="BURNED"
                                        type="checkbox" id="burned">
                                    <label class="form-check-label" for="burned">BURNED</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment" value="DWI"
                                        type="checkbox" id="dwi">
                                    <label class="form-check-label" for="dwi">DWI</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment" value="OTHER"
                                        type="checkbox" id="other">
                                    <label class="form-check-label" for="other">OTHER (Specify)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment" value="ABANDONED"
                                        type="checkbox" id="abandoned">
                                    <label class="form-check-label" for="abandoned">ABANDONED</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment"
                                        value="ILLEGALLY PARKED" type="checkbox" id="illegally-parked">
                                    <label class="form-check-label" for="illegally-parked">ILLEGALLY PARKED</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="reason_of_impoundment" value="STOLEN"
                                        type="checkbox" id="stolen">
                                    <label class="form-check-label" for="stolen">STOLEN</label>
                                </div>
                            </div>
                        </div>


                        <div class="mb-3">
                            <input class="form-control" rows="2" name="reason_of_impoundment_reason"
                                placeholder="Specify reason if OTHER">
                        </div>
                        <div class="mb-3" style="display: none">
                            <label for="incident_address" class="form-label">Incident Location / Address</label>
                            <input class="form-control" id="incident_address" name="incident_address" rows="2"
                                placeholder="Text box">
                        </div>
                        <div class="mb-3" style="display: none">
                            <label for="condition-of-vehicle" class="form-label">
                                Condition of Vehicle (Attach Additional pages if more space is needed)
                            </label>
                            <input class="form-control" id="condition_x" name="condition_x" rows="2"
                                placeholder="Text box">
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="incident_location">Incident Location /
                                        Address</label>
                                    <span class="form-note">Specify the incident location or address.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="incident_location"
                                        name="incident_location" placeholder="Enter the location or address" required>
                                </div>
                            </div>
                        </div>



                        <!-- Attach Images / Photo -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="photo_attachment">Attach Images / Photos</label>
                                    <span class="form-note">Attach images here.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="file" class="form-control" accept=".jpg, .png, .jpeg, .gif"
                                        id="photo_attachment" name="photo_attachment[]" multiple>
                                </div>
                            </div>
                        </div>

                        <!-- Reason for Impounding -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="reason_for_impounding">Reason for
                                        Impounding</label>
                                    <span class="form-note">Provide the reason for impounding (if any).</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="reason_for_impounding"
                                        name="reason_for_impounding" placeholder="Enter reason (optional)">
                                </div>
                            </div>
                        </div>

                        <!-- Fine Amount -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="fine_amount">Storage Fee</label>
                                    <span class="form-note">Specify the fine amount (if applicable).</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="number" step="0.01" class="form-control" id="fine_amount"
                                        name="fine_amount" placeholder="Enter fine amount (optional)">
                                </div>
                            </div>
                        </div>

                        <!-- Release Date -->

                        <div class="row mt-2 align-center" style="display: none">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="officer_name">Officer Name</label>
                                    <span class="form-note">Specify the officer name (optional).</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="officer_name"
                                        name="officer_name">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center" style="display: none">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="officer_rank">Officer Rank</label>
                                    <span class="form-note">Specify the officer rank (optional).</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="officer_rank"
                                        name="officer_rank">
                                </div>
                            </div>
                        </div>


                        <div class="row mt-2 align-center" style="display: none">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="release_date">Release Date</label>
                                    <span class="form-note">Specify the release date (optional).</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="date" class="form-control" id="release_date"
                                        name="release_date">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="document_attachment">Supporting Documents</label>
                                    <span class="form-note">Attach supporting documents (optional).</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-control-wrap">
                                    <input type="file" class="form-control" id="document_attachment"
                                        name="document_attachment[]" multiple>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-12">
                                <hr class="mt-4 mb-4">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div id="file-container"></div>
                            </div>
                        </div>

                        <div class="row mt-2 align-center">
                            <div class="col-lg-12">
                                <hr class="mb-4">
                            </div>
                        </div>



                        <!-- Buttons -->
                        <div class="col-lg-4"></div>
                        <div class="col-lg-8" style="float: right">
                            <div class="form-group mt-2 mb-2 justify-end">
                                <input type="hidden" id="id_x">
                                <button type="button"
                                    onclick="go_to('/impoundings/print/' + document.getElementById('id_x').value )"
                                    class="btn btn-primary">
                                    <em class="icon ni ni-printer"></em>
                                    &ensp;Print
                                </button>&ensp;
                                &ensp;
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function updateTotal() {
            // Get all selected options
            let selectedOptions = document.querySelectorAll('#specific_offense option:checked');
            let totalAmount = 0;

            selectedOptions.forEach(option => {
                // Extract text inside the option
                let text = option.textContent;

                // Use regex to extract the amount (like ₱ 1,000.00)
                let match = text.match(/₱\s*([0-9,]+\.\d{2})/);

                if (match) {
                    // Remove commas from the extracted amount and convert to float
                    let amount = parseFloat(match[1].replace(/,/g, ''));
                    totalAmount += amount;
                }
            });

            // Update the totalPenalty span with the formatted total amount (with commas)
            document.getElementById('totalPenalty').textContent = totalAmount.toLocaleString('en', {
                minimumFractionDigits: 2
            });
        }

        function updateTotal1() {
            // Get all selected options
            let selectedOptions = document.querySelectorAll('#specific_offense_1 option:checked');
            let totalAmount = 0;

            selectedOptions.forEach(option => {
                // Extract text inside the option
                let text = option.textContent;

                // Use regex to extract the amount (like ₱ 1,000.00)
                let match = text.match(/₱\s*([0-9,]+\.\d{2})/);

                if (match) {
                    // Remove commas from the extracted amount and convert to float
                    let amount = parseFloat(match[1].replace(/,/g, ''));
                    totalAmount += amount;
                }
            });

            // Update the totalPenalty span with the formatted total amount (with commas)
            document.getElementById('totalPenalty1').textContent = totalAmount.toLocaleString('en', {
                minimumFractionDigits: 2
            });
        }

        var default_id = 0;

        function view(id, plate_number, violator_name, address, date, municipal_ordinance_number, specific_offense,
            remarks, status) {

            const title = document.getElementById('modal-title-label');

            // Get input elements for each field
            document.getElementById('ticket_number').value = Number(id) + 1000000;
            document.getElementById('id_x').value = id;

            const text_plate_number = document.getElementById('plate_number');
            const text_violator_name = document.getElementById('violator_name');
            const text_address = document.getElementById('address');
            const text_date = document.getElementById('date');
            const text_municipal_ordinance_number = document.getElementById('municipal_ordinance_number');
            //const text_specific_offense = document.getElementById('specific_offense');
            const text_remarks = document.getElementById('remarks');
            const text_status = document.getElementById('inp_status_edit');

            // Set modal title
            title.innerHTML = ` ${violator_name}`;

            // Set the values of the form inputs
            text_plate_number.value = plate_number;
            text_violator_name.value = violator_name;
            text_address.value = address;
            text_date.value = date;
            text_municipal_ordinance_number.value = municipal_ordinance_number;
            //text_specific_offense.value = specific_offense;
            text_remarks.value = remarks;
            text_status.value = status;

            // Update the form's action attribute for submitting the changes
            var form = document.querySelector('#edit form');
            form.action = `#`;

            const violationsArray = JSON.parse(specific_offense);

            // Reference the actual select box element by its ID 'violation_id'
            const selectBox = document.getElementById('specific_offense');

            // Loop through the select box options
            for (let i = 0; i < selectBox.options.length; i++) {
                // Check if the option value exists in the violationsArray
                if (violationsArray.includes(selectBox.options[i].value)) {
                    selectBox.options[i].selected = true; // Mark as selected
                    console.log(violationsArray)
                } else {
                    selectBox.options[i].selected = false; // Deselect if not in violationsArray
                }
            }
            $('#specific_offense').trigger('change');

            // Store the default ID if needed for further logic
            default_id = id;
        }

        function remove() {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('citations.remove') }}',
                        type: 'POST',
                        data: {
                            id: default_id,
                            _token: "{{ csrf_token() }}" // Pass the CSRF token here
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your record has been deleted.",
                                icon: "success"
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error!",
                                text: "There was a problem deleting the record.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        }
    </script>


    <script>
        function updateTotal1x() {
            // Get all selected options
            let selectedOptions = document.querySelectorAll('#violation_id option:checked');
            let totalAmount = 0;

            selectedOptions.forEach(option => {
                // Extract text inside the option
                let text = option.textContent;

                // Use regex to extract the amount (like ₱ 1,000.00)
                let match = text.match(/₱\s*([0-9,]+\.\d{2})/);

                if (match) {
                    // Remove commas from the extracted amount and convert to float
                    let amount = parseFloat(match[1].replace(/,/g, ''));
                    totalAmount += amount;
                }
            });

            // Update the totalPenalty span with the formatted total amount (with commas)
            document.getElementById('totalPenalty_x').textContent = totalAmount.toLocaleString('en', {
                minimumFractionDigits: 2
            });
        }


        var default_id = 0;

        function remove_reset() {
            // document.getElementById('reset').style.display = 'block';
            // document.getElementById('remove').style.display = 'none';
        }

        function view1(id, owner, vehicle, vnumber, violations, impound, reason, fine, release, license_no, address,
            birthdate, phone, reason_of_impoundment, reason_of_impoundment_reason, incident_address, condition_x,
            storage_fee, officer_name, officer_rank, files) {

            document.getElementById('id_x').value = id;

            const filesArray = typeof files === 'string' ? JSON.parse(files) : files;

            // Reference the container
            const container = document.getElementById('file-container');

            // Clear previous content in the container (if needed)
            container.innerHTML = '';

            // Create a <table> element with Bootstrap classes
            const table = document.createElement('table');
            table.className = 'table table-bordered'; // Apply Bootstrap table classes

            // Create a table header
            const thead = document.createElement('thead');
            const headerRow = document.createElement('tr');
            const nameHeader = document.createElement('th');
            nameHeader.textContent = 'File Name';
            const linkHeader = document.createElement('th');
            linkHeader.textContent = 'Action';
            headerRow.appendChild(nameHeader);
            headerRow.appendChild(linkHeader);
            thead.appendChild(headerRow);
            table.appendChild(thead);

            // Create a table body
            const tbody = document.createElement('tbody');

            // Iterate through the filesArray and create rows
            filesArray.forEach(file => {
                const row = document.createElement('tr');

                // File name cell
                const nameCell = document.createElement('td');
                nameCell.textContent = file;

                // Action cell with a link
                const linkCell = document.createElement('td');
                const link = document.createElement('a');
                link.href = '/storage/' + file; // Set the file path as the href
                link.textContent = 'View'; // Display "Open" as the link text
                link.target = '_blank'; // Open the link in a new tab
                linkCell.appendChild(link);

                // Append cells to the row
                row.appendChild(nameCell);
                row.appendChild(linkCell);

                // Append the row to the table body
                tbody.appendChild(row);
            });

            // Append the table body to the table
            table.appendChild(tbody);

            // Append the table to the container
            container.appendChild(table);


            // document.getElementById('reset').style.display = 'none';
            // document.getElementById('remove').style.display = 'block';

            const title = document.getElementById('modal-title-label');
            const sub_title = document.getElementById('modal-sub-label');

            // Get input elements for each field
            const text_violator_name = document.getElementById('owner_name');
            const text_vehicle_type = document.getElementById('vehicle_type');
            const text_plate_number = document.getElementById('vehicle_number');

            const text_date_impound = document.getElementById('date_of_impounding');
            const text_reason_impound = document.getElementById('reason_for_impounding');
            const text_add_fine = document.getElementById('fine_amount');
            const text_date_release = document.getElementById('release_date');

            const t_license_no = document.getElementById('license_no');
            const t_address = document.getElementById('address');
            const t_birthdate = document.getElementById('birthdate');
            const t_phone = document.getElementById('phone');
            const t_reason_of_impoundment = document.getElementById('reason_of_impoundment');
            const t_reason_of_impoundment_reason = document.getElementById('reason_of_impoundment');
            const t_ncident_address = document.getElementById('incident_address');
            const t_condition_x = document.getElementById('condition_x');

            const t_officer_name = document.getElementById('officer_name');
            const t_officer_rank = document.getElementById('officer_rank');

            // 'license_no',
            // 'address',
            // 'birthdate',
            // 'phone',
            // 'reason_of_impoundment',
            // 'reason_of_impoundment_reason',
            // 'incident_address',
            // 'condition_x',

            // Set modal title
            title.innerHTML = `${vehicle}`;
            sub_title.innerHTML = `update`;

            t_officer_name.value = officer_name;
            t_officer_rank.value = officer_rank;

            // Set the values of the form inputs
            text_violator_name.value = owner;
            text_vehicle_type.value = vehicle;
            text_plate_number.value = vnumber;
            //text_violations.innerHTML = violations;
            text_date_impound.value = impound;
            text_reason_impound.value = reason;
            text_add_fine.value = storage_fee;
            text_date_release.value = release;

            t_license_no.value = license_no;
            t_address.value = address;
            t_birthdate.value = birthdate;
            t_phone.value = phone;
            //t_reason_of_impoundment.value = reason_of_impoundment;
            // t_reason_of_impoundment_reason.value = reason_of_impoundment_reason;
            t_ncident_address.value = incident_address;
            t_condition_x.value = condition_x;

            // Update the form's action attribute for submitting the changes
            var form = document.querySelector('#entries form');
            form.action = `#`;

            // Store the default ID if needed for further logic
            //console.log(violations)

            // Assuming `violations` is a JSON string, first parse it
            // Assuming `violations` is a JSON string, parse it into an array
            const violationsArray = JSON.parse(violations);

            // Reference the actual select box element by its ID 'violation_id'
            const selectBox = document.getElementById('violation_id');

            // Loop through the select box options
            for (let i = 0; i < selectBox.options.length; i++) {
                // Check if the option value exists in the violationsArray
                if (violationsArray.includes(selectBox.options[i].value)) {
                    selectBox.options[i].selected = true; // Mark as selected
                } else {
                    selectBox.options[i].selected = false; // Deselect if not in violationsArray
                }
            }

            // Trigger change event to refresh Select2 UI
            $('#violation_id').trigger('change');

            default_id = id;
        }

        function remove() {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('impounding.remove') }}',
                        type: 'POST',
                        data: {
                            id: default_id,
                            _token: "{{ csrf_token() }}" // Pass the CSRF token here
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your record has been deleted.",
                                icon: "success"
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error!",
                                text: "There was a problem deleting the record.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        }
    </script> --}}


</x-app-layout>
