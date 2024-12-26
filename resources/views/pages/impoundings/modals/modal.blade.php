<div class="modal fade" tabindex="-1" role="dialog" id="entries">
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

                <form action="{{ route('vehicle-impoundings.store') }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
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
                                <input type="text"  id="autocompleteInput" required class="form-control" name="owner_name"
                                    placeholder="Enter (Required) Violator Name here..">

                                {{-- <input type="text" class="form-control" id="owner_name" name="owner_name"
                                    placeholder="Enter owner name" required> --}}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="address">Address <b class="text-danger">*</b></label>
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
                                <label class="form-label" for="birthdate">Birthdate <b class="text-danger">*</b></label>
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
                                <label class="form-label" for="phone">Phone No. <b class="text-danger">*</b></label>
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
                                <input type="text" class="form-control" id="vehicle_number" name="vehicle_number"
                                    placeholder="Enter vehicle number" required>
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
                                    onchange="updateTotal()" name="violation_id[]" placeholder="Search Violation.."
                                    required>
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
                                    class="form-control" id="date_of_impounding" name="date_of_impounding" required>
                            </div>
                        </div>
                    </div>

                    <h5 class="mb-3">REASON OF IMPOUNDMENT</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" name="reason_of_impoundment[]" value="ACCIDENT"
                                    type="checkbox" id="accident">
                                <label class="form-check-label" for="accident">ACCIDENT</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="reason_of_impoundment[]" value="BURNED"
                                    type="checkbox" id="burned">
                                <label class="form-check-label" for="burned">BURNED</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="reason_of_impoundment[]" value="DWI"
                                    type="checkbox" id="dwi">
                                <label class="form-check-label" for="dwi">DWI</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="reason_of_impoundment[]" value="OTHER"
                                    type="checkbox" id="other">
                                <label class="form-check-label" for="other">OTHER (Specify)</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" name="reason_of_impoundment[]" value="ABANDONED"
                                    type="checkbox" id="abandoned">
                                <label class="form-check-label" for="abandoned">ABANDONED</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="reason_of_impoundment[]"
                                    value="ILLEGALLY PARKED" type="checkbox" id="illegally-parked">
                                <label class="form-check-label" for="illegally-parked">ILLEGALLY PARKED</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="reason_of_impoundment[]" value="STOLEN"
                                    type="checkbox" id="stolen">
                                <label class="form-check-label" for="stolen">STOLEN</label>
                            </div>
                        </div>
                    </div>



                    <div class="mb-3">
                        <input class="form-control" rows="2" name="reason_of_impoundment_reason" id="reason_of_impoundment_reason"
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
                                <label class="form-label" for="incident_location">Incident Location / Address</label>
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
                                <label class="form-label" for="reason_for_impounding">Reason for Impounding</label>
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
                        <div class="col-lg-4" style="display: {{ Auth::user()->account_type == 'Officer' ? 'none' : 'block'}}">
                            <div class="form-group">
                                <label class="form-label" for="officer_name">Officer Name</label>
                                <span class="form-note">Specify the officer name (optional).</span>
                            </div>
                        </div>
                        <div class="col-lg-8" style="display: {{ Auth::user()->account_type == 'Officer' ? 'none' : 'block'}}">
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="officer_name" name="officer_name">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 align-center" style="display: none">
                        <div class="col-lg-4" style="display: {{ Auth::user()->account_type == 'Officer' ? 'none' : 'block'}}">
                            <div class="form-group">
                                <label class="form-label" for="officer_rank">Officer Rank</label>
                                <span class="form-note">Specify the officer rank (optional).</span>
                            </div>
                        </div>
                        <div class="col-lg-8" style="display: {{ Auth::user()->account_type == 'Officer' ? 'none' : 'block'}}">
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="officer_rank" name="officer_rank">
                            </div>
                        </div>
                    </div>


                    <div class="row mt-2 align-center" style="display: none">
                        <div class="col-lg-4" style="display: {{ Auth::user()->account_type == 'Officer' ? 'none' : 'block'}}">
                            <div class="form-group">
                                <label class="form-label" for="release_date">Release Date</label>
                                <span class="form-note">Specify the release date (optional).</span>
                            </div>
                        </div>
                        <div class="col-lg-8" style="display: {{ Auth::user()->account_type == 'Officer' ? 'none' : 'block'}}">
                            <div class="form-control-wrap">
                                <input type="date" class="form-control" id="release_date" name="release_date">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 align-center">
                        <div class="col-lg-4" style="display: {{ Auth::user()->account_type == 'Officer' ? 'none' : 'block'}}">
                            <div class="form-group">
                                <label class="form-label" for="document_attachment">Supporting Documents</label>
                                <span class="form-note">Attach supporting documents (optional).</span>
                            </div>
                        </div>
                        <div class="col-lg-8" style="display: {{ Auth::user()->account_type == 'Officer' ? 'none' : 'block'}}">
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="document_attachment"
                                    name="document_attachment[]" multiple>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 align-center"  style="display: {{ Auth::user()->account_type == 'Officer' ? 'none' : 'block'}}">
                        <div class="col-lg-12" style="display: {{ Auth::user()->account_type == 'Officer' ? 'none' : 'block'}}">
                            <hr class="mt-4 mb-4">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div id="file-container"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div id="documents"></div>
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
                            <button onclick="remove()" style="display: none;" id="remove" type="button"
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
   $(document).ready(function () {
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
            open: function () {
                // Force the dropdown to appear correctly in modal
                $(".ui-autocomplete").css({
                    "z-index": 1051,
                    "width": $(this).outerWidth() + "px"
                });
            }
        }).focus(function () {
            // Trigger dropdown when the input is focused
            $(this).autocomplete("search", "");
        });
    });
