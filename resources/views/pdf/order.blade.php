<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$order_id}}</title>

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
    <link rel="stylesheet" href="{{ public_path('assets/css/order_pdf.css') }}">
</head>

<body>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            {{-- <img class="logo-img" src="{{ public_path('assets/image/medihealth_solutions.png') }}" alt="Logo"> --}}
            <div class="row bg-black">
                <div class="column-2 inline">
                    {{-- <img class="logo-img inline" src="{{ public_path('assets/image/medihealth_solutions.png') }}"
                        alt="Logo"> --}}
                    <p class="text-2xl -mt-5">
                        <b> Medihealth solution co,.ltd</b>
                    </p>
                </div>
                <div class="column-2">
                    <div class="flex">
                        <div class="right">
                            <p class="text-base inline">
                                ใบออเดอร์ / เลขที่ : {{$order_id}} <br>
                                วันที่-ออกใบออเดอร์ : {{$order_date}} <br>
                                ผู้ออกเอกสาร : {{$print_by}}
                            </p>
                            <div class="inline">
                                <img src="data:image/png;base64, {{ $qrcode_order }}" alt="qrcode" height="60px"
                                    width="60px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <table class="w-full text-base px-2">
                <tbody class="">
                    <tr class="">
                        <td class="text-left px-2"><b>ใบออเดอร์ / เลขที่ :</b> {{$order_id}}</td>
                        <td class="text-left px-2"><b>สถานพยาบาล / ศูนย์การแพทย์ :</b> {{$customer_name}}</td>
                        <td class="text-left px-2"><b>แผนก :</b> {{$department_name}}</td>                    
                    </tr>
                    <tr>
                        <td class="text-left px-2"><b>วันที่-เวลา : </b>{{$create_at}}</td>
                        <td class="text-left px-2"><b>วันที่-เวลารับ : </b>{{$approve_at ? $approve_at : "-"}} </td>
                    </tr>
                    <tr>
                        <td class="text-left px-2"><b>ออเดอร์โดย : </b>{{$create_by}}</td>

                        <td class="text-left px-2"><b>รับออเดอร์โดย : </b> {{$approve_by ? approve_by : "-"}} </td>
                    </tr>
                </tbody>
            </table>

            <hr>
        </header>

        <footer></footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <span class="text-base">
            <table class="w-full text-base px-2">
                <thead class="border">
                    <tr class="text-white">
                        <th class="text-center px-2 py-1">ลำดับ</th>
                        <th class="text-left px-2 py-1">ชื่อรายการ</th>
                        <th class="text-center px-2 py-1">จำนวน</th>
                        <th class="text-right px-2 py-1">ราคา/หน่วย</th>
                        <th class="text-right px-2 py-1">ยอดรวม</th>
                        <th class="text-center px-2 py-1">กระบวนการ</th>
                        <th class="text-center px-2 py-1">สถานะ</th>
                    </tr>
                </thead>
                <tbody class="border-bottom">
                    @foreach ($order_item as $key => $item)
                    <tr class="border-bottom">
                        <td class="text-center px-2 py-1">{{$key+1}}</td>
                        <td class="text-left px-2 py-1">{{$item->Name}}</td>
                        <td class="text-center px-2 py-1">{{$item->Quantity}}</td>
                        <td class="text-right px-2 py-1">{{number_format((float)$item->Price, 2, '.', '');}}</td>
                        <td class="text-right px-2 py-1">{{number_format((float)$item->Price * $item->Quantity, 2, '.', '');}}</td>
                        <td class="text-center px-2 py-1 uppercase">{{$item->Process}}</td>
                        <td class="text-center px-2 py-1"> 
                            {{
                                $item->Item_status == "W" ? "Washing" : ($item->Item_status == "P" ? "Packing" : ($item->Item_status == "S" ? "Sterlie" : "-" ))
                            }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" class="text-right px-2 py-1">รวมเป็นเงิน</td>
                        <td colspan="1" class="text-right px-2 py-1">{{$total_price}} บาท</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right px-2 py-1">ภาษีมูลค่าเพิ่ม 7 %</td>
                        <td colspan="1" class="text-right px-2 py-1">{{$total_vat}} บาท</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right px-2 py-1">({{$total_price_txt}})</td>
                        <td colspan="2" class="text-right px-2 py-1">จำนวนเงินรวมทั้งสิ้น</td>
                        <td class="text-right px-2 py-1">{{$total_price_vat}} บาท</td>
                    </tr>

                </tbody>
            </table>
        </span>
    </body>

</body>

</html>
