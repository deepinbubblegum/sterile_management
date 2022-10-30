<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <title>{{ $List_data->Order_id }}</title> --}}

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

        .pagenum:before {
            position: fixed;
            font-size: 0.5cm;
            bottom: 0.6cm;
            right: 1.3cm;
            content: counter(page);
        }

    </style>
    <link rel="stylesheet" href="{{ public_path('assets/css/coa_pdf.css') }}">
</head>

<body>
    {{-- {{var_dump($item)}} --}}
    {{-- {{dd($List_data)}} --}}

    <!-- Define header and footer blocks before your content -->

    {{-- <img class="logo-img" src="{{ public_path('assets/image/medihealth_solutions.png') }}" alt="Logo"> --}}

    <div class="header">

        <b class="text-xl">
            Medihealth solution co,.ltd
        </b>

        <div class="text-center">
            <p class="text-2xl text-center">
                <b> แบบบันทึกการประกันคุณภาพการทำปราศจากเชื้อเครื่องมือแพทย์</b>
                <p style="font-size: 20px;"> Certificate of Assurrance </p>
            </p>
        </div>

    </div>

    <div style="font-size: 20px;">
        {{-- <img class="logo-img inline logo-header" src="{{ public_path('assets/image/medihealth_solutions.png') }}"
        alt="Logo"> --}}
        <b style="font-size: 25px;">
            <span style="color: red;"> {{$List_data->item->Machine_name}} </span> Sterilizer
        </b>
        Cycle <b> {{$List_data->item->cycle}} </b>
        </b>

        <table class="mt-1 table_top">
            <tr>
                <td>
                    วันที่นำเข้าเครื่อง <b class="dot"> {{$List_data->item->Sterile_date_create}} </b>
                </td>
                <td>
                    วันที่นำออกเครื่อง <b class="dot"> {{$List_data->item->Sterile_date_Update}} </b>
                </td>
            </tr>
            <tr>
                <td>
                    ผู้ทำการตรวจสอบ <b class="dot"> {{$List_data->item->UserCreate}} </b>
                </td>
                <td>
                    ลงชื่อผู้ตรวจสอบ <b> .........................................</b>
                </td>
            </tr>
        </table>

    </div>

    <br>
    <hr>
    <br>

    <table class="mt-1 table_img">
        <tr>
            <th>
                <u><b style="font-size: 25px;"> Chemical Monotoring </b></u>
                <table class="text-center table_img">
                    <tr>
                        <td>
                            <p>Pre-Test</p>
                            <img class="logo-img inline logo-header" height="100px"
                                src="{{ collect($List_data->item->image)->where('coa_type', 'A003')->take(1)->first()->pathfile }}"
                                alt="Logo">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Post-Test</p>
                            <img class="logo-img inline logo-header" height="100px"
                                src="{{ collect($List_data->item->image)->where('coa_type', 'A004')->take(1)->first()->pathfile }}"
                                alt="Logo">
                        </td>
                    </tr>
                </table>
            </th>
            {{-- {{dd('456')}} --}}
            <th>
                <u><b style="font-size: 25px;"> Biological Monotoring </b></u>
                <table class="text-center table_img">
                    <tr>
                        <td>
                            <p>Pre-Test</p>
                            <img class="logo-img inline logo-header" height="100px"
                                src="{{ collect($List_data->item->image)->where('coa_type', 'A005')->take(1)->first()->pathfile }}"
                                alt="Logo">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Post-Test</p>
                            <img class="logo-img inline logo-header" height="100px"
                                src="{{ collect($List_data->item->image)->where('coa_type', 'A006')->take(1)->first()->pathfile }}"
                                alt="Logo">
                        </td>
                    </tr>
                </table>
            </th>
        </tr>
    </table>

    <br>

    <table class="table_img">
        <tbody>
            <tr style="font-size: 25px;">
                <th>
                    <p>Bowie Dick Test</p>
                    <img class="logo-img inline logo-header" style="max-height:250px" height="auto"
                        src="{{ collect($List_data->item->image)->where('coa_type', 'A001')->take(1)->first()->pathfile }}"
                        alt="Logo">
                </th>

                <th>
                    <p>Physicak Monitoring</p>
                    <img class="logo-img inline logo-header" style="max-height:250px" height="auto"
                        src="{{ collect($List_data->item->image)->where('coa_type', 'A002')->take(1)->first()->pathfile }}"
                        alt="Logo">
                </th>
            </tr>
        </tbody>
    </table>

    <div class="text-center" style="font-size: 25px;">
        <b>ผลตรวจสอบ</b> &nbsp; &nbsp;
        <br>
        <b>ผ่าน</b> <input type="checkbox" style="padding-top: 5px; padding-left: 3px" class="largerCheckbox">
        &nbsp; <b>ไม่ผ่าน</b> <input type="checkbox" style="padding-top: 5px; padding-left: 3px" class="largerCheckbox">
    </div>


    {{-- ------------------------------------------------NEW PAGE----------------------------------------------------- --}}


    <div class="page_break"></div>

    {{-- {{dd($List_data)}} --}}

    <div class="text-center" style="font-size: 25px;">
        <p><b>รายการอุปกรณ์</b></p>
    </div>

    <div style="font-size: 20px;">
        <table class="w-full text-base px-2 table_top">
            <thead class="border">
                <tr class="text-white">
                    <th class="text-center px-2 py-1">ลำดับ</th>
                    <th class="text-center px-2 py-1">หมายเลขออเดอร์</th>
                    <th class="text-center px-2 py-1">ชื่อรายการ</th>
                    <th class="text-center px-2 py-1">จำนวน</th>
                    <th class="text-center px-2 py-1">ราคา/หน่วย</th>
                    <th class="text-center px-2 py-1">กระบวนการ</th>
                    {{-- <th class="text-center px-2 py-1">สถานะ</th> --}}
                </tr>
            </thead>
            <tbody class="border-bottom">
                @foreach ($List_data->list as $key => $item)
                {{-- {{dd($item)}} --}}
                <tr class="border-bottom">
                    <td class="text-center px-2 py-1">{{ $key + 1 }}</td>
                    <td class="text-center px-2 py-1">{{ $item->Order_id }}</td>
                    <td class="text-center px-2 py-1">{{ $item->Name }}</td>
                    <td class="text-center px-2 py-1">{{ $item->Quantity }}</td>
                    <td class="text-center px-2 py-1">{{ number_format((float) $item->Price, 2, '.', '') }}</td>
                    <td class="text-center px-2 py-1 uppercase">{{ $item->Process }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
