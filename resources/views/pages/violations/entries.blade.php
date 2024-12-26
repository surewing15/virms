<x-app-layout>
    <x-slot name="back"></x-slot>
    <x-slot name="header">{{ __('Manage Violation Entries') }}</x-slot>
    <x-slot name="subHeader">{{ __('You can manage your violetion entries and register new entry here.') }}</x-slot>
    <x-slot name="btn">
        @if (Auth::user()->account_type != 'Officer')
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#entries"
                        class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                            class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li class="nk-block-tools-opt d-none d-sm-block">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#entries"
                                    class="btn btn-primary">
                                    <em class="icon ni ni-plus"></em>
                                    <span>Add New</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
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
                                <th>Violation</th>
                                <th width="150">Penalty</th>
                                <th width="230">Created At</th>
                                <th width="230">Updated At</th>
                                <th width="100" class="text-center">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($violations as $index => $entry)
                                    <tr style="cursor: pointer;"
                                        onclick="view({{ $entry->id }}, '{{ $entry->violation }}', '{{ $entry->penalty }}')"
                                        data-bs-toggle="modal" data-bs-target="#edit">
                                        <td>{{ $index + 1 }}.</td>
                                        <td>{{ $entry->violation }}</td>
                                        <td>₱ {{ number_format($entry->penalty, 2) }}</td>
                                        <td>{{ date_format($entry->created_at, 'D, M. d, Y h:i A') }}</td>
                                        <td>{{ date_format($entry->updated_at, 'D, M. d, Y h:i A') }}</td>
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

    @include('pages.violations.modals.modal')

</x-app-layout>
