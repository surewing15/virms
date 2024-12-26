<x-app-layout>
    <x-slot name="back"></x-slot>
    <x-slot name="header">{{ __('Manage Employee') }}</x-slot>
    <x-slot name="subHeader">{{ __('You can manager your employee and register new employee here.') }}</x-slot>
    <x-slot name="btn">
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                        class="icon ni ni-menu-alt-r"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt d-none d-sm-block">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#registration"
                                class="btn btn-info"><em class="icon ni ni-plus"></em><span>Add New
                                    Employee</span></a>
                        </li>
                        <li class="nk-block-tools-opt d-block d-sm-none">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#registration"
                                class="btn btn-icon btn-primary"><em class="icon ni ni-plus"></em></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>

    <div class= "nk-block">
        <div class="row g-gs">
            <div class= "col-md-12">
                <div class= "card">
                    <div class= "card-inner">
                        <table class="datatable-init table table-hover">
                            <thead>
                                <tr>
                                    <th width="80">#</th>
                                    <th>Employee Name</th>
                                    <th>Position</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $num = 1;
                                @endphp
                                @foreach ($employee as $data)
                                    <tr style="cursor: pointer">
                                        <td>{{ $num++ }}.</td>
                                        <td> {{ $data->employee_name }}</td>
                                        <td>{{ $data->position }}</td>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="registration">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal">
                    <em class="icon ni ni-cross-sm"></em>
                </a>
                <div class="modal-body">
                    <h1 class="nk-block-title page-title text-2xl">
                        Register Employee
                    </h1>
                    <p>You can create new employee to monitor your people.</p>
                    <hr class="mt-2 mb-2">

                    <form action="{{ route('employee.save') }}" method="POST">
                        @csrf
                        <!--  Name -->
                        <div class="row mt-2 align-center">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-label" for="inp_en">Employee Name <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Specify the Employee Name here.</span>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="inp_en" name="inp_en"
                                        placeholder="Enter the Employee Name here ..." required>

                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 align-center">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-label" for="inp_position">Position <b
                                            class="text-danger">*</b></label>
                                    <span class="form-note">Specify the Employee Name here.</span>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" id="inp_position" name="inp_position"
                                        placeholder="Enter the Position here ..." required>

                                </div>
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="row mt-4">
                            <div class="col-lg-5"></div>
                            <div class="col-lg-7">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <em class="icon ni ni-save"></em>&ensp;
                                    Submit New Employee
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
