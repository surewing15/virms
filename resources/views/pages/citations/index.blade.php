@php
    use App\Models\ViolationEntries;
@endphp
<x-app-layout>
    <x-slot name="back"></x-slot>
    <x-slot name="header">{{ __('Manage Traffic Citation') }}</x-slot>
    <x-slot name="subHeader">{{ __('You can manage the traffic citations and register new citations here.') }}</x-slot>
    <x-slot name="btn">
        <div class="nk-block-head-content">
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
                        <table class="datatable-init table table-hover">
                            <thead>
                                <th width="50">#</th>
                                <th width="150">Ordinance No.</th>
                                <th>Violator</th>
                                <th>Specific Offense</th>
                                <th width="150">Total Fine</th>
                                <th width="150">Plate Number</th>
                                <th width="150">Remarks</th>
                                <th width="100">Status</th>
                                <th width="230">Updated At</th>
                                <th width="100" class="text-center">Action</th>
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
                                        onclick="view({{ $entry->id }}, '{{ addslashes($entry->plate_number) }}', '{{ addslashes($entry->violator_name) }}', '{{ addslashes($entry->address) }}', '{{ $entry->date }}', '{{ $entry->municipal_ordinance_number }}', '{{ addslashes($entry->specific_offense) }}', '{{ addslashes($entry->remarks) }}', '{{ $entry->status }}')"
                                        data-bs-toggle="modal" data-bs-target="#edit">
                                        <td>{{ $index + 1 }}.</td>
                                        <td>{{ $entry->municipal_ordinance_number }}</td>
                                        <td>{{ $entry->violator_name }}</td>
                                        <td>
                                            <ul class="project-users g-1">
                                                <li>
                                                    {{ $violation->name ?? null }}
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
                                        <td>{{ $entry->remarks }}</td>
                                        <td>
                                            <span style="width: 100%"
                                                class="badge badge-sm badge-dot has-bg bg-{{ $entry->status ? 'success' : 'danger' }} d-none d-sm-inline-flex">
                                                {{ $entry->status ? 'Paid' : 'Unpaid' }}
                                            </span>
                                        </td>
                                        <td>{{ date_format($entry->created_at, 'D, M. d, Y h:i A') }}</td>
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
    @include('pages.citations.modals.modal')

</x-app-layout>
