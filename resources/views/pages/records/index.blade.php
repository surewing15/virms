@php
    use App\Models\ViolationEntries;
@endphp
<x-app-layout>
    <x-slot name="back"></x-slot>
    <x-slot name="header">{{ __('Manage Violator') }}</x-slot>
    <x-slot name="subHeader">{{ __('You can manage the violator here.') }}</x-slot>
    <x-slot name="btn"></x-slot>

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
                                <th>Violator</th>
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
                                    <tr style="cursor: pointer;" onclick="go_to('/violators/detail/{{ $entry->violator_name }}')">
                                        <td>{{ $index + 1 }}.</td>
                                        <td>{{ $entry->violator_name }}</td>
                                        <td>
                                            <button class="btn btn-block btn-xs btn-light btn-white text-dark">
                                                <em class="icon ni ni-eye"></em>
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
