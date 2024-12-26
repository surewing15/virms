@php
    use App\Models\ViolationEntries;
@endphp
<x-app-layout>
    <x-slot name="back"></x-slot>
    <x-slot name="header">{{ __('Manage Vehicle Impounding`s') }}</x-slot>
    <x-slot name="subHeader">{{ __('You can manage the vehicle impoundings and register new vehicle here.') }}</x-slot>
    <x-slot name="btn">
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" data-bs-toggle="modal" data-bs-target="#entries"
                    class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                        class="icon ni ni-menu-alt-r"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt d-none d-sm-block">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#entries" class="btn btn-danger"
                                onclick="remove_reset()">
                                <em class="icon ni ni-plus"></em>
                                <span>Add New Record</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>

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
                                @php
                                    $storage_fee_x = 0;
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
                                        onclick="view({{ $entry->id }}, '{{ $entry->owner_name }}', '{{ $entry->vehicle_type }}', '{{ $entry->vehicle_number }}', '{{ $entry->violation_id }}', '{{ $entry->date_of_impounding }}', '{{ $entry->reason_for_impounding }}', '{{ $entry->fine_amount }}', '{{ $entry->release_date }}', '{{ $entry->license_no }}', '{{ $entry->address }}', '{{ $entry->birthdate }}', '{{ $entry->phone }}', '{{ $entry->reason_of_impoundment }}', '{{ $entry->reason_of_impoundment_reason }}', '{{ $entry->incident_location }}', '{{ $entry->condition_x }}', '{{ $storage_fee }}', '{{ $entry->officer_name }}', '{{ $entry->officer_rank }}', '{{ $entry->document_attachment }}', '{{ $entry->photo_attachment }}')"
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
                                                @if ($entry->release_date)
                                                    ₱ {{ number_format($storage_fee_x, 2) }}
                                                @else
                                                    ₱ {{ number_format($d * 50, 2) }}
                                                @endif
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

    @include('pages.impoundings.modals.modal')

</x-app-layout>
