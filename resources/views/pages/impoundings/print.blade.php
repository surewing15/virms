<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Impoundment Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .container {
            width: 100%;
            margin: auto;
            padding: 20px;
            page-break-after: always;
        }

        .header {
            text-align: center;
        }

        .header img {
            height: 80px;
        }

        .header h3,
        .header h4,
        .header p {
            margin: 5px 0;
        }

        .header p {
            font-size: 14px;
        }

        .content {
            margin-top: 10px;
        }

        .content .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .content .row div {
            width: 48%;
        }

        .content .row div label {
            font-weight: bold;
            display: block;
        }

        .content .row div input {
            width: 100%;
            border: none;
            border-bottom: 1px solid #000;
            outline: none;
        }

        .content .notes {
            margin-top: 20px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
        }

        .footer .released-by {
            margin-bottom: 50px;
        }

        .footer .signature {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .footer .signature div {
            width: 100%;
            border-top: 1px solid #000;
            text-align: center;
        }


        /* Footer */
        .form-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            font-size: 12px;
        }

        .footer-section {
            text-align: center;
            width: 45%;
        }
    </style>
</head>
@php
    $info = App\Models\VehicleImpounding::where('id', $id)->first();
@endphp

<body onload="window.print()">
    <div class="container">
        <div class="header">

            <img src="/images/header.png" style="height: 250px" alt="Logo">
            {{-- <img src="/images/logo.png" alt="Police Logo">
            <h3>Republic of the Philippines</h3>
            <h4>National Police Commission</h4>
            <p>Philippine National Police</p>
            <p>Misamis Oriental Police Provincial Office</p>
            <p>TAGOLOAN POLICE STATION</p>
            <p>Tagoloan, Misamis Oriental</p>
            <p>Tel. No. 890-6549-173 | Cellphone Number: 09177040213</p>
            <p>Date: {{ date('D, F d, Y h:i A') }}</p> --}}
        </div>
        <div class="content">
            <h4>VEHICLE IMPOUNDMENT</h4>
            <div class="row">
                <div>
                    <label>Owner Name/Vehicle Operator:</label>
                    <input type="text" readonly value="{{ $info->owner_name }}">
                </div>
                <div>
                    <label>Vehicle (Year/Brand/Model):</label>
                    <input type="text" readonly value="{{ $info->vehicle_type }}">
                </div>
            </div>
            <div class="row">
                <div>
                    <label>Plate Number:</label>
                    <input type="text" readonly value="{{ $info->vehicle_number }}">
                </div>
                <div>
                    <label>License Number:</label>
                    <input type="text" readonly value="{{ $info->license_no }}">
                </div>
            </div>
            <div class="row">
                <div>
                    <label>Address:</label>
                    <input type="text" readonly value="{{ $info->address }}">
                </div>
                <div>
                    <label>Birthdate:</label>
                    <input type="text" readonly
                        value="{{ date_format(date_create($info->birthdate), 'D, F d, Y') }}">
                </div>
            </div>
            <div class="row">
                <div>
                    <label>Phone Number:</label>
                    <input type="text" readonly value="{{ $info->phone }}">
                </div>
                <div>
                    <label>Date of Impound:</label>
                    <input type="text" readonly value="{{ $info->date_of_impounding }}">
                </div>
            </div>
            <div class="notes">
                <p>REASON OF IMPOUNDMENT : {{ $info->reason_for_impounding }}</p>
                <p>INCIDENT LOCATION : {{ $info->incident_location }}</p>
                {{-- <p>CONDITION OF VEHICLE : {{ $info->condition_x }}</p> --}}
            </div>
            <div class="notes">
                <p>VIOLATION FROM TICKET CITATION</p>
                @foreach (json_decode($info->violation_id, true) as $data)
                    @php
                        $val = App\Models\ViolationEntries::where('id', $data)->first();
                    @endphp
                    {{ $val->violation }},
                @endforeach
            </div>
        </div>
        @if ($info->release_date)
            <!-- Footer Section -->
            <div class="form-footer">
                <div class="footer-section">
                    <p><strong>Released By:</strong></p>
                    <p>PMSg Acero, AJ</p>
                    <p>Traffic Investigator</p>
                </div>
                <div class="footer-section">
                    <p><strong>Noted By:</strong></p>
                    <p>RALPH REXSON LOPEZ LAYUG</p>
                    <p>Police Captain</p>
                    <p>Officer In Charge</p>
                </div>
            </div>
        @endif
    </div>
</body>

</html>
