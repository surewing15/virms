<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic Citation Ticket</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: flex-start;
            /* Align to the left */
            align-items: flex-start;
        }

        .ticket {
            width: 400px;
            /* Original ticket size */
            border: 1px solid black;
            padding: 10px;
            margin: 10px;
        }

        .center {
            text-align: center;
        }

        .field {
            margin: 10px 0;
        }

        .signature {
            margin-top: 20px;
        }

        .line {
            border-bottom: 1px solid black;
            width: 100%;
            margin-top: 5px;
        }

        /* Scaling for printing */
        @media print {
            .ticket {
                transform: scale(0.7);
                /* Reduce size to 70% */
                transform-origin: top left;
                /* Keep scaling aligned to top-left */
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="ticket">
            <div class="center">
                <img src="/images/logo.png" height="80" alt="">
                <p>Republic of the Philippines</p>
                <p><b>MUNICIPALITY OF TAGOLOAN</b></p>
                <p><b>OFFICE THE MUNICIPAL MAYOR</b></p>
                <p><b>TRAFFIC CITATION TICKET</b></p>
            </div>
            @php
                $info = App\Models\TrafficCitation::where('id', $id)->first();
            @endphp
            <div class="field">
                <b>Date:</b> <span class="line"> {{ $info->date }}</span>
            </div>
            <div class="field">
                <b>No.</b>
                <span class="line"> {{ $info->id + 100000 }}</span>
            </div>
            <div class="field">
                <b>PLATE NO.</b> <span class="line">{{ $info->plate_number }}</span>
            </div>
            <div class="field">
                <b>VIOLATOR/DRIVER:</b> <span class="line">{{ $info->violator_name }}</span>
            </div>
            <div class="field">
                <b>ADDRESS:</b> <span class="line">{{ $info->address }}</span>
            </div>
            <div class="field">
                <p>You are hereby cited for VIOLATING</p>
            </div>
            <div class="field">
                <b>MUNICIPAL ORDINANCE Nr.</b> <span class="line">{{ $info->municipal_ordinance_number }}</span>
            </div>
            <div class="field">
                <b>SPECIFIC OFFENSE:</b> <span class="line">
                    @php
                        $get_violations = json_decode($info->specific_offense, true);
                        // Check if decoding was successful
                        if ($get_violations !== null) {
                            // Iterate through the array and access each violation ID
                            foreach ($get_violations as $violation_id) {
                                $violation = App\Models\ViolationEntries::select('violation as name', 'penalty')
                                    ->where('id', $violation_id)
                                    ->first();
                                echo $violation->name . ',';
                            }
                        }
                    @endphp
                </span>
            </div>
            <center>
                <div class="field">
                    <p><b>COUNTRY TO LAW</b></p>
                    <p>
                        You are hereby directed to appear before the Municipal Treasurer, Tagoloan, Misamis Oriental
                        within
                        three (3) days from the date hereof for appropriate disposition of this CITATION. Failure to
                        appear
                        within three (3) days as required herein, the Municipal Treasurer shall within Twenty Four (24)
                        hours forward to case to the Office of the Municipal Circuit Trial Court for filing of
                        appropriate
                        charges.
                    </p>
                </div>
                <div class="signature">
                    <b>PMSG. ARNEL JASON ACERO</b><br>
                    (Printed name and signature of Apprehending Officer)
                </div>
                <div class="signature">
                    <div class="line"></div>
                    <p class="center">(Violator's/Driver's Signature)</p>
                </div>
            </center>
        </div>
    </div>
</body>

</html>
