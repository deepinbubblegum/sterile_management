<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sterile traceability</title>

    @include('component.Tagheader')

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

    </style>
</head>

<body class="overflow-y-hidden">
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

                <div class="flex flex-col flex-1 h-full min-h-full p-4 ">
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
                                        On-Process
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
                                        <th scope="col" class="py-3 px-6">
                                            SUD
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="list_item_id">
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        {{-- State washing --}}
                        @include('on_process.Washing')

                        <hr>

                        {{-- State Packing --}}
                        @include('on_process.Packing')

                        <hr>

                        {{-- State sterile --}}
                        @include('on_process.Sterile')

                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- All javascript code in this project for now is just for demo DON'T RELY ON IT  -->

</body>


<script>
    $(document).ready(function () {

        $('#option_userQC').select2();
        // alert('{{ $oder_id }}')

        function DateNowDay() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = dd + '-' + mm + '-' + yyyy;
            return (today)
        }


        var Oder_item;
        var all_user;

        const Get_Oder_item = async () => {
            $.ajax({
                type: "POST",
                url: `/Onprocess/GetOderItem`,
                data: {
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function (response) {
                    Oder_item = response.items
                    all_user = response.user
                    table_listItem()
                    option_item_washing(Oder_item);

                    option_item_Packing(Oder_item);
                }
            });
        }

        Get_Oder_item();

        const table_listItem = async () => {

            html_item_list = ''
            // Oder_item.forEach(function(item) {
            for (let item of Oder_item) {
                html_item_list += `
                <tr>
                    <td scope="col" class="py-3 px-6">
                        ${item.Item_id}
                    </td>
                    <td scope="col" class="py-3 px-6">
                        ${item.Name}
                    </td>
                    <td scope="col" class="py-3 px-6">
                        ${item.Quantity}
                    </td>
                    <td scope="col" class="py-3 px-6">
                        ${( (item.Item_status == '' || item.Item_status == null) ? '-' : item.Item_status )}
                    </td>
                    <td scope="col" class="py-3 px-6">
                        ${item.Item_Type.toUpperCase()}
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
                    <td scope="col" class="py-3 px-6">
                        ${( (item.SUD == '' || item.SUD == null) ? '-' : item.SUD )}
                    </td>
                </tr>
                `
            };

            $('#list_item_id').html(html_item_list)

        }

        $('#all_check').change(function () {
            if ($(this).prop('checked')) {
                $('tbody tr td input[type="checkbox"]').each(function () {
                    $(this).prop('checked', true);
                    $(this).val('checked')
                });
            } else {
                $('tbody tr td input[type="checkbox"]').each(function () {
                    $(this).prop('checked', false);
                    $(this).val('')
                });
            }
        });


        $('#Get_table').on('click', function () {
            var tbl = $('#tb_select tr:has(td)').map(function (index, cell) {
                var $td = $('td', this);
                if ($('td input', this).prop('checked')) {
                    return {
                        id: ++index,
                        name: $td.eq(1).text(),
                        age: $td.eq(2).text(),
                        grade: $td.eq(3).text()
                    }
                }
            }).get();

            console.log(tbl)
        })

        //----------------------------------------- Washing -----------------------------------------//
        //----------------------------------------- ------- -----------------------------------------//
        //----------------------------------------- ------- -----------------------------------------//

        Get_Washing_machine();
        GetWashing_List();
        Get_option_washing_performance();
        // obj_table_washing()


        function obj_table_washing() {
            var arrData = [];
            // loop over each table row (tr)
            $("#tb_list_washing tr").each(function () {
                var currentRow = $(this);

                var col1_value = currentRow.find("td:eq(2)").text();
                var col2_value = currentRow.find("td:eq(3)").text();
                var col3_value = currentRow.find("td:eq(4)").text();

                var obj = {};
                obj.col1 = col1_value;
                obj.col2 = col2_value;
                obj.col3 = col3_value;

                arrData.push(obj);
            });

            console.log(arrData);
        }


        function Get_option_washing_performance() {
            $.ajax({
                type: "POST",
                url: `/Onprocess/Get_option_washing_performance`,
                dataType: "json",
                success: function (response) {

                    html_item_list = ''

                    // response.machineswashing
                    for (let item of response.item) {
                        html_item_list +=
                            `<option value='${item.wp_id}'>${item.wp_name}</option>`
                    }

                    $('#washing_performance').html(html_item_list)
                }
            });
        }


        function Get_Washing_machine() {
            $.ajax({
                type: "POST",
                url: `/Onprocess/GetWashing_machine`,
                data: {
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function (response) {

                    html_item_list = ''

                    // response.machineswashing
                    for (let item of response.machineswashing) {
                        html_item_list +=
                            `<option value='${item.MachinesWashing_id}'>${item.MachinesWashingName}</option>`
                    }

                    $('#option_machineswashing').html(html_item_list)
                }
            });
        }


        function GetWashing_List() {
            $.ajax({
                type: "POST",
                url: `/Onprocess/GetWashing_List`,
                data: {
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function (response) {
                    // console.log(response.washing_List)

                    html_list = '';
                    for (let item of response.washing_List) {

                        html_list += `
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="py-4 px-6" value="${item.PassStatus != null ? item.PassStatus : null}">

                                    ${(item.PassStatus == null || item.PassStatus.length == 0) ?
                                        `
                                        <select id="Status_washing"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="" disabled selected>-เลือกสถานะ-</option>
                                            <option value="Pass"> Pass </option>
                                            <option value="Fail"> Fail</option>
                                        </select>
                                        `
                                        : item.PassStatus
                                    }
                                </td>
                                <td class="py-4 px-6">
                                    <button id="btn_washing_image"  type="button" data-washingId="${item.washing_id}"
                                        class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-success inline-flex items-center hover:bg-success-dark focus:outline-none focus:ring focus:ring-success focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                        <i class="fa-solid fa-camera fa-lg fill-white icon_center"></i>
                                    </button>
                                </td>
                                <td class="py-4 px-6" value="${item.washing_id}"> ${item.washing_id} </td>
                                <td class="py-4 px-6" value="${item.item_id}"> ${item.Name} </td>
                                <td class="py-4 px-6" value="${item.MachinesWashing_id}"> ${item.MachinesWashingName} </td>
                                <td class="py-4 px-6" value="${item.Cycle}"> ${item.Cycle} </td>
                                <td class="py-4 px-6" value="${(item.QTY == null ? '' : item.QTY)}"> ${item.QTY} </td>
                                <td class="py-4 px-6" value="${(item.PassStatus == null) ? '' : item.PassStatus}"> ${(item.PassStatus == null || item.PassStatus.length == 0) ? '-' : item.PassStatus} </td>
                                <td class="py-4 px-6" value="${(item.wp_id == null) ? '' : item.wp_id}"> ${item.wp_name == null  ? '-' : item.wp_name} </td>
                                <td class="py-4 px-6" value=""> ${item.Create_at} </td>
                                <td class="py-4 px-6" value="${(item.SUD == null) ? '' : item.SUD}"> ${item.SUD == null  ? '-' : item.SUD} </td>
                                <td class="py-4 px-6" value=""> - </td>
                            </tr>
                        `
                    }
                    $('#tb_list_washing').html(html_list)


                    // <td class="py-4 px-6"> <input id="WS_Check" type="checkbox" ${(item.PassStatus == 'false' ? '' : 'Checked')}
                    //         class="${(item.PassStatus == 'false' ? 'check_OnProcess_Washing' : '')} w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light"  ${(item.PassStatus == 'true' ? 'disabled' : '' )}>
                    // </td>

                }
            });
        }


        function option_item_washing(Oder_item) {

            html_item_list = ''

            // response.machineswashing
            for (let item of Oder_item) {
                // if (item.Item_status == '' || item.Item_status == null || item.Item_status == '-') {
                //     html_item_list += `<option value='${item.Item_id}'>${item.Item_id} - ${item.Name} </option>`
                // }
                if (item.washing_stete == '' || item.washing_stete == null) {
                    html_item_list += `<option value='${item.Item_id}'>${item.Item_id} - ${item.Name} </option>`
                }
            }

            $('#option_item_washing').html(html_item_list)
        }


        function item_washing_checkDup(Item_id) {
            let res = true;
            $("#tb_list_washing tr").each(function () {
                let currentRow = $(this);
                let item_list_id = currentRow.find("td:eq(3)").attr('value');
                let washing_status = currentRow.find("td:eq(7)").attr('value');
                // console.log(washing_status)
                if (Item_id == item_list_id && washing_status == '') {
                    res = false;
                }
            });
            return res;
        }


        $('#item_add_washing').on('click', function () {

            let machines_id = $('#option_machineswashing').find(":selected").val();
            let machines_name = $('#option_machineswashing').find(":selected").text();
            let item_washing = $('#option_item_washing').find(":selected").val();

            let washing_performance = $('#washing_performance').find(":selected").val();
            let washing_performance_text = $('#washing_performance').find(":selected").text();

            let SUD = $('#SUD').val();
            let Washing_cycle = $('#Washing_cycle').val();



            if (item_washing == null) {
                alert('ไม่มี item')
                return false;
            } else if (Washing_cycle == '') {
                alert('กรุณากรอก cycle')
                return false;
            }

            $(`#option_item_washing option[value='${item_washing}']`).remove();

            let _Item = Oder_item.filter(v => v.Item_id == item_washing);


            resultChk = item_washing_checkDup(_Item[0].Item_id, )
            if (resultChk == false) return resultChk;


            // alert(machines);
            row = $(`<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"> </tr>`);
            // col1 = $( `<td class="py-4 px-6"> <input id="WS_Check" type="checkbox" class="check_OnProcess_Washing w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" /> </td>`);
            col1 = $(`<td class="py-4 px-6"> - </td>`);
            col2 = $(`<td class="py-4 px-6"> - </td>`);
            // col2 = $(
            //     `<td class="py-4 px-6" value="${_Item[0].washing_id == null ? '-' : _Item[0].washing_id}" > ${_Item[0].washing_id == null ? '-' : _Item[0].washing_id} </td>`
            // );
            col3 = $(` <td class="py-4 px-6" value=""> - </td> `);
            col4 = $(`<td class="py-4 px-6" value="${_Item[0].Item_id}" >${_Item[0].Name}</td>`);
            col5 = $(`<td class="py-4 px-6" value="${machines_id}" >${machines_name}</td>`);
            col6 = $(`<td class="py-4 px-6" value="${Washing_cycle}"> ${Washing_cycle} </td>`);
            col7 = $(`<td class="py-4 px-6" value="${_Item[0].Quantity}" >${_Item[0].Quantity}</td>`);
            col8 = $(
                `<td class="py-4 px-6" value="${_Item[0].Item_status}" >${_Item[0].Item_status}</td>`
            );
            col9 = $(
                `<td class="py-4 px-6" value="${washing_performance}"> ${washing_performance_text} </td>`
            );
            col10 = $(`<td class="py-4 px-6" value="${DateNowDay()}"> ${DateNowDay()} </td>`);
            col11 = $(`<td class="py-4 px-6" value="${SUD}"> ${SUD} </td>`);
            col12 = $(
                `<td class="py-4 px-6"> <button type="button" id="item_Remove_washing" class="py-2 px-3 text-xs font-medium text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"> x </button> </td>`
            )
            row.append(col1, col2, col3, col4, col5, col6, col7, col8, col9, col10, col11, col12)
                .prependTo(
                    "#tb_list_washing");

            $('#SUD').val('');

        })



        $("#tb_list_washing").on("click", "#item_Remove_washing", function () {
            let currentRow = $(this).closest("tr");
            let item_name = currentRow.find("td:eq(3)").text();
            let item_id = currentRow.find("td:eq(3)").attr('value');
            $('#option_item_washing').append($('<option>', {
                value: item_id,
                text: `${item_id} - ${item_name}`
            }));
            $(this).closest("tr").remove();
        });


        // $("#tb_list_washing").on('click', '#item_Remove_washing_Database', function(){
        //     alert('456')
        // })

        $('#washing_all_check').change(function () {
            if ($(this).prop('checked')) {
                $(`tbody tr td input[type="checkbox"][class*="check_OnProcess_Washing"]`).each(
                    function () {
                        $(this).prop('checked', true);
                        $(this).val('checked')
                    });
            } else {
                $(`tbody tr td input[type="checkbox"][class*="check_OnProcess_Washing"]`).each(
                    function () {
                        $(this).prop('checked', false);
                        $(this).val('')
                    });
            }
        });


        $('#btn_save_washing').on('click', function () {
            var tb_list_washing = $('#tb_list_washing tr:has(td)').map(function (index, cell) {
                var $td = $('td', this);

                if ($td.eq(7).attr('value') != 'Fail') {
                    return {
                        // check: $('td input#WS_Check', this).prop('checked') || null,
                        status: $('td select#Status_washing', this).find(":selected").val() ||
                            $td.eq(0).attr('value') || null,
                        washing_id: $td.eq(2).attr('value'),
                        item_id: $td.eq(3).attr('value'),
                        Machines_id: $td.eq(4).attr('value'),
                        Cycle: $td.eq(5).attr('value'),
                        QTY: $td.eq(6).attr('value'),
                        SUD: $td.eq(10).attr('value'),
                        Performance: $td.eq(8).attr('value'),
                    }
                }
                // if ($('td input', this).prop('checked')) {
                //     return {
                //         name: $td.eq(1).text(),
                //         age: $td.eq(2).text(),
                //         grade: $td.eq(3).text()
                //     }
                // }
            }).get();

            console.log(tb_list_washing)


            if (tb_list_washing.length == 0) return false

            $.ajax({
                type: "POST",
                url: `/Onprocess/New_WashingList`,
                data: {
                    WashingItem: tb_list_washing,
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function (response) {
                    Oder_item = response.items
                    table_listItem()
                    option_item_washing(response.items);
                    GetWashing_List();

                    Get_Oder_item();

                }
            });

        })

        // ----------------------------- IMAGES----------------------------------

        $(document).on('click', '#btn_washing_image', function () {
            $('#textIdwashing').text($(this).attr('data-washingId'))
            $('#id_washing_modal').val($(this).attr('data-washingId'))
            $('#Modal_Img_washing').removeClass('invisible');

            Getwashing_Img_list($(this).attr('data-washingId'))
        })


        $(document).on('click', '#modal_washing_close', function () {
            $('#Modal_Img_washing').addClass('invisible');
            // $('#Input_Image_washing').val()
            document.getElementById("Input_Image_washing").value = null;
            let output = document.getElementById('washing_img_preview');
            output.src = null;
            // output.style.height = "0px";
            // output.style.width = "auto";
        })


        $('#Input_Image_washing').on('change', function () {
            let files = document.getElementById("Input_Image_washing").files;

            reader = new FileReader();
            // console.log(files)
            reader.onload = function () {
                let output = document.getElementById('washing_img_preview');
                output.src = reader.result;
                output.style.height = "20rem";
                output.style.width = "auto";
            };
            reader.readAsDataURL(event.target.files[0]);
        })


        $('#add_img_washing').on('click', function () {
            // $('#washing_img_preview').attr('src')
            let files = document.getElementById("Input_Image_washing").files;
            let washing_id = $('#id_washing_modal').val()

            if (files[0] == undefined) return 0;

            var Formdata = new FormData();

            Formdata.append('washing_id', washing_id);
            Formdata.append('files', files[0]);



            $.ajax({
                type: "POST",
                url: `/Onprocess/New_ImageWashing`,
                cache: false,
                contentType: false,
                processData: false,
                data: Formdata,
                dataType: "json",
                success: function (response) {
                    document.getElementById("Input_Image_washing").value = null;
                    let output = document.getElementById('washing_img_preview');
                    output.src = null;
                    output.style.height = "0px";
                    output.style.width = "auto";

                    Getwashing_Img_list(washing_id)
                }
            });
        })


        function Getwashing_Img_list(washing_id) {
            $.ajax({
                type: "POST",
                url: `/Onprocess/GetWashing_Img_list`,
                data: {
                    washing_id: washing_id
                },
                success: function (response) {
                    // console.log(response)

                    html_list = '';
                    for (let item of response.washing_img) {

                        html_list += `
                        <a class="block p-1 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                            <div class="relative" height="40px" width="auto" id="list_image_washing">
                                <img class="w-full" style="height: 15rem; object-fit: contain;" src="{{ asset('assets/image/washing/${item.image}') }}"
                                    alt="dummy-image">

                                <button id="btn_View_img_washing" src-data='${item.image}'
                                    class="absolute top-1 right-1 bg-green-500 text-white p-2 rounded hover:bg-green-800">
                                    view
                                </button>

                                <button id="btn_remove_img_washing" data-ID_img="${item.image_id}" data-washingID="${item.washing_id}" data-image="${item.image}"
                                    class="absolute bottom-1 right-1 bg-red-500 text-white p-2 rounded hover:bg-red-800">
                                    remove
                                </button>

                            </div>
                        </a>
                        `
                        // <td class="py-4 px-6" value="${(item.Item_status == null ? '' : item.Item_status)}"> ${item.Item_status} </td>
                    }
                    $('#list_img_washing').html(html_list)
                }
            });

        }


        $(document).on('click', '#btn_remove_img_washing', function (e) {
            // e.preventDefault()
            let image_id = $(this).attr('data-ID_img')
            let washing_id = $(this).attr('data-washingID')
            let image = $(this).attr('data-image')

            $.ajax({
                type: "POST",
                url: `/Onprocess/Delete_Img_list_washing`,
                data: {
                    washing_id: washing_id,
                    image_id: image_id,
                    image: image
                },
                success: function (response) {
                    // console.log(response)
                    Getwashing_Img_list(washing_id)
                }
            });
        });


        $(document).on('click', '#btn_View_img_washing', function () {
            let src_img = $(this).attr('src-data')
            $('#modal_show_image_washing').removeClass('hidden')
            $('#modal_Fullimg_Wahsing').attr('src', `{{ asset('assets/image/washing/${src_img}') }}`)
        })

        $(document).on('click', '#Close_show_image_washing', function () {
            $('#modal_Fullimg_Wahsing').attr('src', '');
            $('#modal_show_image_washing').addClass('hidden')
        })




        //----------------------------------------- END Washing -------------------------------------//
        //----------------------------------------- ------- -----------------------------------------//


        //----------------------------------------- ------- -----------------------------------------//
        //----------------------------------------- Packing -----------------------------------------//

        GetPacking_List();
        option_userQC();

        function GetPacking_List() {
            $.ajax({
                type: "POST",
                url: `/Onprocess/GetPacking_List`,
                data: {
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function (response) {
                    // console.log(response.Packing_List)

                    html_list = '';
                    for (let item of response.Packing_List) {

                        html_list += `
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a type="button" href="/Onprocess/pdf/{{ $oder_id }}/${item.item_id}/${item.packing_id}" target="_blank"
                                        class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                        <i class="fa-solid fa-print fa-lg fill-white icon_center"></i>
                                    </a>

                                    <button id="btn_packing_image"  type="button" data-packingId="${item.packing_id}"
                                        class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-success inline-flex items-center hover:bg-success-dark focus:outline-none focus:ring focus:ring-success focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                        <i class="fa-solid fa-camera fa-lg fill-white icon_center"></i>
                                    </button>

                                </td>
                                <td class="py-4 px-6" value="${item.packing_id}"> ${item.packing_id} </td>
                                <td class="py-4 px-6" value="${item.item_id}"> ${item.item_id} </td>
                                <td class="py-4 px-6" value="${item.item_id}"> ${item.Name} </td>
                                <td class="py-4 px-6" value="${item.Machine_id}"> ${item.Machine_name} </td>
                                <td class="py-4 px-6" value="${item.Program_id}"> ${item.Program_name} </td>
                                <td class="py-4 px-6" value="${item.Cycle}"> ${item.Cycle} </td>

                                <td class="py-4 px-6" value="${item.Qc_by}"> ${item.UserName_QC} </td>
                                <td class="py-4 px-6" value="${(item.Quantity == null ? '' : item.Quantity)}"> ${item.Quantity} </td>
                                <td class="py-4 px-6" value="${item.Exp_date}"> ${item.Exp_date} </td>
                                <td class="py-4 px-6" value="${(item.Note == null ? '' : item.Note)}" > ${(item.Note == null ? '-' : item.Note)} </td>
                                <td class="py-4 px-6" value=""> ${item.Create_at} </td>
                                <td class="py-4 px-6" value=""> - </td>
                                <td class="py-4 px-6" id="Sterile_Pass" value="${item.PassStatus}" style="display:none;"> - </td>
                            </tr>
                        `
                        // <td class="py-4 px-6" value="${(item.Item_status == null ? '' : item.Item_status)}"> ${item.Item_status} </td>
                    }
                    $('#tb_list_packing').html(html_list)
                }
            });
        }


        function option_userQC() {

            $.ajax({
                type: "POST",
                url: `/Onprocess/GetUserQC`,
                data: {
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function (response) {
                    html_user_list = ''

                    // response.machineswashing
                    for (let item of response.user) {
                        html_user_list +=
                            `<option value='${item.User_id}' data-Group_id="${item.Group_id}">${item.Name} </option>`
                    }

                    $('#option_userQC').html(html_user_list)
                }
            });
        }


        var program_sterile;


        function option_item_Packing(Oder_item) {
            // console.log(Oder_item)
            html_item_list = ''

            // response.machineswashing
            for (let item of Oder_item) {
                if (item.Item_status == 'Washing Finish') {
                    html_item_list +=
                        `<option value='${item.Item_id}' data-process="${item.Process}">${item.Item_id} - ${item.Name} </option>`
                }
            }

            $('#item_packing').html(html_item_list)
            Get_sterile_machine()
        }


        $('#item_packing').on('change', function () {
            Get_sterile_machine()
        })


        function Get_sterile_machine() {

            // alert($('#item_packing').find(":selected").val());

            $.ajax({
                type: "POST",
                url: `/Onprocess/Getsterile_machine`,
                data: {
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function (response) {
                    console.log(response)

                    // alert($('#option_machine_sterile').attr('data-type'))

                    let item_process = $('#item_packing').find(":selected").data("process")
                    // alert($('#item_packing').find(":selected").data("process"))
                    html_list_machine_sterile = ''

                    if (item_process == $('#option_machine_sterile').attr('data-type')) {
                        return 0;
                    }

                    for (let item of response.items_machine) {
                        if (item.Machine_type == item_process) {
                            html_list_machine_sterile +=
                                `<option value='${item.Machine_id}' data-process='${item.Machine_type}' >${item.Machine_name}</option>`
                        }
                    }

                    $('#option_machine_sterile').html(html_list_machine_sterile)
                    $('#name_process_machine_sterile').val($('#option_machine_sterile').find(
                        ":selected").data("process"))

                    $('#option_machine_sterile').attr('data-type', item_process)

                    // console.log(response.items_process)
                    html_list_process_sterile = ''
                    for (let item_pc of response.items_process) {
                        if (item_pc.Machine_type == item_process) {
                            html_list_process_sterile +=
                                `<option value='${item_pc.Machine_type}' >${item_pc.Machine_type}</option>`
                        }
                    }
                    $('#option_Process_sterile').html(html_list_process_sterile)
                    $('#option_Process_sterile').val($('#option_machine_sterile').find(":selected")
                        .data("process"))



                    program_sterile = response.items_program
                    html_list_program_sterile = ''
                    for (let item_p of response.items_program) {
                        if (item_p.Machine_id == $('#option_machine_sterile').find(":selected")
                            .val()) {
                            html_list_program_sterile +=
                                `<option value='${item_p.Program_id}' >${item_p.Program_name}</option>`
                        }
                    }
                    $('#option_program_sterile').html(html_list_program_sterile)

                }
            });
        }


        // Change Machine
        $('#option_machine_sterile').on('change', function () {
            $('#option_Process_sterile').val($(this).find(":selected").data("process"))
            // console.log(program_sterile)

            html_list_program_sterile = ''
            for (let item_p of program_sterile) {
                if (item_p.Machine_id == $('#option_machine_sterile').find(":selected").val()) {
                    html_list_program_sterile +=
                        `<option value='${item_p.Program_id}' >${item_p.Program_name}</option>`
                }
            }
            $('#option_program_sterile').html(html_list_program_sterile)
        })


        // Change Process
        $('#option_Process_sterile').on('change', function () {
            // $('#option_machine_sterile').val()
            $(`#option_machine_sterile option[data-process='${($(this).val())}']`).prop("selected",
                true);
        })


        function item_packing_checkDup(Item_id) {
            let res = true;
            $("#tb_list_packing tr").each(function () {
                let currentRow = $(this);
                let item_list_id = currentRow.find("td:eq(3)").attr('value');
                let Status = currentRow.find("td:eq(13)").attr('value');
                // console.log(item_list_id)
                if (Item_id == item_list_id && Status == 'true') {
                    res = false;
                }
            });
            return res;
        }

        $('#all_check_Packing').change(function () {
            if ($(this).prop('checked')) {
                $(`tbody tr td input[type="checkbox"][class*="check_OnProcess_Packing"]`).each(
                    function () {
                        $(this).prop('checked', true);
                        $(this).val('checked')
                    });
            } else {
                $(`tbody tr td input[type="checkbox"][class*="check_OnProcess_Packing"]`).each(
                    function () {
                        $(this).prop('checked', false);
                        $(this).val('')
                    });
            }
        });


        $('#item_add_packing').on('click', function () {

            let machines_id = $('#option_machine_sterile').find(":selected").val();
            let machines_name = $('#option_machine_sterile').find(":selected").text();

            let program_id = $('#option_program_sterile').find(":selected").val();
            let program_name = $('#option_program_sterile').find(":selected").text();

            let item_packing = $('#item_packing').find(":selected").val();

            let Cycle = $('#packing_cycle').val();

            let userQC_id = $('#option_userQC').find(":selected").val();
            let userQC_name = $('#option_userQC').find(":selected").text();

            let Note_Packing = $('#notes_packing_messages').val();

            if (item_packing == null) {
                alert('ไม่มี item')
                return false;
            } else if (Cycle == '') {
                alert('กรุณากรอก cycle')
                return false;
            }

            $(`#item_packing option[value='${item_packing}']`).remove();

            let _Item = Oder_item.filter(v => v.Item_id == item_packing);
            // resultChk = item_packing_checkDup(_Item[0].Item_id)
            // if (resultChk == false) return resultChk;
            console.log(_Item)

            // alert(machines);
            row = $(`<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"> </tr>`);
            // col1 = $(`<td scope="col" class="py-3 px-6 text-center">
            //             <input type="checkbox" id="PK_Check"
            //                 class="w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" disabled />
            //         </td>`);
            // col1 = $(`<td scope="col" class="py-3 px-6 text-center"> - </td>`);
            // col2 = $(
            //     `<td
            //         class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">

            //         <button
            //             class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-success inline-flex items-center hover:bg-success-dark focus:outline-none focus:ring focus:ring-success focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
            //             <i
            //                 class="fa-solid fa-camera fa-lg fill-white icon_center"></i>
            //         </button>

            //         <button
            //             class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
            //             <i
            //                 class="fa-regular fa-file-image fa-lg  fill-white icon_center"></i>
            //         </button>
            //     </td>`
            // );
            col2 = $(
                `<td
                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                   -
                </td>`
            );
            col3 = $(
                `<td class="py-4 px-6" value="${_Item[0].packing_id == null ? '-' : _Item[0].packing_id}"> ${_Item[0].packing_id == null ? '-' : _Item[0].packing_id} </td>`
            );
            col4 = $(`<td class="py-4 px-6" value="${_Item[0].Item_id}"> ${_Item[0].Item_id} </td>`);
            col5 = $(
                `<td class="py-4 px-6" value="${_Item[0].Item_id}" data-process="${_Item[0].Process}"> ${_Item[0].Name} </td>`
            );
            col6 = $(`<td class="py-4 px-6" value="${machines_id}"> ${machines_name} </td>`);
            col7 = $(`<td class="py-4 px-6" value="${program_id}"> ${program_name} </td>`);
            col8 = $(`<td class="py-4 px-6" value="${Cycle}"> ${Cycle} </td>`);
            col10 = $(`<td class="py-4 px-6" value="${userQC_id}"> ${userQC_name} </td>`);
            col11 = $(`<td class="py-4 px-6" value="${_Item[0].Quantity}"> ${_Item[0].Quantity} </td>`);
            col12 = $(
                `<td class="py-4 px-6" value="" data-addExp="${_Item[0].Expire}"> ${_Item[0].Expire} </td>`
            );
            col13 = $(`<td class="py-4 px-6" value="${Note_Packing}" > ${Note_Packing} </td>`);
            col14 = $(`<td class="py-4 px-6" value="${DateNowDay()}" >${DateNowDay()}</td>`);
            col15 = $(
                `<td class="py-4 px-6"> <button type="button" id="item_Remove_Packing" class="py-2 px-3 text-xs font-medium text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"> x </button> </td>`
            )
            row.append(col2, col3, col4, col5, col6, col7, col8, col10, col11, col12, col13,
                col14, col15).prependTo("#tb_list_packing");

            // $(selector).trigger("change");
            Get_sterile_machine();
            $('#notes_packing_messages').val('');
        })

        $("#tb_list_packing").on("click", "#item_Remove_Packing", async function () {
            let currentRow = $(this).closest("tr");
            let item_name = currentRow.find("td:eq(3)").text();
            let item_id = currentRow.find("td:eq(3)").attr('value');
            let process = currentRow.find("td:eq(3)").attr('data-process');
            $('#item_packing').append($('<option>', {
                value: item_id,
                text: `${item_id} - ${item_name}`,
                "data-process": process
            }));
            await Get_sterile_machine();
            $(this).closest("tr").remove();
        });


        $('#btn_save_packing').on('click', function () {
            var tb_list_packing = $('#tb_list_packing tr:has(td)').map(function (index, cell) {
                var $td = $('td', this);
                return {
                    // check: $('td input#PK_Check', this).prop('checked') || 'false',
                    packing_id: $td.eq(1).attr('value'),
                    item_id: $td.eq(2).attr('value'),
                    Machines_id: $td.eq(4).attr('value'),
                    program_id: $td.eq(5).attr('value'),
                    Cycle: $td.eq(6).attr('value'),
                    user_QC: $td.eq(7).attr('value'),
                    QTY: $td.eq(8).attr('value'),
                    Exp: $td.eq(9).attr('value'),
                    AddExp: $td.eq(9).attr("data-addExp"),
                    Note: $td.eq(10).attr("value"),
                }
            }).get();

            console.log(tb_list_packing)

            if (tb_list_packing.length == 0) return false

            $.ajax({
                type: "POST",
                url: `/Onprocess/New_PackingList`,
                data: {
                    PackingItem: tb_list_packing,
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function (response) {
                    Oder_item = response.items
                    GetPacking_List()
                    Get_Oder_item();
                    Getsterile_List()
                }
            });

        })


        $('#btn_pdf_packing').on('click', function () {
            var tb_list_packing = $('#tb_list_packing tr:has(td)').map(function (index, cell) {
                var $td = $('td', this);
                return {
                    packing_id: $td.eq(1).attr('value'),
                    item_id: $td.eq(2).attr('value'),
                }
            }).get();

            if (tb_list_packing.length == 0) return false

            $('')
            // windows.local('pdf/test');

        })


        // ----------------------------- Image

        $(document).on('click', '#btn_packing_image', function () {
            $('#textIdpacking').text($(this).attr('data-packingId'))
            $('#id_packing_modal').val($(this).attr('data-packingId'))
            $('#Modal_Img_Packing').removeClass('invisible');

            GetPacking_Img_list($(this).attr('data-packingId'))
        })


        $(document).on('click', '#modal_Packing_close', function () {
            $('#Modal_Img_Packing').addClass('invisible');
            // $('#Input_Image_packing').val()
            document.getElementById("Input_Image_packing").value = null;
            let output = document.getElementById('packing_img_preview');
            output.src = null;
            output.style.height = "0px";
            output.style.width = "auto";
        })


        $('#Input_Image_packing').on('change', function () {
            let files = document.getElementById("Input_Image_packing").files;

            reader = new FileReader();
            // console.log(files)
            reader.onload = function () {
                let output = document.getElementById('packing_img_preview');
                output.src = reader.result;
                output.style.height = "20rem";
                output.style.width = "auto";
            };
            reader.readAsDataURL(event.target.files[0]);
        })


        $('#add_img_pakcing').on('click', function () {
            // $('#packing_img_preview').attr('src')
            let files = document.getElementById("Input_Image_packing").files;
            console.log(files[0])
            let packing_id = $('#id_packing_modal').val()

            if (files[0] == undefined) return 0;

            var Formdata = new FormData();

            Formdata.append('packing_id', packing_id);
            Formdata.append('files', files[0]);



            $.ajax({
                type: "POST",
                url: `/Onprocess/New_ImagePacking`,
                cache: false,
                contentType: false,
                processData: false,
                data: Formdata,
                dataType: "json",
                success: function (response) {
                    document.getElementById("Input_Image_packing").value = null;
                    let output = document.getElementById('packing_img_preview');
                    output.src = null;
                    output.style.height = "0px";
                    output.style.width = "auto";

                    GetPacking_Img_list(packing_id)
                }
            });
        })


        function GetPacking_Img_list(packing_id) {
            $.ajax({
                type: "POST",
                url: `/Onprocess/GetPacking_Img_list`,
                data: {
                    packing_id: packing_id
                },
                success: function (response) {
                    // console.log(response)

                    html_list = '';
                    for (let item of response.packing_img) {

                        html_list += `
                        <a class="block p-1 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                            <div class="relative" height="40px" width="auto">
                                <img class="w-full" style="height: 15rem; object-fit: contain;" src="{{ asset('assets/image/packing/${item.image}') }}"
                                    alt="dummy-image">

                                    <button id="btn_View_img_packing" src-data="${item.image}"
                                    class="absolute top-1 right-1 bg-green-500 text-white p-2 rounded hover:bg-green-800">
                                        view
                                    </button>

                                <button id="btn_remove_img_packing" data-ID_img="${item.image_id}" data-PackingID="${item.packing_id}" data-image="${item.image}"
                                    class="absolute bottom-1 right-1 bg-red-500 text-white p-2 rounded hover:bg-red-800">
                                    remove
                                </button>
                            </div>
                        </a>
                        `
                        // <td class="py-4 px-6" value="${(item.Item_status == null ? '' : item.Item_status)}"> ${item.Item_status} </td>
                    }
                    $('#list_img_packing').html(html_list)
                }
            });

        }


        $(document).on('click', '#btn_remove_img_packing', function () {
            let image_id = $(this).attr('data-ID_img')
            let packing_id = $(this).attr('data-PackingID')
            let image = $(this).attr('data-image')

            $.ajax({
                type: "POST",
                url: `/Onprocess/Delete_Img_list`,
                data: {
                    packing_id: packing_id,
                    image_id: image_id,
                    image: image
                },
                success: function (response) {
                    // console.log(response)
                    GetPacking_Img_list(packing_id)
                }
            });

        });


        $(document).on('click', '#btn_View_img_packing', function () {
            let src_img = $(this).attr('src-data')
            $('#modal_show_image_packing').removeClass('hidden')
            $('#modal_Fullimg_packing').attr('src', `{{ asset('assets/image/packing/${src_img}') }}`)
        })

        $(document).on('click', '#Close_show_image_packing', function () {
            $('#modal_Fullimg_packing').attr('src', '');
            $('#modal_show_image_packing').addClass('hidden')
        })

        //----------------------------------------- END Packing -------------------------------------//
        //----------------------------------------- ------- -----------------------------------------//


        //----------------------------------------- ------- -----------------------------------------//
        //----------------------------------------- sterile -----------------------------------------//

        Getsterile_List();


        function Getsterile_List() {
            $.ajax({
                type: "POST",
                url: `/Onprocess/Getsterile_List`,
                data: {
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function (response) {
                    // console.log(response.sterile_List)

                    html_list = '';
                    for (let item of response.sterile_List) {

                        html_list += `
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="py-4 px-6" value="${item.PassStatus != null ? item.PassStatus : null}">
                                ${(item.PassStatus == null || item.PassStatus.length == 0) ?
                                    `
                                    <select id="Status_Sterile"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="" disabled selected>-เลือกสถานะ-</option>
                                        <option value="Pass"> Pass </option>
                                        <option value="Fail"> Fail</option>
                                    </select>
                                    `
                                    : item.PassStatus
                                }
                                </td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <button id="btn_Sterile_image"  type="button" data-SterileId="${item.sterile_qc_id}"
                                        class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-success inline-flex items-center hover:bg-success-dark focus:outline-none focus:ring focus:ring-success focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                        <i class="fa-solid fa-camera fa-lg fill-white icon_center"></i>
                                    </button>
                                </td>
                                <td class="py-4 px-6" value="${item.sterile_qc_id}"> ${item.sterile_qc_id} </td>
                                <td class="py-4 px-6" value="${item.item_id}"> ${item.item_id} </td>
                                <td class="py-4 px-6" value="${item.item_id}"> ${item.Name} </td>
                                <td class="py-4 px-6" value="${(item.Quantity == null ? '' : item.Quantity)}"> ${item.Quantity} </td>
                                <td class="py-4 px-6" value="${item.Exp_date}"> ${item.Exp_date} </td>
                                <td class="py-4 px-6" value="${item.Machine_id}"> ${item.Machine_name} </td>
                                <td class="py-4 px-6" value="${item.Program_id}"> ${item.Program_name} </td>
                                <td class="py-4 px-6" value="${item.Cycle}"> ${item.Cycle} </td>
                                <td class="py-4 px-6" value="${(item.PassStatus == null ? '' : item.PassStatus)}"> ${(item.PassStatus == null ? '-' : item.PassStatus)} </td>
                                <td class="py-4 px-6" value="${(item.Note == null ? '' : item.Note)}" > ${(item.Note == null ? '-' : item.Note)} </td>
                            </tr>
                        `
                        // <td class="py-4 px-6" value="${(item.Item_status == null ? '' : item.Item_status)}"> ${item.Item_status} </td>
                    }
                    $('#tb_list_sterile').html(html_list)
                }
            });
        }


        $('#all_check_sterile').change(function () {
            if ($(this).prop('checked')) {
                $(`tbody tr td input[type="checkbox"][class*="check_OnProcess_sterile"]`).each(
                    function () {
                        $(this).prop('checked', true);
                        $(this).val('checked')
                    });
            } else {
                $(`tbody tr td input[type="checkbox"][class*="check_OnProcess_sterile"]`).each(
                    function () {
                        $(this).prop('checked', false);
                        $(this).val('')
                    });
            }
        });

        $('#btn_save_sterile').on('click', function () {
            var tb_list_sterile = $('#tb_list_sterile tr:has(td)').map(function (index, cell) {
                var $td = $('td', this);
                if ($td.eq(10).attr('value') != 'Fail') {
                    return {
                        // check: $('td input#ST_Check', this).prop('checked'),
                        status: $('td select#Status_Sterile', this).find(":selected").val() ||
                            $td.eq(10).attr('value') || null,
                        item_id: $td.eq(3).attr('value'),
                        sterile_qc_id: $td.eq(2).attr('value'),
                    }
                }
            }).get();

            console.log(tb_list_sterile)

            if (tb_list_sterile.length == 0) return false

            $('#option_machine_sterile').attr('data-type', '')

            $.ajax({
                type: "POST",
                url: `/Onprocess/New_sterileList`,
                data: {
                    sterileItem: tb_list_sterile,
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function (response) {
                    Oder_item = response.items
                    Getsterile_List();
                    Get_Oder_item();
                    option_item_Packing(Oder_item);
                }
            });

        })


        $(document).on('click', '#btn_Sterile_image', function () {
            $('#textIdSterile').text($(this).attr('data-SterileId'))
            $('#id_Sterile_modal').val($(this).attr('data-SterileId'))
            $('#Modal_Img_Sterile').removeClass('invisible');

            GetSterile_Img_list($(this).attr('data-SterileId'))
        })


        $(document).on('click', '#modal_Sterile_close', function () {
            $('#Modal_Img_Sterile').addClass('invisible');
            // $('#Input_Image_Sterile').val()
            document.getElementById("Input_Image_Sterile").value = null;
            let output = document.getElementById('Sterile_img_preview');
            output.src = null;
            output.style.height = "0px";
            output.style.width = "auto";
        })


        $('#Input_Image_Sterile').on('change', function () {
            let files = document.getElementById("Input_Image_Sterile").files;

            reader = new FileReader();
            // console.log(files)
            reader.onload = function () {
                let output = document.getElementById('Sterile_img_preview');
                output.src = reader.result;
                output.style.height = "20rem";
                output.style.width = "auto";
            };
            reader.readAsDataURL(event.target.files[0]);
        })


        $('#add_img_sterile').on('click', function () {
            let files = document.getElementById("Input_Image_Sterile").files;
            let sterile_qc_id = $('#id_Sterile_modal').val()
            if (files[0] == undefined) return 0;

            var Formdata = new FormData();

            Formdata.append('sterile_qc_id', sterile_qc_id);
            Formdata.append('files', files[0]);

            $.ajax({
                type: "POST",
                url: `/Onprocess/New_ImageSterile`,
                cache: false,
                contentType: false,
                processData: false,
                data: Formdata,
                dataType: "json",
                success: function (response) {
                    document.getElementById("Input_Image_Sterile").value = null;
                    let output = document.getElementById('Sterile_img_preview');
                    output.src = null;
                    output.style.height = "0px";
                    output.style.width = "auto";

                    GetSterile_Img_list(sterile_qc_id)
                }
            });
        })


        function GetSterile_Img_list(sterile_qc_id) {
            $.ajax({
                type: "POST",
                url: `/Onprocess/GetSterile_Img_list`,
                data: {
                    sterile_qc_id: sterile_qc_id
                },
                success: function (response) {
                    // console.log(response)

                    html_list = '';
                    for (let item of response.sterile_img) {

                        html_list += `
                        <a class="block p-1 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                            <div class="relative" height="40px" width="auto">
                                <img class="w-full" style="height: 15rem; object-fit: contain;" src="{{ asset('assets/image/sterile/${item.image}') }}"
                                    alt="dummy-image">

                                <button id="btn_View_img_sterile" src-data="${item.image}"
                                class="absolute top-1 right-1 bg-green-500 text-white p-2 rounded hover:bg-green-800">
                                    view
                                </button>

                                <button id="btn_remove_img_sterlie" data-ID_img="${item.image_id}" data-SterileID="${item.sterile_qc_id}" data-image="${item.image}"
                                    class="absolute bottom-1 right-1 bg-red-500 text-white p-2 rounded hover:bg-red-800">
                                    remove
                                </button>
                            </div>
                        </a>
                        `
                        // <td class="py-4 px-6" value="${(item.Item_status == null ? '' : item.Item_status)}"> ${item.Item_status} </td>
                    }
                    $('#list_img_Sterile').html(html_list)
                }
            });

        }


        $(document).on('click', '#btn_remove_img_sterlie', function () {
            let image_id = $(this).attr('data-ID_img')
            let sterile_qc_id = $(this).attr('data-SterileID')
            let image = $(this).attr('data-image')

            $.ajax({
                type: "POST",
                url: `/Onprocess/Delete_Img_list_Sterile`,
                data: {
                    sterile_qc_id: sterile_qc_id,
                    image_id: image_id,
                    image: image
                },
                success: function (response) {
                    // console.log(response)
                    GetSterile_Img_list(sterile_qc_id)
                }
            });

        });


        $(document).on('click', '#btn_View_img_sterile', function () {
            let src_img = $(this).attr('src-data')
            $('#modal_show_image_sterile').removeClass('hidden')
            $('#modal_Fullimg_sterile').attr('src', `{{ asset('assets/image/sterile/${src_img}') }}`)
        })

        $(document).on('click', '#Close_show_image_sterile', function () {
            $('#modal_Fullimg_sterile').attr('src', '');
            $('#modal_show_image_sterile').addClass('hidden')
        })


    });

</script>

</html>
