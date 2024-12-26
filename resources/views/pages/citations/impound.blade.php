@php
    use App\Models\ViolationEntries;
@endphp
<x-app-layout>
    <x-slot name="back"></x-slot>
    <x-slot name="header">{{ __('Traffic Citation > Vehicle Impound') }}</x-slot>
    <x-slot name="subHeader">{{ __('You can manage the traffic citations and register new citations here.') }}</x-slot>
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
                                        <input type="hidden" name="id_x" value="{{ $id }}">
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
                                        <input type="date" max="{{ date('Y-m-d') }}" class="form-control" required
                                            id="birthdate" name="birthdate" placeholder="Enter here..">
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
                                        <input type="text" class="form-control" id="vehicle_type"
                                            name="vehicle_type" placeholder="Enter vehicle type" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Vehicle Number -->
                            <div class="row mt-2 align-center" style="display: block;">
                                <div class="col-lg-4" style="display: block;">
                                    <div class="form-group">
                                        <label class="form-label" for="vehicle_number">Vehicle Number <b
                                                class="text-danger">*</b></label>
                                        <span class="form-note">Enter the vehicle number.</span>
                                    </div>
                                </div>
                                <div class="col-lg-8" style="display: block;">
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
                                            onchange="updateTotal()" name="violation_id[]"
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
                                        <input class="form-check-input" name="reason_of_impoundment"
                                            value="ABANDONED" type="checkbox" id="abandoned">
                                        <label class="form-check-label" for="abandoned">ABANDONED</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="reason_of_impoundment"
                                            value="ILLEGALLY PARKED" type="checkbox" id="illegally-parked">
                                        <label class="form-check-label" for="illegally-parked">ILLEGALLY
                                            PARKED</label>
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
                            <div class="mb-3"  style="display: none">
                                <label for="incident-location" class="form-label">Incident Location / Address</label>
                                <input class="form-control" id="incident-location" name="incident_address"
                                    rows="2" placeholder="Text box">
                            </div>
                            <div class="mb-3" style="display: none">
                                <label for="condition-of-vehicle" class="form-label">
                                    Condition of Vehicle (Attach Additional pages if more space is needed)
                                </label>
                                <input class="form-control" id="condition-of-vehicle" name="condition_x"
                                    rows="2" placeholder="Text box">
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
                                            name="incident_location" placeholder="Enter the location or address"
                                            required>
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
                                        <label class="form-label" for="fine_amount">Additional Fine Amount</label>
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
                                <div class="col-lg-4" style="display: none">
                                    <div class="form-group">
                                        <label class="form-label" for="release_date">Release Date</label>
                                        <span class="form-note">Specify the release date (optional).</span>
                                    </div>
                                </div>
                                <div class="col-lg-8" style="display: none">
                                    <div class="form-control-wrap">
                                        <input type="date" class="form-control" id="release_date"
                                            name="release_date">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2 align-center" style="display: none">
                                <div class="col-lg-4" style="display: none">
                                    <div class="form-group">
                                        <label class="form-label" for="document_attachment">Supporting
                                            Documents</label>
                                        <span class="form-note">Attach supporting documents (optional).</span>
                                    </div>
                                </div>
                                <div class="col-lg-8" style="display: none">
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




                            <!-- Attach Images / Photo -->
                            <div class="row mt-2 align-center">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label" for="photo_attachment">Attach Images /
                                            Photos</label>
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

                            <!-- Buttons -->
                            <div class="col-lg-4"></div>
                            <div class="col-lg-8" style="float: right">
                                <hr class="mt-4 mb-4">
                                <div class="form-group mt-2 mb-2 justify-end">
                                    <button onclick="remove()" style="display: none;" id="remove" type="button"
                                        class="btn btn-danger">
                                        <em class="icon ni ni-trash"></em>
                                        &ensp;Remove
                                    </button>
                                    &ensp;
                                    <button type="reset" id="reset" class="btn btn-light bg-white mx-3">
                                        <em class="icon ni ni-repeat"></em>&ensp;
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-light bg-white">
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
    </div>
    @php
        $info = App\Models\TrafficCitation::where('id', $id)->first();
    @endphp

    <script>
        function updateTotal() {
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

        function updateTotal1() {
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
            document.getElementById('totalPenalty1').textContent = totalAmount.toLocaleString('en', {
                minimumFractionDigits: 2
            });
        }

        function x() {

            const title = document.getElementById('modal-title-label');
            var id = 1;

            // Get input elements for each field
            // document.getElementById('ticket_number').value = Number(id) + 1000000;
            // document.getElementById('id_x').value = id;

            const text_plate_number = document.getElementById('vehicle_number');
            const text_violator_name = document.getElementById('owner_name');
            const text_address = document.getElementById('address');
            const text_date = document.getElementById('date');
            const text_municipal_ordinance_number = document.getElementById('municipal_ordinance_number');
            //const text_specific_offense = document.getElementById('specific_offense');
            const text_remarks = document.getElementById('remarks');
            const text_status = document.getElementById('inp_status_edit');

            //const text_vehicle_type = document.getElementById('vehicle_type');

            // Set modal title
            //title.innerHTML = '{{ $info->violator_name }}';

            // Set the values of the form inputs
            text_plate_number.value = '{{ $info->plate_number }}';
            text_violator_name.value = '{{ $info->violator_name }}';
            text_address.value = '';
            //text_date.value = '';
            //text_municipal_ordinance_number.value = '{{ $info->municipal_ordinance_number }}';
            //text_specific_offense.value = specific_offense;
            //text_remarks.value = '{{ $info->remarks }}';
            //text_status.value = '{{ $info->status }}';

            //text_vehicle_type.value = ''

            // Update the form's action attribute for submitting the changes
            var form = document.querySelector('#edit form');
            //form.action = `/citations/update/${id}`;

            // Parse the JSON data into a JavaScript array
            const violationsArray = JSON.parse(@json($info->specific_offense, true));

            // Reference the select box by its ID
            const selectBox = document.getElementById('violation_id');

            // Loop through the select box options
            for (let i = 0; i < selectBox.options.length; i++) {
                // Check if the option's value exists in the violationsArray
                if (violationsArray.includes(selectBox.options[i].value)) {
                    selectBox.options[i].selected = true; // Mark as selected
                } else {
                    selectBox.options[i].selected = false; // Deselect if not in violationsArray
                }
            }

            // Trigger 'change' event for libraries like Select2
            $('#violation_id').trigger('change');
            updateTotal();

            // Store the default ID if needed for further logic
            default_id = id;
        }

        x();
    </script>
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
