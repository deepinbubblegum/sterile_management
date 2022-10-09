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
                                            Item_id
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Item_name
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Quantity
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Item_status
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Item_Type
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Process
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Price
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Instrument_type
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

                        <hr>

                        {{-- State washing --}}
                        @include('on_process.Washing')

                        <hr>

                        {{-- State Packing --}}
                        @include('on_process.Packing')

                        <hr>

                        {{-- State Sterlie --}}
                        @include('on_process.Sterlie')

                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- All javascript code in this project for now is just for demo DON'T RELY ON IT  -->

</body>


<script>
    $(document).ready(function() {

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
                success: function(response) {
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

        $('#all_check').change(function() {
            if ($(this).prop('checked')) {
                $('tbody tr td input[type="checkbox"]').each(function() {
                    $(this).prop('checked', true);
                    $(this).val('checked')
                });
            } else {
                $('tbody tr td input[type="checkbox"]').each(function() {
                    $(this).prop('checked', false);
                    $(this).val('')
                });
            }
        });


        $('#Get_table').on('click', function() {
            var tbl = $('#tb_select tr:has(td)').map(function(index, cell) {
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
        // obj_table_washing()


        function obj_table_washing() {
            var arrData = [];
            // loop over each table row (tr)
            $("#tb_list_washing tr").each(function() {
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


        function Get_Washing_machine() {
            $.ajax({
                type: "POST",
                url: `/Onprocess/GetWashing_machine`,
                data: {
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function(response) {

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
                success: function(response) {
                    // console.log(response.washing_List)

                    html_list = '';
                    for (let item of response.washing_List) {

                        html_list += `
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="py-4 px-6"> <input id="WS_Check" type="checkbox" ${(item.PassStatus == 'false' ? '' : 'Checked')}
                                        class="${(item.PassStatus == 'false' ? 'check_OnProcess_Washing' : '')} w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light"  ${(item.PassStatus == 'true' ? 'disabled' : '' )}>
                                </td>
                                <td class="py-4 px-6" value="${item.washing_id}"> ${item.washing_id} </td>
                                <td class="py-4 px-6" value="${item.item_id}"> ${item.Name} </td>
                                <td class="py-4 px-6" value="${item.MachinesWashing_id}"> ${item.MachinesWashingName} </td>
                                <td class="py-4 px-6" value="${item.Cycle}"> ${item.Cycle} </td>
                                <td class="py-4 px-6" value="${(item.QTY == null ? '' : item.QTY)}"> ${item.QTY} </td>
                                <td class="py-4 px-6" value="${item.PassStatus}"> ${item.PassStatus} </td>
                                <td class="py-4 px-6" value=""> ${item.Create_at} </td>
                            </tr>
                        `
                    }
                    $('#tb_list_washing').html(html_list)
                }
            });
        }


        function option_item_washing(Oder_item) {

            html_item_list = ''

            // response.machineswashing
            for (let item of Oder_item) {
                if (item.Item_status == '' || item.Item_status == null) {
                    html_item_list += `<option value='${item.Item_id}'>${item.Item_id} - ${item.Name} </option>`
                }
            }

            $('#option_item_washing').html(html_item_list)
        }


        function item_washing_checkDup(Item_id) {
            let res = true;
            $("#tb_list_washing tr").each(function() {
                var currentRow = $(this);
                var item_list_id = currentRow.find("td:eq(2)").attr('value');
                // console.log(item_list_id)
                if (Item_id == item_list_id) {
                    res = false;
                }
            });
            return res;
        }


        $('#item_add_washing').on('click', function() {


            let machines_id = $('#option_machineswashing').find(":selected").val();
            let machines_name = $('#option_machineswashing').find(":selected").text();
            let item_washing = $('#option_item_washing').find(":selected").val();

            $(`#option_item_washing option[value='${item_washing}']`).remove();

            if (item_washing == null) {
                alert('ไม่มี item')
                return false;
            }

            let _Item = Oder_item.filter(v => v.Item_id == item_washing);

            resultChk = item_washing_checkDup(_Item[0].Item_id)
            if (resultChk == false) return resultChk;
            console.log(resultChk)

            // alert(machines);
            row = $(`<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"> </tr>`);
            col1 = $(
                `<td class="py-4 px-6"> <input id="WS_Check" type="checkbox" class="check_OnProcess_Washing w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" /> </td>`
            );
            col2 = $(
                `<td class="py-4 px-6" value="${_Item[0].washing_id == null ? '-' : _Item[0].washing_id}" > ${_Item[0].washing_id == null ? '-' : _Item[0].washing_id} </td>`
            );
            col3 = $(`<td class="py-4 px-6" value="${_Item[0].Item_id}" >${_Item[0].Name}</td>`);
            col4 = $(`<td class="py-4 px-6" value="${machines_id}" >${machines_name}</td>`);
            col5 = $(`<td class="py-4 px-6" value=""> - </td>`);
            col6 = $(`<td class="py-4 px-6" value="${_Item[0].Quantity}" >${_Item[0].Quantity}</td>`);
            col7 = $(
                `<td class="py-4 px-6" value="${_Item[0].Item_status}" >${_Item[0].Item_status}</td>`
            );
            col8 = $(`<td class="py-4 px-6" value="${DateNowDay()}" >${DateNowDay()}</td>`);
            row.append(col1, col2, col3, col4, col5, col6, col7, col8).prependTo("#tb_list_washing");

        })


        $('#washing_all_check').change(function() {
            if ($(this).prop('checked')) {
                $(`tbody tr td input[type="checkbox"][class*="check_OnProcess_Washing"]`).each(
                    function() {
                        $(this).prop('checked', true);
                        $(this).val('checked')
                    });
            } else {
                $(`tbody tr td input[type="checkbox"][class*="check_OnProcess_Washing"]`).each(
                    function() {
                        $(this).prop('checked', false);
                        $(this).val('')
                    });
            }
        });


        $('#btn_save_washing').on('click', function() {
            var tb_list_washing = $('#tb_list_washing tr:has(td)').map(function(index, cell) {
                var $td = $('td', this);
                return {
                    check: $('td input#WS_Check', this).prop('checked'),
                    washing_id: $td.eq(1).attr('value'),
                    item_id: $td.eq(2).attr('value'),
                    Machines_id: $td.eq(3).attr('value'),
                    Cycle: $td.eq(4).attr('value'),
                    QTY: $td.eq(5).attr('value'),
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
                success: function(response) {
                    Oder_item = response.items
                    table_listItem()
                    option_item_washing(response.items);
                    GetWashing_List();

                    Get_Oder_item();

                }
            });

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
                success: function(response) {
                    console.log(response.Packing_List)

                    html_list = '';
                    for (let item of response.Packing_List) {

                        html_list += `
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="py-4 px-6"> <input id="PK_Check" type="checkbox" ${(item.Item_status == 'Packing' ? '' : 'Checked')}
                                        class="${(item.Item_status == 'Packing' ? 'check_OnProcess_Packing' : '')} w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light"  ${(item.Item_status == 'Packing Finish' ? 'disabled' : '' )}>
                                </td>
                                <td class="py-4 px-6" value="">  </td>
                                <td class="py-4 px-6" value="${item.packing_id}"> ${item.packing_id} </td>
                                <td class="py-4 px-6" value="${item.item_id}"> ${item.item_id} </td>
                                <td class="py-4 px-6" value="${item.item_id}"> ${item.Name} </td>
                                <td class="py-4 px-6" value="${item.Machine_id}"> ${item.Machine_name} </td>
                                <td class="py-4 px-6" value="${item.Program_id}"> ${item.Program_name} </td>
                                <td class="py-4 px-6" value="${item.Cycle}"> ${item.Cycle} </td>
                                <td class="py-4 px-6" value="${(item.Item_status == null ? '' : item.Item_status)}"> ${item.Item_status} </td>
                                <td class="py-4 px-6" value="${item.Qc_by}"> ${item.UserName_QC} </td>
                                <td class="py-4 px-6" value="${(item.Quantity == null ? '' : item.Quantity)}"> ${item.Quantity} </td>
                                <td class="py-4 px-6" value="${item.Exp_date}"> ${item.Exp_date} </td>
                                <td class="py-4 px-6" value=""> ${item.Create_at} </td>
                            </tr>
                        `
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
                success: function(response) {
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


        var program_sterlie;


        function option_item_Packing(Oder_item) {
            console.log(Oder_item)
            html_item_list = ''

            // response.machineswashing
            for (let item of Oder_item) {
                if (item.Item_status == 'Washing Finish') {
                    html_item_list +=
                        `<option value='${item.Item_id}' data-process="${item.Process}">${item.Item_id} - ${item.Name} </option>`
                }
            }

            $('#item_packing').html(html_item_list)
            Get_Sterlie_machine()
        }


        $('#item_packing').on('change', function() {
            Get_Sterlie_machine()
        })


        function Get_Sterlie_machine() {

            // alert($('#item_packing').find(":selected").val());

            $.ajax({
                type: "POST",
                url: `/Onprocess/GetSterlie_machine`,
                data: {
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function(response) {

                    let item_process = $('#item_packing').find(":selected").data("process")
                    // alert($('#item_packing').find(":selected").data("process"))
                    html_list_machine_sterlie = ''

                    for (let item of response.items_machine) {
                        if (item.Machine_type == item_process) {
                            html_list_machine_sterlie +=
                                `<option value='${item.Machine_id}' data-process='${item.Machine_type}' >${item.Machine_name}</option>`
                        }
                    }

                    $('#option_machine_sterlie').html(html_list_machine_sterlie)
                    $('#name_process_machine_sterlie').val($('#option_machine_sterlie').find(
                        ":selected").data("process"))


                    // console.log(response.items_process)
                    html_list_process_sterlie = ''
                    for (let item_pc of response.items_process) {
                        if (item_pc.Machine_type == item_process) {
                            html_list_process_sterlie +=
                                `<option value='${item_pc.Machine_type}' >${item_pc.Machine_type}</option>`
                        }
                    }
                    $('#option_Process_sterlie').html(html_list_process_sterlie)
                    $('#option_Process_sterlie').val($('#option_machine_sterlie').find(":selected")
                        .data("process"))



                    program_sterlie = response.items_program
                    html_list_program_sterlie = ''
                    for (let item_p of response.items_program) {
                        if (item_p.Machine_id == $('#option_machine_sterlie').find(":selected")
                            .val()) {
                            html_list_program_sterlie +=
                                `<option value='${item_p.Program_id}' >${item_p.Program_name}</option>`
                        }
                    }
                    $('#option_program_sterlie').html(html_list_program_sterlie)

                }
            });
        }


        // Change Machine
        $('#option_machine_sterlie').on('change', function() {
            $('#option_Process_sterlie').val($(this).find(":selected").data("process"))
            // console.log(program_sterlie)

            html_list_program_sterlie = ''
            for (let item_p of program_sterlie) {
                if (item_p.Machine_id == $('#option_machine_sterlie').find(":selected").val()) {
                    html_list_program_sterlie +=
                        `<option value='${item_p.Program_id}' >${item_p.Program_name}</option>`
                }
            }
            $('#option_program_sterlie').html(html_list_program_sterlie)
        })


        // Change Process
        $('#option_Process_sterlie').on('change', function() {
            // $('#option_machine_sterlie').val()
            $(`#option_machine_sterlie option[data-process='${($(this).val())}']`).prop("selected",
                true);
        })


        function item_packing_checkDup(Item_id) {
            let res = true;
            $("#tb_list_packing tr").each(function() {
                var currentRow = $(this);
                var item_list_id = currentRow.find("td:eq(3)").attr('value');
                // console.log(item_list_id)
                if (Item_id == item_list_id) {
                    res = false;
                }
            });
            return res;
        }

        $('#all_check_Packing').change(function() {
            if ($(this).prop('checked')) {
                $(`tbody tr td input[type="checkbox"][class*="check_OnProcess_Packing"]`).each(
                    function() {
                        $(this).prop('checked', true);
                        $(this).val('checked')
                    });
            } else {
                $(`tbody tr td input[type="checkbox"][class*="check_OnProcess_Packing"]`).each(
                    function() {
                        $(this).prop('checked', false);
                        $(this).val('')
                    });
            }
        });


        $('#item_add_packing').on('click', function() {

            let machines_id = $('#option_machine_sterlie').find(":selected").val();
            let machines_name = $('#option_machine_sterlie').find(":selected").text();

            let program_id = $('#option_program_sterlie').find(":selected").val();
            let program_name = $('#option_program_sterlie').find(":selected").text();

            let item_packing = $('#item_packing').find(":selected").val();

            $(`#item_packing option[value='${item_packing}']`).remove();

            let userQC_id = $('#option_userQC').find(":selected").val();
            let userQC_name = $('#option_userQC').find(":selected").text();

            if (item_packing == null) {
                alert('ไม่มี item')
                return false;
            }

            let _Item = Oder_item.filter(v => v.Item_id == item_packing);
            resultChk = item_packing_checkDup(_Item[0].Item_id)
            if (resultChk == false) return resultChk;

            // alert(machines);
            row = $(`<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"> </tr>`);
            col1 = $(`<td scope="col" class="py-3 px-6">
                        <input type="checkbox" id="PK_Check"
                            class="check_OnProcess_Packing w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" />
                    </td>`);
            col2 = $(
                `<td
                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <button target="_blank"
                        class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                        <i
                            class="fa-solid fa-print fa-lg fill-white icon_center"></i>
                    </button>

                    <button
                        class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-success inline-flex items-center hover:bg-success-dark focus:outline-none focus:ring focus:ring-success focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                        <i
                            class="fa-solid fa-camera fa-lg fill-white icon_center"></i>
                    </button>

                    <button
                        class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                        <i
                            class="fa-regular fa-file-image fa-lg  fill-white icon_center"></i>
                    </button>
                </td>`
            );
            col3 = $(
                `<td class="py-4 px-6" value="${_Item[0].packing_id == null ? '-' : _Item[0].packing_id}" > ${_Item[0].packing_id == null ? '-' : _Item[0].packing_id} </td>`
            );
            col4 = $(`<td class="py-4 px-6" value="${_Item[0].Item_id}"> ${_Item[0].Item_id} </td>`);
            col5 = $(`<td class="py-4 px-6" value="${_Item[0].Item_id}"> ${_Item[0].Name} </td>`);
            col6 = $(`<td class="py-4 px-6" value="${machines_id}"> ${machines_name} </td>`);
            col7 = $(`<td class="py-4 px-6" value="${program_id}"> ${program_name} </td>`);
            col8 = $(`<td class="py-4 px-6" value=""></td>`);
            col9 = $(`<td class="py-4 px-6" value=""> - </td>`);
            col10 = $(`<td class="py-4 px-6" value="${userQC_id}"> ${userQC_name} </td>`);
            col11 = $(`<td class="py-4 px-6" value="${_Item[0].Quantity}"> ${_Item[0].Quantity} </td>`);
            col12 = $(`<td class="py-4 px-6" value="" data-addExp="${_Item[0].Expire}"> ${_Item[0].Expire} </td>`);
            col13 = $(`<td class="py-4 px-6" value="${DateNowDay()}" >${DateNowDay()}</td>`);
            row.append(col1, col2, col3, col4, col5, col6, col7, col8, col9, col10, col11, col12, col13)
                .prependTo("#tb_list_packing");

        })


        $('#btn_save_packing').on('click', function() {
            var tb_list_packing = $('#tb_list_packing tr:has(td)').map(function(index, cell) {
                var $td = $('td', this);
                return {
                    check: $('td input#PK_Check', this).prop('checked'),
                    packing_id: $td.eq(2).attr('value'),
                    item_id: $td.eq(3).attr('value'),
                    Machines_id: $td.eq(5).attr('value'),
                    program_id: $td.eq(6).attr('value'),
                    Cycle: $td.eq(7).attr('value'),
                    user_QC: $td.eq(9).attr('value'),
                    QTY: $td.eq(10).attr('value'),
                    Exp: $td.eq(11).attr('value'),
                    AddExp: $td.eq(11).attr("data-addExp"),
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
                success: function(response) {
                    Oder_item = response.items
                    GetPacking_List()
                    Get_Oder_item();

                }
            });

        })


    });
</script>

</html>
