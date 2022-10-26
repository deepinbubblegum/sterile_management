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
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg>
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

                        <div class="text-center mt-3">
                            <div class="lg:grid-cols-1 md:grid-cols-1 mt-1">
                                <div>

                                    <button type="a" id="btn_save_deliver" data-modal-toggle="Deliver_Modal"
                                        class="my-2 w-80 text-white bg-orange-700 hover:bg-orange-800 focus:outline-none focus:ring-4 focus:ring-orange-300 font-medium rounded-lg  px-5 py-2.5 text-center mr-2 mb-2 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                                        Deliver
                                    </button>

                                    <a type="button" id="btn_pdf_deliver" href="/stock/deliver_pdf/{{ $oder_id }}"
                                        target="_blank"
                                        class="my-2 w-80 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-lg  px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        พิมพ์ใบ Deliver
                                    </a>


                                </div>
                            </div>
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


    <!-- All javascript code in this project for now is just for demo DON'T RELY ON IT  -->

</body>

<script>
    $(document).ready(function() {

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
                success: function(response) {


                    html_item_list = ''
                    // Oder_item.forEach(function(item) {
                    for (let item of response.items) {
                        html_item_list += `
                        <tr>
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
                            <td scope="col" class="py-3 px-6">
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
                        </tr>
                        `
                    };

                    $('#list_item_id').html(html_item_list)

                }
            });
        }

        Get_Oder_item()


        // $('#btn_save_deliver').on('click', function() {
        //     var modal_id = $('#Deliver_Modal').data("modal-toggle");
        //     if ($('#Deliver_Modal').hasClass("hidden")) {
        //         $('[modal-backdrop]').remove();
        //     }
        // })


        $(document).on('click', '#btn_save_deliver', function() {
            $('#Modal_Deliver').removeClass('invisible');
        })

        $(document).on('click', '#modal_deliver_close', function() {
            $('#Modal_Deliver').addClass('invisible');
        })


        // Save Deliver
        $('#btn_SaveDeliver').on('click', function() {
            if (signaturePad.isEmpty()) {
                alert("กรูณาเซ็นรับอุปกรณ์");
            }

            var tb_list_Stock = $('#list_item_id tr:has(td)').map(function(index, cell) {
                var $td = $('td', this);
                if ($td.eq(3).attr('value') == 'Stock') {
                    return {
                        item_id: $td.eq(0).attr('value'),
                    }
                }
            }).get();

            if (tb_list_Stock.length == 0) return false

            var data = signaturePad.toDataURL('image/jpeg');
            console.log(data);

            //Usage example:
            var file = dataURLtoFile(data, 'Signature_{{ $oder_id }}.jpg');
            // console.log(file);

            var Formdata = new FormData();
            Formdata.append('files', file);
            Formdata.append('OrderId', '{{ $oder_id }}');


            $.ajax({
                type: "POST",
                url: `/stock/deliver_pdf/Save_Deliver`,
                cache: false,
                contentType: false,
                processData: false,
                data: Formdata,
                dataType: "json",
                success: function(response) {

                    $('#Modal_Deliver').addClass('invisible');

                    if( response.code != '1000' ){
                        alert('ไม่สามารถบันทึกข้อมูลได้')
                    }

                    Get_Oder_item()
                }
            });

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

        $('#clear').on('click', function() {
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
