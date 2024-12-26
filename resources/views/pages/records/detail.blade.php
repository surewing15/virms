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
                        <img src="http://127.0.0.1:8000/storage/no.jpg"
                            style="width: 185px !important; height: 180px; border-radius: 50%; object-fit: cover; ">
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
                                        @foreach ($min_cites as $index => $entry)
                                            @php
                                                $get_violations = json_decode($entry->specific_offense, true);
                                                $check_once = 0;
                                                $violation = '';
                                                $total_fine = 0;
                                                // Check if decoding was successful
                                                if ($get_violations !== null) {
                                                    // Iterate through the array and access each violation ID
                                                    foreach ($get_violations as $violation_id) {
                                                        $violation = ViolationEntries::select(
                                                            'violation as name',
                                                            'penalty',
                                                        )
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
                                                    $deadlineDate > $currentDate
                                                        ? $difference->days
                                                        : $difference->days;
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
                                                <td class="pt-2 fw-bold text-dark">₱
                                                    {{ number_format($total_fine, 2) }}</td>
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
                                                        $violation = ViolationEntries::select(
                                                            'violation as name',
                                                            'penalty',
                                                        )
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
                                                    $deadlineDate > $currentDate
                                                        ? $difference->days
                                                        : $difference->days;

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
                                                onclick="view12('{{ $entry->id }}', '{{ $entry->owner_name }}', '{{ $entry->vehicle_type }}', '{{ $entry->vehicle_number }}', '{{ $entry->violation_id }}', '{{ $entry->date_of_impounding }}', '{{ $entry->reason_for_impounding }}', '{{ $entry->fine_amount }}', '{{ $entry->release_date }}', '{{ $entry->license_no }}', '{{ $entry->address }}', '{{ $entry->birthdate }}', '{{ $entry->phone }}', '{{ $entry->reason_of_impoundment }}', '{{ $entry->reason_of_impoundment_reason }}', '{{ $entry->incident_address }}', '{{ $entry->condition_x }}', '{{ $storage_fee }}', '{{ $entry->officer_name }}', '{{ $entry->officer_rank }}', '{{ $entry->photo_attachment }}')"
                                                data-bs-toggle="modal" data-bs-target="#entries12">
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
                                                <td class="pt-2 fw-bold text-dark">₱
                                                    {{ number_format($total_fine, 2) }}</td>
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



    <div class="modal fade" tabindex="-1" role="dialog" id="edit">
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
                                        <input type="text" id="plate_number_edit" required class="form-control"
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
                                        Number</label>
                                    <span class="form-note">Specify the Municipal Ordinance Number here.</span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-right">
                                            <em class="icon ni ni-info"></em>
                                        </div>
                                        <input type="text" id="municipal_ordinance_number" class="form-control"
                                            name="municipal_ordinance_number"
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
                                    onclick="go_to('/citations/print/' + document.getElementById('id_x').value )"
                                    class="btn btn-primary">
                                    <em class="icon ni ni-printer"></em>
                                    &ensp;Print
                                </button>&ensp;
                                <button type="button"
                                    onclick="go_to('/violators/impound/' + document.getElementById('id_x').value )"
                                    class="btn btn-warning">
                                    <em class="icon ni ni-truck"></em>
                                    &ensp;Impound
                                </button>&ensp;
                                @if (Auth::user()->account_type != 'Officer')
                                    <button onclick="remove()" type="button" class="btn btn-danger">
                                        <em class="icon ni ni-trash"></em>
                                        &ensp;Remove
                                    </button>
                                    &ensp;
                                    <button type="submit" class="btn btn-info">
                                        <em class="icon ni ni-save"></em>
                                        &ensp;Save Changes
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="entries12">
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
                                        onchange="updateTotal_1()" name="violation_id[]"
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
                                    <h1 class="text-2xl fw-bold"> ₱ <span id="totalPenalty1">0.00</span></h1>
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
        // Initialize jQuery UI Autocomplete for plate numbers
        $(document).ready(function() {
            // Create a mapping of violator names to their addresses
            const violatorData = {
                @foreach (App\Models\TrafficCitation::select('violator_name', 'address')->distinct()->get() as $data)
                    "{{ $data->violator_name }}": "{{ $data->address }}",
                @endforeach
            };

            // Initialize autocomplete with modified select event
            $("#autocompleteInput").autocomplete({
                source: Object.keys(violatorData),
                minLength: 1,
                autoFocus: true,
                select: function(event, ui) {
                    // When a name is selected, populate the address field
                    $("#violatorAddress").val(violatorData[ui.item.value]);
                },
                open: function() {
                    $(".ui-autocomplete").css({
                        "z-index": 1051,
                        "width": $(this).outerWidth() + "px"
                    });
                }
            }).focus(function() {
                $(this).autocomplete("search", "");
            });

            // Update address when input changes without selection
            $("#autocompleteInput").on('change', function() {
                const selectedName = $(this).val();
                if (violatorData[selectedName]) {
                    $("#violatorAddress").val(violatorData[selectedName]);
                }
            });

            // Plate number autocomplete
            const plateRecords = [
                @foreach (App\Models\TrafficCitation::select('plate_number')->distinct()->get() as $data)
                    "{{ $data->plate_number }}",
                @endforeach
            ];

            function initializePlateAutocomplete(selector) {
                $(selector).autocomplete({
                    source: plateRecords,
                    minLength: 1,
                    autoFocus: true,
                    open: function() {
                        $(".ui-autocomplete").css({
                            "z-index": 1051,
                            "width": $(this).outerWidth() + "px"
                        });
                    }
                }).focus(function() {
                    $(this).autocomplete("search", "");
                });
            }

            // Initialize for both plate number inputs
            initializePlateAutocomplete("#plate_number_edit");
            initializePlateAutocomplete("input[name='plate_number']");

            // Re-initialize when modals open
            $('#edit').on('shown.bs.modal', function() {
                initializePlateAutocomplete("#plate_number_edit");
            });
            $('#entries').on('shown.bs.modal', function() {
                initializePlateAutocomplete("input[name='plate_number']");
            });
        });

        // Update total for traffic citations
        // function updateTotal() {
        //     let selectedOptions = document.querySelectorAll('#specific_offense option:checked');
        //     let totalAmount = 0;

        //     selectedOptions.forEach(option => {
        //         let match = option.textContent.match(/₱\s*([0-9,]+\.\d{2})/);
        //         if (match) {
        //             let amount = parseFloat(match[1].replace(/,/g, ''));
        //             totalAmount += amount;
        //         }
        //     });

        //     document.getElementById('totalPenalty').textContent = totalAmount.toLocaleString('en', {
        //         minimumFractionDigits: 2
        //     });
        // }
        function updateTotal() {
            let selectedOptions = document.querySelectorAll('#specific_offense option:checked');
            let totalAmount = 0;

            selectedOptions.forEach(option => {
                let text = option.textContent;
                let match = text.match(/₱\s*([0-9,]+\.\d{2})/);
                if (match) {
                    let amount = parseFloat(match[1].replace(/,/g, ''));
                    totalAmount += amount;
                }
            });

            // Update total display - Make sure this ID matches your HTML
            $('#totalPenalty').text(totalAmount.toLocaleString('en', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));

            // If you have a hidden input for the total, update it as well
            $('input[name="total_penalty"]').val(totalAmount);
        }

        // Update total for vehicle impounding
        function updateTotal_1() {
            let selectedOptions = document.querySelectorAll('#violation_id option:checked');
            let totalAmount = 0;

            selectedOptions.forEach(option => {
                let text = option.textContent;
                let match = text.match(/₱\s*([0-9,]+\.\d{2})/);
                if (match) {
                    let amount = parseFloat(match[1].replace(/,/g, ''));
                    totalAmount += amount;
                }
            });

            // Update total display - Make sure this ID matches your HTML
            $('#totalPenalty').text(totalAmount.toLocaleString('en', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));

            // If you have a hidden input for the total, update it as well
            $('input[name="total_penalty"]').val(totalAmount);
        }


        // View traffic citation details
        function view(id, plate_number, violator_name, address, date, municipal_ordinance_number, specific_offense, remarks,
            status) {
            const title = document.getElementById('modal-title-label');

            // Generate ticket number
            const currentDate = new Date();
            const year = currentDate.getFullYear();
            const month = String(currentDate.getMonth() + 1).padStart(2, '0');
            document.getElementById('ticket_number').value = `${year}${month}${id}`;
            document.getElementById('id_x').value = id;

            // Set form values
            document.getElementById('plate_number_edit').value = plate_number;
            document.getElementById('violator_name').value = violator_name;
            document.getElementById('address').value = address;
            document.getElementById('date').value = date;
            document.getElementById('municipal_ordinance_number').value = municipal_ordinance_number;
            document.getElementById('remarks').value = remarks;
            document.getElementById('inp_status_edit').value = status;

            // Set modal title
            title.innerHTML = `Edit Traffic Citation for: ${violator_name}`;

            // Update form action
            const form = document.querySelector('#edit form');
            form.action = `/citations/update/${id}`;

            // Handle violations
            try {
                const violationsArray = JSON.parse(specific_offense);
                const selectBox = document.getElementById('specific_offense');

                Array.from(selectBox.options).forEach(option => {
                    option.selected = violationsArray.includes(option.value);
                });

                $('#specific_offense').trigger('change');
            } catch (e) {
                console.error('Error handling violations:', e);
            }

            // Store ID for other operations
            window.default_id = id;
        }

        // View vehicle impounding details
        // Let's add console logs to debug
        function view12(id, owner, vehicle, vnumber, violations, impound, reason, fine, release, license_no, address,
            birthdate, phone, reason_of_impoundment, reason_of_impoundment_reason, incident_address, condition_x,
            storage_fee, officer_name, officer_rank, files) {

            console.log("Function parameters:", {
                id,
                owner,
                vehicle,
                vnumber,
                violations,
                impound,
                reason,
                fine,
                release,
                license_no,
                address,
                birthdate,
                phone,
                reason_of_impoundment,
                reason_of_impoundment_reason,
                incident_address,
                condition_x,
                storage_fee,
                officer_name,
                officer_rank,
                files
            });

            // Set form field values directly
            document.getElementById('license_no').value = license_no || '';
            document.getElementById('owner_name').value = owner || '';
            document.getElementById('address').value = address || '';
            document.getElementById('birthdate').value = birthdate || '';
            document.getElementById('phone').value = phone || '';
            document.getElementById('vehicle_type').value = vehicle || '';
            document.getElementById('vehicle_number').value = vnumber || '';
            document.getElementById('date_of_impounding').value = impound || '';
            document.getElementById('reason_for_impounding').value = reason || '';
            document.getElementById('fine_amount').value = storage_fee || '';

            // Handle violations
            try {
                const violationsArray = typeof violations === 'string' ? JSON.parse(violations) : violations || [];
                const selectBox = document.getElementById('violation_id');

                if (selectBox) {
                    // Clear previous selections
                    $(selectBox).val(null);

                    // Set new selections
                    $(selectBox).val(violationsArray);

                    // If using Select2, trigger the change
                    if ($.fn.select2) {
                        $(selectBox).trigger('change');
                    }

                    // Update total
                    updateTotal_1();
                }
            } catch (e) {
                console.error('Error handling violations:', e);
            }

            // Handle reason checkboxes
            if (reason_of_impoundment) {
                try {
                    const reasons = typeof reason_of_impoundment === 'string' ?
                        JSON.parse(reason_of_impoundment) :
                        reason_of_impoundment;

                    // Clear all checkboxes first
                    document.querySelectorAll('input[name="reason_of_impoundment"]')
                        .forEach(cb => cb.checked = false);

                    // Check appropriate boxes
                    if (Array.isArray(reasons)) {
                        reasons.forEach(r => {
                            const checkbox = document.querySelector(
                                `input[name="reason_of_impoundment"][value="${r}"]`);
                            if (checkbox) checkbox.checked = true;
                        });
                    }
                } catch (e) {
                    console.error('Error setting reason checkboxes:', e);
                }
            }

            // Set reason text if it exists
            if (reason_of_impoundment_reason) {
                document.querySelector('input[name="reason_of_impoundment_reason"]').value = reason_of_impoundment_reason;
            }

            // Update modal title
            const modalTitle = document.getElementById('modal-title-label');
            if (modalTitle) modalTitle.textContent = `Vehicle Details: ${vehicle}`;
        }

        // Remove traffic citation
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
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your record has been deleted.",
                                icon: "success"
                            });
                            setTimeout(() => location.reload(), 1000);
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

        // Remove vehicle impounding
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
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your record has been deleted.",
                                icon: "success"
                            });
                            setTimeout(() => location.reload(), 1000);
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

        // Reset function for vehicle impounding
        function remove_reset() {
            document.getElementById('reset').style.display = 'block';
            document.getElementById('remove').style.display = 'none';
        }

        // Print citation
        function printCitation(id) {
            $.ajax({
                url: `/citations/print/${id}`,
                method: 'GET',
                success: function(response) {
                    let printWindow = window.open('', '_blank');
                    printWindow.document.write(response);

                    printWindow.document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(() => {
                            printWindow.print();
                        }, 500);
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to load print data.",
                        icon: "error"
                    });
                }
            });
        }
        // Make sure this function is being called when violations are selected
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

            // Add console.log to debug
            console.log("Total Amount:", totalAmount);

            // Update both displays
            const totalPenaltyElement = document.getElementById('totalPenalty');
            const totalPenalty1Element = document.getElementById('totalPenalty1');

            if (totalPenaltyElement) {
                totalPenaltyElement.textContent = totalAmount.toLocaleString('en', {
                    minimumFractionDigits: 2
                });
            }

            if (totalPenalty1Element) {
                totalPenalty1Element.textContent = totalAmount.toLocaleString('en', {
                    minimumFractionDigits: 2
                });
            }

            // Also update any hidden input if it exists
            const hiddenInput = document.querySelector('input[name="total_penalty"]');
            if (hiddenInput) {
                hiddenInput.value = totalAmount;
            }
        }

        // Make sure the change event is properly bound
        $(document).ready(function() {
            $('#violation_id').on('select2:select select2:unselect', function(e) {
                updateTotal_1();
            });
        });

        // Make sure the select element has the correct event handler
        $(document).ready(function() {
            $('#violation_id').on('change', function() {
                updateTotal_1();
            });
        });
    </script>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="path/to/sweetalert2.js"></script>
    <script src="path/to/select2.min.js"></script> <!-- if using Select2 -->

</x-app-layout>
