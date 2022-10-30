<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $List_data->Order_id }}</title>

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
    <link rel="stylesheet" href="{{ public_path('assets/css/deliver_pdf.css') }}">
</head>

<body>

    <body>

        {{-- {{dd($List_data->items)}} --}}

        <!-- Define header and footer blocks before your content -->
        <header>

            <span class="pagenum"></span>

            {{-- <img class="logo-img" src="{{ public_path('assets/image/medihealth_solutions.png') }}" alt="Logo"> --}}
            <div class="row bg-black">
                <div class="column-2 inline">
                    {{-- <img class="logo-img inline logo-header" src="{{ public_path('assets/image/medihealth_solutions.png') }}"
                    alt="Logo"> --}}
                    <p class="text-2xl -mt-5">
                        <b> Medihealth solution co,.ltd</b>
                    </p>
                </div>
                <div class="column-2">
                    <div class="flex">
                        <div class="right">
                            <p class="text-base inline">
                                ใบส่งมอบ / เลขที่ : {{ $List_data->items[0]->Order_id }} <br>
                                วันที่-ออกใบส่งมอบ : {{ $List_data->dateNow }} <br>
                                ผู้ออกเอกสาร : {{ $List_data->User_Deliver }}
                            </p>
                            <div class="inline">
                                <img src="data:image/png;base64, {{ $List_data->qrcode_order }}" alt="qrcode"
                                    height="60px" width="60px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <table class="w-full text-base px-2">
                <tbody class="">
                    <tr class="">
                        <td class="text-left px-1"><b>ออเดอร์ / เลขที่ :</b> {{ $List_data->items[0]->Order_id }}</td>
                        <td class="text-left px-1"><b>สถานพยาบาล / ศูนย์การแพทย์ :</b>
                            {{ $List_data->orders->Customer_name }}</td>
                        <td class="text-left px-1"><b>แผนก :</b> {{ $List_data->orders->Department_name }}</td>
                    </tr>
                    <tr>
                        <td class="text-left px-1"><b>วันที่-เวลารับ : </b>{{ $List_data->orders->Create_at_text }}
                        </td>
                        <td class="text-left px-1"><b>วันที่-เวลาส่ง : </b>{{ $List_data->dateNow }} </td>
                    </tr>
                    <tr>
                        <td class="text-left px-1"><b>ออเดอร์โดย : </b>{{ $List_data->orders->userCreate }}</td>

                        <td class="text-left px-1"><b>รับออเดอร์โดย : </b> {{ $List_data->orders->userApprove }} </td>
                    </tr>
                </tbody>
            </table>

            <hr>
        </header>

        <footer></footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <span class="text-base ">
            <table class="w-full text-base px-2">
                <thead class="border">
                    <tr class="text-white">
                        <th class="text-center px-2 py-1">ลำดับ</th>
                        <th class="text-left px-2 py-1">ชื่อรายการ</th>
                        <th class="text-center px-2 py-1">จำนวน</th>
                        <th class="text-right px-2 py-1">ราคา/หน่วย</th>
                        <th class="text-right px-2 py-1">ยอดรวม</th>
                        <th class="text-center px-2 py-1">กระบวนการ</th>
                        {{-- <th class="text-center px-2 py-1">สถานะ</th> --}}
                    </tr>
                </thead>
                <tbody class="border-bottom">
                    @foreach ($List_data->items as $key => $item)
                    {{-- {{dd($item)}} --}}
                    <tr class="border-bottom">
                        <td class="text-center px-2 py-1">{{ $key + 1 }}</td>
                        <td class="text-left px-2 py-1">{{ $item->Name }}</td>
                        <td class="text-center px-2 py-1">{{ $item->Quantity }}</td>
                        <td class="text-right px-2 py-1">{{ number_format((float) $item->Price, 2, '.', '') }}</td>
                        <td class="text-right px-2 py-1">
                            {{ number_format((float) $item->Price * $item->Quantity, 2, '.', '') }}</td>
                        <td class="text-center px-2 py-1 uppercase">{{ $item->Process }}</td>
                        {{-- <td class="text-center px-2 py-1">
                            {{
                                $item->Item_status == "W" ? "Washing" : ($item->Item_status == "P" ? "Packing" : ($item->Item_status == "S" ? "sterile" : "-" ))
                            }}
                        </td> --}}
                        {{-- <td class="text-center px-2 py-1 uppercase">{{ $item->Item_status }}</td> --}}
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" class="text-right px-2 py-1">รวมเป็นเงิน</td>
                        <td colspan="1" class="text-right px-2 py-1">{{ $List_data->price['total_price'] }} บาท</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right px-2 py-1">ภาษีมูลค่าเพิ่ม 7 %</td>
                        <td colspan="1" class="text-right px-2 py-1">{{ $List_data->price['total_vat'] }} บาท</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right px-2 py-1">({{ $List_data->price['total_price_txt'] }})
                        </td>
                        <td colspan="2" class="text-right px-2 py-1"><b> จำนวนเงินรวมทั้งสิ้น </b></td>
                        <td class="text-right px-2 py-1"><b>{{ $List_data->price['total_price_vat'] }} บาท</b></td>
                    </tr>

                </tbody>
            </table>
            <div class="mt-1 ml-1 remark text-base">
                <p>
                    <b>หมายเหตุ : </b>
                    <div class="text-base border p-2 rounded-lg min-h-85">
                        {{ $List_data->orders->Notes ?: '' }}
                    </div>
                </p>
            </div>

            <table class="w-full px-2 mt-4">
                <tbody class="">
                    <tr class="">
                        <td></td>
                        <td class="text-left px-1" style="width: 30%;">
                            <div class="border p-2 rounded-lg min-h-60 text-center">
                                <p>
                                    ...................................................................
                                </p>
                                ...................../....................../......................
                                <br>
                                ลงชื่อผู้ส่ง
                            </div>
                        </td>
                        <td></td>
                        <td class="text-left px-1" style="width: 30%;">
                            <div class="border p-2 rounded-lg min-h-60 text-center">
                                <p>
                                    ...................................................................
                                </p>
                                ...................../....................../......................
                                <br>
                                ลงชื่อผู้รับ
                            </div>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

        </span>

    </body>

</body>

</html>
