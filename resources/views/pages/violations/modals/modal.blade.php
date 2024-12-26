<div class="modal fade" tabindex="-1" role="dialog" id="entries">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal">
                <em class="icon ni ni-cross-sm"></em>
            </a>
            <div class="modal-body">
                <h1 class="nk-block-title page-title text-2xl">
                    Add Violation Entry
                </h1>
                <p>You can add violation entry to monitor the violations.</p>
                <hr class="mt-2 mb-2">

                <form action="{{ route('violations.entry.store') }}" method="POST">
                    @csrf
                    <div class="row mt-2 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="violation">Violation Name <b
                                        class="text-danger">*</b></label>
                                <span class="form-note">Specify the Violation Name here.</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" id="violation" required class="form-control"
                                        name="inp_violation" placeholder="Enter (Required) Violation Name here..">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="penalty">
                                    Amount Penalty
                                    <b class="text-danger">*</b>
                                </label>
                                <span class="form-note">Specify the Amount Penalty here.</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" required class="form-control" id="penalty"
                                        name="inp_penalty" placeholder="Enter (Required) Amount Penalty here.. ">
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
                            <button type="submit" class="btn btn-success">
                                <em class="icon ni ni-save"></em>
                                &ensp;Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
                <p>You can edit violation entry to monitor the violations.</p>
                <hr class="mt-2 mb-2">

                <form action="{{ route('violations.entry.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="row mt-2 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="inp_violation">Violation Name <b
                                        class="text-danger">*</b></label>
                                <span class="form-note">Specify the Violation Name here.</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" id="inp_violation" required class="form-control"
                                        name="inp_violation" placeholder="Enter (Required) Violation Name here..">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="inp_penalty">
                                    Amount Penalty
                                    <b class="text-danger">*</b>
                                </label>
                                <span class="form-note">Specify the Amount Penalty here.</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" required class="form-control" id="inp_penalty"
                                        name="inp_penalty" placeholder="Enter (Required) Amount Penalty here.. ">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-8" style="float: right">
                        <hr class="mt-2 mb-2">
                    </div>
                    @if (Auth::user()->account_type != 'Officer')
                        <div class="col-lg-5">
                        </div>
                        <div class="col-lg-7 justify-end" style="float: right">
                            <div class="form-group mt-2 mb-2 justify-end">
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
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var default_id = 0;

    function view(id, violation, penalty) {
        const title = document.getElementById('modal-title-label');
        const text_violation = document.getElementById('inp_violation');
        const text_penalty = document.getElementById('inp_penalty');

        title.innerHTML = `Edit Violation: ${violation}`; // Set title
        text_violation.value = violation;
        text_penalty.value = penalty;

        var form = document.querySelector('#edit form');
        form.action = `/violations/entry/update/${id}`;

        default_id = id
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
                    url: '{{ route('violation.entry.remove') }}',
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
