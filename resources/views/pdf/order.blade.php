<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ทดสอบ Generate PDF</title>
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

        body {
            font-family: "THSarabunNew";
        }

        @page {
            margin: 100px 25px;
        }

        .header {
            position: fixed;
            top: -80px;
            left: 0px;
            right: 0px;
            height: 180px;
            font-size: 19.5px !important;
            line-height: 1.2px;
        }

        hr {
            border: 0.5px solid black;
            border-radius: 0px;
        }

        .mt-6 {
            margin-top: 6px;
        }
    </style>
</head>

<body>
    {{-- {{dd($data)}} --}}
    <div class="header">
        <img src="{{ public_path('assets/image/medihealth_solutions.png') }}" alt="Logo" height="85px" width="195px">
        <div style="text-align: left; margin-left: 210px; margin-top: -85px;">
            <p><b>บริษัท ทดสอบระบบ (2048) จำกัด (สำนักงานใหญ่นิดนึง)</b></p>
            <p><b>SYSTEMTEST (2048) CO.,LTD</b></p>
            <p><b>451 ถนน พระรามที่ 1 แขวงปทุมวัน เขตปทุมวัน</b></p>
            <p><b>กรุงเทพมหานคร 10330</b></p>
            <p><b>451 Rama I Rd, Pathum Wan, Pathum Wan District, </b></p>
            <p><b>Bangkok 10330 THAILAND</b></p>
            <p><b>เลขประจําตัวผู้เสียภาษี : 0105556000001 </b></p>
        </div>
        <div style="float: right; margin-right: 35px; margin-top: -23%;">
            <p>เลขที่ออเดอร์ : ODI-0000000</p>
            <p>วันที่ : 652a92629as26d2</p>
            <p>แผนก : ทดสอบจร้า</p>
            <div>aaaaa</div>
        </div>
        <hr class="mt-6">
    </div>
    <img src="data:image/png;base64, {{$qrcode_order}}" alt="qrcode" height="100px" width="100px">
    
</body>

</html>
