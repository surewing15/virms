<x-app-layout>
    <x-slot name="back"></x-slot>
    <x-slot name="header">{{ __('Manage Account') }}</x-slot>
    <x-slot name="subHeader">{{ __('You can manager your account and register new account here.') }}</x-slot>
    <x-slot name="btn"></x-slot>

    <div class= "nk-block">
        <div class="row g-gs">
            <div class= "col-md-12">
                <div class= "card">
                    <div class= "card-inner">
                        <table class="datatable-init table table-hover">
                            <thead>
                                <tr>
                                    <th width="80">#</th>
                                    <th>Complete Name</th>
                                    <th width="200">Email Address</th>
                                    <th width="180">Account Type</th>
                                    <th width="100" style="font-size: 13px;">
                                        <center>Actions</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $num = 1;
                                @endphp
                                @foreach ($accounts as $user)
                                    <tr>
                                        <td class="pt-2">{{ $num++ }}.</td>
                                        <td class="pt-2">{{ $user->name }}</td>
                                        <td class="pt-2">{{ $user->email }}</td>
                                        <td class="pt-2">{{ $user->account_type }}</td>
                                        <td>
                                            @if ($user->email == Auth::user()->email)
                                                <center>
                                                    <button disabled class="btn btn-sm btn-danger ">
                                                        <em class="icon ni ni-trash"></em>
                                                    </button>
                                                </center>
                                            @else
                                                <center>
                                                    <a href="#"
                                                        onclick="confirmation({{ $user->id }}, 'user')"
                                                        class="btn btn-sm btn-danger ">
                                                        <em class="icon ni ni-trash"></em>
                                                    </a>
                                                </center>
                                            @endif
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

</x-app-layout>
