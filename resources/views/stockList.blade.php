<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sterile traceability</title>

    @include('component.Tagheader')

    <script src="{{ asset('assets/signature_pad.umd.min.js') }}"></script>

    <style>
        .disabledbutton {
            pointer-events: none;
            opacity: 0.4;
        }

        .icon_center {
            margin-left: auto;
            margin-right: auto;
            display: block !important;
        }


        .wrapper {
            /* position: relative; */
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .signature-pad {
            border: black solid;
            /* position: absolute; */
            left: 0;
            top: 0;
            background-color: white;
        }

    </style>
</head>

<body>
    <div x-data="setup()" x-init="$refs.loading.classList.add('hidden');
    setColors(color);" :class="{ 'dark': isDark }" @resize.window="watchScreen()">
        <div class="flex h-screen antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
            <!-- Loading screen -->
            <div x-ref="loading"
                class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-primary-darker">
                Loading.....
            </div>

            @include('component.slidebar')

            @include('component.Loading')


            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden">

                <div class="flex flex-col flex-1 h-full min-h-screen p-4 overflow-x-hidden overflow-y-auto">
                    @include('component.ribbon')
                    {{-- Breadcrumb --}}
                    <div class="mx-auto rounded-md w-full bg-white dark:bg-darker dark:text-light p-4 mb-4 leading-6 ">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="#"
                                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                        {{-- <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg> --}}
                                        <i class="fa-solid fa-box fa-lg mr-2"></i>
                                        Stock
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    {{-- Breadcrumb end --}}

                    <div
                        class="mx-auto h-auto w-full rounded-md bg-white dark:bg-darker dark:text-light shadow-sm p-4 leading-6">

                        <p class="mb-3 text-3xl text-gray-900 dark:text-white">{{ $oder_id }}</p>

                        <div class="overflow-x-auto table-list-item mt-5 mb-5">
                            <table class="mt-3 w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">
                                            <input type="checkbox" id="washing_all_check"
                                                class="w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" />
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            ส่งครบ
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            หมายเลขอุปกรณ์
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            อุปกรณ์
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            จำนวน
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            สถานะอุปกรณ์
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            ชนิดของอุปกรณ์
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Process
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            ราคา
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Instrument type
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Situation
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="list_item_id">
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center mt-3 mb-4">
                            <div class="lg:grid-cols-1 md:grid-cols-1 mt-1">
                                <div>

                                    <button type="button" id="btn_save_deliver" data-modal-toggle="Deliver_Modal"
                                        class="my-2 w-80 text-white bg-orange-700 hover:bg-orange-800 focus:outline-none focus:ring-4 focus:ring-orange-300 font-medium rounded-lg  px-5 py-2.5 text-center mr-2 mb-2 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                                        Deliver
                                    </button>

                                    <button type="button" id="btn_pdf_deliver" href="/stock/deliver_pdf/{{ $oder_id }}"
                                        class="my-2 w-80 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-lg  px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        พิมพ์ใบ Deliver
                                    </button>


                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="overflow-x-auto table-list-item mt-5 mb-5">
                            ประวัติการส่งมอบ
                            <table class="mt-3 w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">
                                            #
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            วันนำเข้าสต็อก
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            วันจัดส่ง
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            รูปนำส่ง
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            รูปลายเซ็นผู้รับ
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="list_his_deliver">
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>


    <!-- Main modal -->


    <!-- Main modal -->
    <div class="fixed z-10 inset-0 w-full invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true" id="Modal_Deliver">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div
                class="inline-block align-bottom bg-white dark:bg-darker dark:text-light rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-top sm:max-w-2xl w-full">
                <div class="bg-white dark:bg-darker dark:text-light px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0">
                            <h3 class="text-lg mt-2 leading-6 font-medium bg-white dark:bg-darker dark:text-light"
                                id="modal-title">
                                <b>ส่งมอบอุปกรณ์ </b>
                            </h3>
                        </div>
                    </div>

                    <div class="div_img justify-center">
                        <p class="mb-1 text-black-400"> รูปภาพ </p>
                        <a
                            class="block p-1 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                            <div class="relative" height="12rem" width="auto" id="list_image">
                                <div class="flex p-2 space-x-4 flex justify-center">
                                    <img class="w-auto" style="height: 12rem; object-fit: contain;" src="" id="View_img"
                                        style="">
                                </div>
                                <button id="btn_View_img_Full" src-data=''
                                    class="absolute top-1 right-1 bg-green-500 text-white p-2 rounded hover:bg-green-800">
                                    view
                                </button>
                            </div>
                        </a>
                        <input accept="image/png, image/jpeg"
                            class="mt-2 w-min-[-webkit-fill-available] w-full block text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            id="file_input_img" type="file" data-type="A005">
                    </div>

                    <p class="mt-2">
                        <div class="text-sm dark:text-light">
                            {{-- <div class="w-full mt-3">
                            <label for="small-input"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">ชื่อลูกค้า</label>
                            <input type="text" data-id="" id="txt_customer_name" name="txt_customer_name"
                                class="block p-2 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div> --}}
                            <div class="w-full mt-3">
                                <label for="message"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">ลายเซ็นลูกค้า</label>
                                <div class="wrapper w-full">
                                    <canvas id="signature-pad" class="signature-pad w-full h-[250px]"></canvas>
                                </div>

                                <button type="button" id="clear"
                                    class="py-2.5 px-5 mr-2 mt-3 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    Clear
                                </button>
                            </div>
                        </div>
                    </p>
                </div>
                <div class="bg-white dark:bg-darker dark:text-light px-4 py-3 sm:px-6 text-center">
                    <button type="button" id="btn_SaveDeliver"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary hover:bg-primary-dark text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        บันทึกการส่งมอบ
                    </button>
                    <button type="button" id="modal_deliver_close"
                        class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        ปิด
                    </button>
                </div>
            </div>
        </div>
    </div>



    {{-- Modal Show Images --}}
    <div id="modal_show_image_full"
        class="z-50 hidden fixed top-0 left-0 w-screen h-screen bg-black/90 flex justify-center items-center overflow-auto">

        <!-- The close button -->
        <a class="fixed z-50 top-6 right-8 text-white text-5xl font-bold cursor-pointer text-orange-500"
            id="Close_show_image">&times;</a>

        <!-- A big image will be displayed here -->
        <img id="modal_Fullimg" class="flex flex-col h-auto max-h-[80%] max-w-[80%]" src="" />
    </div>


    <!-- All javascript code in this project for now is just for demo DON'T RELY ON IT  -->

</body>

<script>
    $(document).ready(function () {

        $(".background_loading").css("display", "block");


        function DateNowDay() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = dd + '-' + mm + '-' + yyyy;
            return (today)
        }

        const Get_Oder_item = async () => {

            $.ajax({
                type: "POST",
                url: `/stock/GetStockItem`,
                data: {
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function (response) {


                    html_item_list = ''
                    // Oder_item.forEach(function(item) {
                    for (let item of response.items) {
                        html_item_list += `
                        <tr>
                            <td class="py-4 px-6">
                                <input id="WS_Check" type="checkbox"
                                        class="${(item.Item_status == 'Deliver' ? 'Deliver_Success' : '')} w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light ${( (item.Item_status != 'Deliver') ? '' : 'hidden' )}"  ${(item.Item_status == 'Deliver' ? 'disabled' : '' )}>
                            </td>
                            <td class="py-4 px-6">
                                <input id="count_Check" type="checkbox"
                                        class="${(item.Item_status == 'Deliver' ? 'Deliver_Success' : '')} w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light ${( (item.Item_status != 'Deliver') ? '' : 'hidden' )}"  ${(item.Item_status == 'Deliver' ? 'disabled' : '' )}>
                            </td>
                            <td scope="col" class="py-3 px-6" value="${item.Item_id}">
                                ${item.Item_id}
                            </td>
                            <td scope="col" class="py-3 px-6">
                                ${item.Name}
                            </td>
                            <td scope="col" class="py-3 px-6">
                                ${item.Quantity}
                            </td>
                            <td scope="col" class="py-3 px-6" value="${(item.Item_status == '' ? '-' : item.Item_status )}">
                                ${(item.Item_status == '' ? '-' : item.Item_status )}
                            </td>
                            <td scope="col" class="py-3 px-6">
                                ${item.Item_Type}
                            </td>
                            <td scope="col" class="py-3 px-6 uppercase">
                                ${item.Process}
                            </td>
                            <td scope="col" class="py-3 px-6">
                                ${item.Price}
                            </td>
                            <td scope="col" class="py-3 px-6">
                                ${item.Instrument_type}
                            </td>
                            <td scope="col" class="py-3 px-6">
                                ${item.Situation_name}
                            </td>
                            <td scope="col" class="hidden" value="${item.Stock_id}">
                            </td>
                        </tr>
                        `
                    };

                    $('#list_item_id').html(html_item_list)
                    $(".background_loading").css("display", "none");
                }
            });


        }

        Get_Oder_item()
        list_Deliver();

        $('#washing_all_check').change(function () {

            if ($(this).prop('checked')) {
                $(`tbody tr td input[id="WS_Check"]`).each(
                    function () {
                        if (!$(this).hasClass("Deliver_Success")) {
                            $(this).prop('checked', true);
                            $(this).val('checked')
                        }

                    });
            } else {
                $(`tbody tr td input[id="WS_Check"]`).each(
                    function () {
                        if (!$(this).hasClass("Deliver_Success")) {
                            $(this).prop('checked', false);
                            $(this).val('')
                        }
                    });
            }
        });


        function list_Deliver() {
            $.ajax({
                type: "POST",
                url: `/stock/Get_list_deliver`,
                data: {
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function (response) {


                    html_item_list = ''
                    // Oder_item.forEach(function(item) {
                    let count = 1;
                    for (let item of response.list) {
                        html_item_list += `
                        <tr>
                            <td scope="col" class="py-3 px-6">
                                ${count}
                            </td>
                            <td scope="col" class="py-3 px-6">
                                ${item.date_in_stock}
                            </td>
                            <td scope="col" class="py-3 px-6">
                                ${item.date_out_stock}
                            </td>
                            <td scope="col" class="py-3 px-6">
                                <button id="btn_view_deliver"  type="button" data-img="${item.img_deliver}"
                                    class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-success inline-flex items-center hover:bg-success-dark focus:outline-none focus:ring focus:ring-success focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                    <i class="fa-solid fa-image fa-lg fill-white icon_center"></i>
                                </button>
                            </td>
                            <td scope="col" class="py-3 px-6">
                                <button id="btn_view_Signature"  type="button" data-img="${item.Signature_custumer}"
                                    class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-success inline-flex items-center hover:bg-success-dark focus:outline-none focus:ring focus:ring-success focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                    <i class="fa-solid fa-image fa-lg fill-white icon_center"></i>
                                </button>
                            </td>
                        </tr>
                        `
                        count++
                    };

                    $('#list_his_deliver').html(html_item_list)
                }
            });
        }


        $(document).on('click', '#btn_view_deliver', function () {
            let path = $(this).attr('data-img');
            let src_img = `{{ asset('assets/image/Deliver/${path}') }}`
            $('#modal_show_image_full').removeClass('hidden')
            $('#modal_Fullimg').attr('src', src_img)
        })

        $(document).on('click', '#btn_view_Signature', function () {
            let path = $(this).attr('data-img');
            let src_img = `{{ asset('assets/image/Signature/${path}') }}`
            $('#modal_show_image_full').removeClass('hidden')
            $('#modal_Fullimg').attr('src', src_img)
        })

        // $('#btn_save_deliver').on('click', function() {
        //     var modal_id = $('#Deliver_Modal').data("modal-toggle");
        //     if ($('#Deliver_Modal').hasClass("hidden")) {
        //         $('[modal-backdrop]').remove();
        //     }
        // })


        $('#file_input_img').on('change', function () {
            let files = $(this).prop('files');
            $('#View_img').attr('src', '')
            preview_img(files)
        })

        $(document).on('click', '#btn_View_img_Full', function () {
            let src_img = $(this).attr('src-data')
            if (src_img == '' | src_img == null) {
                alert('ไม่มีรูปภาพ')
                return false
            }
            $('#modal_show_image_full').removeClass('hidden')
            $('#modal_Fullimg').attr('src', src_img)
        })


        $(document).on('click', '#Close_show_image', function () {
            $('#modal_Fullimg').attr('src', '');
            $('#modal_show_image_full').addClass('hidden')
        })

        function preview_img(files) {

            reader = new FileReader();
            // console.log(files)
            reader.onload = function () {
                let output = document.getElementById('View_img');
                output.src = reader.result;
                output.style.height = "12rem";
                output.style.width = "auto";
                $("#btn_View_img_Full").attr('src-data', reader.result)
                // $('#' + id_modal_preview).attr('src-data', reader.result)
            };

            reader.readAsDataURL(event.target.files[0]);
        }


        $(document).on('click', '#btn_save_deliver', function () {
            signaturePad.clear();
            $('#file_input_img').val('');
            $('#View_img').attr('src', '')
            $('#Modal_Deliver').removeClass('invisible');
        })

        $(document).on('click', '#modal_deliver_close', function () {
            signaturePad.clear();
            $('#file_input_img').val('');
            $('#View_img').attr('src', '')
            $('#Modal_Deliver').addClass('invisible');
        })


        // Save Deliver
        $('#btn_SaveDeliver').on('click', function () {

            let tb_list_Stock = $('#list_item_id tr:has(td)').map(function (index, cell) {
                var $td = $('td', this);
                if (($td.eq(5).attr('value') != 'Deliver') && $('td input#WS_Check', this).prop(
                        'checked')) {
                    return {
                        item_id: $td.eq(2).attr('value'),
                        stock_id: $td.eq(11).attr('value'),
                        check: $('td input#count_Check', this).prop('checked') || 'false',
                    }
                }
            }).get();


            if (tb_list_Stock.length == 0) {
                alert("ไม่มีอุปกรณ์ที่จะส่ง");
                return false
            }

            let file_input_img = document.getElementById("file_input_img").files;

            if (file_input_img[0] == undefined) {
                alert("กรูณาอัปโหลดรูปภาพ");
                return false
            }

            if (signaturePad.isEmpty()) {
                alert("กรูณาเซ็นรับอุปกรณ์");
                return false
            }

            let data_signature = signaturePad.toDataURL('image/jpeg');

            //Usage example:
            let file_signature = dataURLtoFile(data_signature, 'Signature_{{ $oder_id }}.jpg');
            // console.log(file);

            let Formdata = new FormData();
            Formdata.append('file_signature', file_signature);
            Formdata.append('file_input_img', file_input_img[0]);
            Formdata.append('OrderId', '{{ $oder_id }}');
            Formdata.append('list_deliver', JSON.stringify(tb_list_Stock));

            $(".background_loading").css("display", "block");

            $.ajax({
                type: "POST",
                url: `/stock/deliver_pdf/Save_Deliver`,
                cache: false,
                contentType: false,
                processData: false,
                data: Formdata,
                dataType: "json",
                success: function (response) {

                    $('#Modal_Deliver').addClass('invisible');

                    if (response.code != '1000') {
                        alert('ไม่สามารถบันทึกข้อมูลได้')
                    }

                    tb_list_Stock = [];
                    signaturePad.clear();
                    $('#file_input_img').val();
                    $('#View_img').attr('src', '')

                    Get_Oder_item()
                    list_Deliver()
                }
            });

        })


        $('#btn_pdf_deliver').on('click', function () {

            let tb_list_Stock = $('#list_item_id tr:has(td)').map(function (index, cell) {
                let $td = $('td', this);
                if (($td.eq(5).attr('value') != 'Deliver') && $('td input#WS_Check', this).prop(
                        'checked')) {
                    return {
                        item_id: $td.eq(2).attr('value'),
                        stock_id: $td.eq(11).attr('value'),
                        check: $('td input#count_Check', this).prop('checked') || 'false',
                    }
                }
            }).get();

            if (tb_list_Stock.length == 0) {
                alert("กรุณาเลือกอุปกรณ์");
                return false
            }

            var str = JSON.stringify(tb_list_Stock);
            const u = new URLSearchParams(str).toString();
            const url_path = window.location.pathname;
            window.open(`/stock/deliver_pdf/{{ $oder_id }}?list=${str}`, '_blank');

        })

        function dataURLtoFile(dataurl, filename) {

            var arr = dataurl.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);

            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }

            return new File([u8arr], filename, {
                type: mime
            });
        }

        // Signature

        var canvas = document.getElementById('signature-pad');

        // Adjust canvas coordinate space taking into account pixel ratio,
        // to make it look crisp on mobile devices.
        // This also causes canvas to be cleared.
        function resizeCanvas() {
            // When zoomed out to less than 100%, for some very strange reason,
            // some browsers report devicePixelRatio as less than 1
            // and only part of the canvas is cleared then.
            var ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        window.onresize = resizeCanvas;
        resizeCanvas();

        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
        });

        $('#clear').on('click', function () {
            signaturePad.clear();
        })

        // document.getElementById('save-png').addEventListener('click', function() {
        //     if (signaturePad.isEmpty()) {
        //         return alert("Please provide a signature first.");
        //     }

        //     var dataSignature = signaturePad.toDataURL('image/png');
        //     console.log(dataSignature);
        //     window.open(dataSignature);
        // });

        // document.getElementById('clear').addEventListener('click', function() {
        //     signaturePad.clear();
        // });

        // document.getElementById('save-jpeg').addEventListener('click', function() {
        //     if (signaturePad.isEmpty()) {
        //         return alert("Please provide a signature first.");
        //     }

        //     var data = signaturePad.toDataURL('image/jpeg');
        //     console.log(data);
        //     window.open(data);
        // });

    })

</script>