</script>


<style>
    li {
        color: #000;
    }
</style>

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


    var default_id = 0;

    function remove_reset() {
        document.getElementById('reset').style.display = 'block';
        document.getElementById('remove').style.display = 'none';
    }

    function view(id, owner, vehicle, vnumber, violations, impound, reason, fine, release, license_no, address,
        birthdate, phone, reason_of_impoundment, reason_of_impoundment_reason, incident_address, condition_x,
        storage_fee, officer_name, officer_rank, files, documents) {

        document.getElementById('id_x').value = id;

        const filesArray = typeof files === 'string' ? JSON.parse(files) : files;
        const documentsArray = typeof documents === 'string' ? JSON.parse(documents) : documents;

        // Reference the container
        const container = document.getElementById('file-container');

        // Clear previous content in the container (if needed)
        container.innerHTML = '';

        // Create a <table> element with Bootstrap classes
        const table = document.createElement('table');
        table.className = 'table table-bordered'; // Apply Bootstrap table classes

        // Create a table header
        const thead = document.createElement('thead');
        const headerRow = document.createElement('tr');
        const nameHeader = document.createElement('th');
        nameHeader.textContent = 'Attached Images';
        const linkHeader = document.createElement('th');
        linkHeader.textContent = 'Action';
        headerRow.appendChild(nameHeader);
        headerRow.appendChild(linkHeader);
        thead.appendChild(headerRow);
        table.appendChild(thead);

        // Create a table body
        const tbody = document.createElement('tbody');

        // Iterate through the filesArray and create rows
        filesArray.forEach(file => {
            const row = document.createElement('tr');

            // File name cell
            const nameCell = document.createElement('td');
            nameCell.textContent = file;

            // Action cell with a link
            const linkCell = document.createElement('td');
            const link = document.createElement('a');
            link.href = '/storage/' + file; // Set the file path as the href
            link.textContent = 'View'; // Display "Open" as the link text
            link.target = '_blank'; // Open the link in a new tab
            linkCell.appendChild(link);

            // Append cells to the row
            row.appendChild(nameCell);
            row.appendChild(linkCell);

            // Append the row to the table body
            tbody.appendChild(row);
        });

        // Append the table body to the table
        table.appendChild(tbody);

        // Append the table to the container
        container.appendChild(table);

        const container_docs = document.getElementById('documents');

        // Clear any existing content
        container_docs.innerHTML = '';

        const table_docs = document.createElement('table');
        table_docs.className = 'table table-bordered'; // Bootstrap styling

        // Add table header
        const thead_docs = document.createElement('thead');
        thead_docs.innerHTML = `
        <tr>
            <th>Attached Images</th>
            <th>Action</th>
        </tr>`;
        table_docs.appendChild(thead);

        const tbody_docs = document.createElement('tbody');

        // Populate rows with files
        documentsArray.forEach(file => {
            const row = document.createElement('tr');
            row.innerHTML = `
        <td>${file}</td>
        <td><a href="/storage/${file}" target="_blank">View</a></td>`;
            tbody_docs.appendChild(row);
        });

        table_docs.appendChild(tbody_docs);
        container.appendChild(table_docs);


        document.getElementById('reset').style.display = 'none';
        document.getElementById('remove').style.display = 'block';

        const title = document.getElementById('modal-title-label');
        const sub_title = document.getElementById('modal-sub-label');

        // Get input elements for each field
        const text_violator_name = document.getElementById('owner_name');
        const text_vehicle_type = document.getElementById('vehicle_type');
        const text_plate_number = document.getElementById('vehicle_number');

        const text_date_impound = document.getElementById('date_of_impounding');
        const text_reason_impound = document.getElementById('reason_for_impounding');
        const text_add_fine = document.getElementById('fine_amount');
        const text_date_release = document.getElementById('release_date');

        const t_license_no = document.getElementById('license_no');
        const t_address = document.getElementById('address');
        const t_birthdate = document.getElementById('birthdate');
        const t_phone = document.getElementById('phone');
        const t_reason_of_impoundment = document.getElementById('reason_of_impoundment');
        const t_reason_of_impoundment_reason = document.getElementById('reason_of_impoundment_reason');
        const t_ncident_address = document.getElementById('incident_location');
        const t_condition_x = document.getElementById('condition_x');

        const t_officer_name = document.getElementById('officer_name');
        const t_officer_rank = document.getElementById('officer_rank');

        // 'license_no',
        // 'address',
        // 'birthdate',
        // 'phone',
        // 'reason_of_impoundment',
        // 'reason_of_impoundment_reason',
        // 'incident_address',
        // 'condition_x',

        // Set modal title
        title.innerHTML = `${vehicle}`;
        sub_title.innerHTML = `update`;

        t_officer_name.value = officer_name;
        t_officer_rank.value = officer_rank;

        // Set the values of the form inputs
        text_violator_name.value = owner;
        text_vehicle_type.value = vehicle;
        text_plate_number.value = vnumber;
        //text_violations.innerHTML = violations;
        text_date_impound.value = impound;
        text_reason_impound.value = reason;
        text_add_fine.value = storage_fee;
        text_date_release.value = release;

        t_license_no.value = license_no;
        t_address.value = address;
        t_birthdate.value = birthdate;
        t_phone.value = phone;
        //t_reason_of_impoundment.value = reason_of_impoundment;
        t_reason_of_impoundment_reason.value = reason_of_impoundment_reason;
        t_ncident_address.value = incident_address;
        t_condition_x.value = condition_x;

        // Update the form's action attribute for submitting the changes
        var form = document.querySelector('#entries form');
        form.action = `/impoundings/update/${id}`;

        // Store the default ID if needed for further logic
        //console.log(violations)

        // Assuming `violations` is a JSON string, first parse it
        // Assuming `violations` is a JSON string, parse it into an array
        const violationsArray = JSON.parse(violations);

        // Reference the actual select box element by its ID 'violation_id'
        const selectBox = document.getElementById('violation_id');

        // Loop through the select box options
        for (let i = 0; i < selectBox.options.length; i++) {
            // Check if the option value exists in the violationsArray
            if (violationsArray.includes(selectBox.options[i].value)) {
                selectBox.options[i].selected = true; // Mark as selected
            } else {
                selectBox.options[i].selected = false; // Deselect if not in violationsArray
            }
        }

        document.querySelectorAll('input[name="reason_of_impoundment[]"]').forEach(checkbox => {
            checkbox.checked = false; // Clear all selections
        });

        // Apply the selected values
        document.querySelectorAll('input[name="reason_of_impoundment[]"]').forEach(checkbox => {
            // Check if the checkbox value is in the selectedValues array
            if (reason.includes(checkbox.value)) {
                checkbox.checked = true; // Mark as checked
            }
        });

        // Trigger change event to refresh Select2 UI
        $('#violation_id').trigger('change');

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
                    url: '{{ route('impounding.remove') }}',
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
