<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

    </style>

    <link rel="stylesheet" href="{{ public_path('assets/css/packing_qrcode.css') }}">

</head>

<body>

    {{-- {{dd($items[0])}} --}}

    @foreach ($items as $items)
    {{-- @for ($i = 1; $i < $items->Quantity; $i++) --}}

    <div class="p_page">
        <div class="header">
            <div class="textHeader">

                {{-- <img class="img_top" src="{{ public_path('assets/image/S__40607792.jpg') }}" width="35px"
                height="auto"> --}}

                <b>Medihealth Solution Co.,Ltd.</b>

                <br>

                <p class="txt_customer"> <b> {{ $items->Customer_name }} </b></p>
            </div>
        </div>

        <div class="body">

            <img class="img_QR_top" src="data:image/png;base64, {{ $items->qr_code }}" width="25px" height="auto">

            <div class="textBody">

                <b>Department : <span class="Data_Item"> {{ $items->Department_name }} </span> </b>
                <br>

                <b>Item Name : <span class="Data_Item"> {{ $items->Name }} </span> </b>
                <br>

                {{-- <b>Item Name : <span class="Data_Item"> {{ $items->Name }} </span> </b>
                <br> --}}

                <b>Remark : <span class="Data_Item"> {{ isset($items->Note) ? $items->Note : '-' }} </span> </b>
                <br>

                <b>Category : <span class="Data_Item"> {{ strtoupper($items->Instrument_type) }}
                    </span> (<span>{{ strtoupper($items->Descriptions) }}</span>) </b>
                <br>

                <b>Process : <span class="Data_Item"> {{ strtoupper($items->Process) }}
                        {{ $items->txt_processNO }} Cycle {{ $items->Cycle }}</span> </b>
                <br>

                <b>Packing By : <span class="Data_Item"> {{ $items->UserCreate }} </span> </b>
                <br>

                <b>QC by : <span class="Data_Item"> {{ $items->UserName_QC }} </span> </b>
                <br>

                <b>Packing date : <span class="Data_Item"> {{ date('d/m/Y', strtotime($items->Create_at)) }}
                    </span> </b>
                <br>

                <b>Expired date : <span class="Data_Item"> {{ date('d/m/Y', strtotime($items->Exp_date)) }} </span>
                </b>

                <span class="{{ $items->SUD == null ? 'div_hide_' : '-' }}">
                    <br>
                    <b>SUD : <span class="Data_Item"> {{ $items->SUD ?: '-' }} </span> </b>
                </span>

            </div>
        </div>

        {{-- <hr class="hr_custom"/> --}}

        <div class="footer">

            <img class="img_QR_buttom" src="data:image/png;base64, {{ $items->qr_code }}" width="25px" height="auto">

            <div class="textfooter">

                <b>Item Name : <span class="Data_Item"> {{ $items->Name }} </span> </b>
                <br>

                <b>Packing date : <span class="Data_Item"> {{ date('d/m/Y', strtotime($items->Create_at)) }}
                    </span> </b>
                <br>

                <b>Expired date : <span class="Data_Item"> {{ date('d/m/Y', strtotime($items->Exp_date)) }} </span>
                </b>

            </div>
        </div>
    </div>

    {{-- @endfor --}}
    @endforeach




    {{-- <div class="footer">
       <p>footer</p>
    </div> --}}



</body>

</html>
