<div class="modal fade" tabindex="-1" role="dialog" id="entries">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal">
                <em class="icon ni ni-cross-sm"></em>
            </a>
            <div class="modal-body">
                <h1 class="nk-block-title page-title text-2xl">
                    Add Traffic Citation Entry
                </h1>
                <p>You can add a traffic citation entry to monitor violations.</p>
                <hr class="mt-2 mb-2">

                <form action="{{ route('citations.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="row mt-2 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Plate Number <b class="text-danger">*</b></label>
                                <span class="form-note">Specify the Plate Number here.</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" required class="form-control" name="plate_number"
                                        placeholder="Enter (Required) Plate Number here..">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Violator Name <b class="text-danger">*</b></label>
                                <span class="form-note">Specify the Violator Name here.</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>

                                    <style>
                                        /* Fix Autocomplete Dropdown in Modal */
                                        .ui-autocomplete {
                                            z-index: 1051 !important;
                                            /* Ensure it is above Bootstrap's modal z-index */
                                            max-height: 150px;
                                            overflow-y: auto;
                                            background-color: #ffffff;
                                            border: 1px solid #ccc;
                                            font-size: 14px;
                                        }

                                        .ui-menu-item {
                                            padding: 8px 10px;
                                            cursor: pointer;
                                        }

                                        .ui-menu-item:hover {
                                            background-color: #f0f0f0;
                                        }
                                    </style>
                                    {{-- <input type="text" id="autocompleteInput" placeholder="Start typing..." /> --}}
                                    <input type="text" id="autocompleteInput" required class="form-control"
                                        name="violator_name" placeholder="Enter (Required) Violator Name here..">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Address <b class="text-danger">*</b></label>
                                <span class="form-note">Specify the Address here.</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" required class="form-control" name="address"
                                        placeholder="Enter (Required) Address here..">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Date <b class="text-danger">*</b></label>
                                <span class="form-note">Specify the Date of citation.</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required
                                        class="form-control" name="date">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="municipal_ordinance_number">Municipal Ordinance Number <b
                                        class="text-danger">*</b></label>
                                <span class="form-note">Specify the Municipal Ordinance Number here.</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" name="municipal_ordinance_number"
                                        placeholder="Enter (Required) Municipal Ordinance Number here..">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Specific Offense <b class="text-danger">*</b></label>
                                <span class="form-note">Specify the Specific Offense here.</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <select class="form-control js-select2" multiple id="specific_offense_1"
                                        name="specific_offense[]" onchange="updateTotal1()"
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
                                <h1 class="text-2xl fw-bold"> ₱ <span id="totalPenalty1">0.00</span></h1>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Remarks</label>
                                <span class="form-note">Specify any additional remarks here.</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-info"></em>
                                    </div>
                                    <input type="text" class="form-control" name="remarks"
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
                                    <select name="inp_status" id="inp_status" class="form-control">
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
                    <div class="col-lg-5"></div>
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
                                    <input type="text" id="ticket_number" required class="form-control fw-bold"
                                        readonly name="ticket_number"
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
                                <label class="form-label" for="address">Address <b class="text-danger">*</b></label>
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
                                <label class="form-label" for="date">Date <b class="text-danger">*</b></label>
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
                                onclick="go_to('/violators/print/' + document.getElementById('id_x').value )"
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



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
    $(document).ready(function() {
        // Fetch data from Laravel
        const records = [
            @foreach (App\Models\TrafficCitation::select('violator_name')->distinct()->get() as $data)
                "{{ $data->violator_name }}",
            @endforeach
        ];

        // Autocomplete initialization
        $("#autocompleteInput").autocomplete({
            source: records,
            minLength: 0, // Show dropdown on focus
            autoFocus: true,
            open: function() {
                // Force the dropdown to appear correctly in modal
                $(".ui-autocomplete").css({
                    "z-index": 1051,
                    "width": $(this).outerWidth() + "px"
                });
            }
        }).focus(function() {
            // Trigger dropdown when the input is focused
            $(this).autocomplete("search", "");
        });
    });
</script>

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
        title.innerHTML = `Edit Traffic Citation for: ${violator_name}`;

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
        form.action = `/citations/update/${id}`;

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
