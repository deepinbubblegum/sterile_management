<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" href="{{ public_path('assets/css/packing_qrcode.css') }}">

</head>

<body>

    {{-- {{dd($items[0])}} --}}

    @foreach ($items as $items)

        {{-- @for ($i = 1; $i < $items->Quantity; $i++) --}}

        <div class="p_page">
            <div class="header">
                <div class="textHeader">

                    {{-- <img class="img_top" src="{{ public_path('assets/image/S__40607792.jpg') }}" width="35px" height="auto"> --}}

                    <b>Medihealth Solution Co.,Ltd.</b>

                    <br>

                    <p class="txt_customer"> <b> {{ $items->Customer_name }} </b></p>
                </div>
            </div>

            <div class="body">

                <img class="img_QR_top" src="data:image/png;base64, {{ $items->qr_code }}" width="40px"
                    height="auto">

                <div class="textBody">

                    <b>Department</b> : {{ $items->Department_name }}
                    <br>

                    <b>Item Name</b> : {{ $items->Name }}
                    <br>

                    {{-- <b>Category</b> : {{ $items->Name }}
                    <br> --}}

                    <b>Process</b> : {{ $items->Process }}
                    <br>

                    <b>Packing By</b> : {{ $items->UserCreate }}
                    <br>

                    <b>QC by</b> : {{ $items->UserName_QC }}
                    <br>

                    <b>Packing date</b> : {{ date('d-m-Y', strtotime($items->Create_at)) }}
                    <br>

                    <b>Expired date</b> : {{ date('d-m-Y', strtotime($items->Exp_date)) }}

                </div>
            </div>

            {{-- <hr class="hr_custom"/> --}}

            <div class="footer">

                <img class="img_QR_buttom" src="data:image/png;base64, {{ $items->qr_code }}" width="40px"
                    height="auto">

                <div class="textfooter">

                    <b>Item Name</b> : {{ $items->Name }}
                    <br>

                    <b>Packing date</b> : {{ date('d-m-Y', strtotime($items->Create_at)) }}
                    <br>

                    <b>Expired date</b> : {{ date('d-m-Y', strtotime($items->Exp_date)) }}

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
