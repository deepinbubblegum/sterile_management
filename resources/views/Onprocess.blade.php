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
                    table_listItem()
                    option_item_washing(Oder_item);
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
                    console.log(response)
                }
            });
        }


        function option_item_washing(Oder_item) {

            html_item_list = ''

            // response.machineswashing
            for (let item of Oder_item) {
                if (item.Item_status == '' || item.Item_status == null || item.Item_status == 'W') {
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


            let _Item = Oder_item.filter(v => v.Item_id == item_washing);

            resultChk = item_washing_checkDup(_Item[0].Item_id)
            if (resultChk == false) return resultChk;
            console.log(resultChk)

            // alert(machines);
            row = $(`<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"> </tr>`);
            col1 = $(
                `<td class="py-4 px-6"> <input id="WS_Check" type="checkbox" class="w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" /> </td>`
            );
            col2 = $(`<td class="py-4 px-6" value="${_Item[0].washing_id}" > ${_Item[0].washing_id == null ? '-' : _Item[0].washing_id} </td>`);
            col3 = $(`<td class="py-4 px-6" value="${_Item[0].Item_id}" >${_Item[0].Name}</td>`);
            col4 = $(`<td class="py-4 px-6" value="${machines_id}" >${machines_name}</td>`);
            col5 = $(`<td class="py-4 px-6"> - </td>`);
            col6 = $(`<td class="py-4 px-6" value="${_Item[0].Quantity}" >${_Item[0].Quantity}</td>`);
            col7 = $(
                `<td class="py-4 px-6" value="${_Item[0].Item_status}" >${_Item[0].Item_status}</td>`
            );
            col8 = $(`<td class="py-4 px-6" value="${DateNowDay()}" >${DateNowDay()}</td>`);
            row.append(col1, col2, col3, col4, col5, col6, col7, col8).prependTo("#tb_list_washing");

        })


        $('#washing_all_check').change(function() {
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


        $('#btn_save_washing').on('click', function() {
            var tb_list_washing = $('#tb_list_washing tr:has(td)').map(function(index, cell) {
                var $td = $('td', this);
                return {
                    check: $('td input#WS_Check', this).prop('checked'),
                    washing_id: $td.eq(1).attr('value'),
                    item_id: $td.eq(2).attr('value'),
                    Machines_id: $td.eq(3).attr('value'),
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

            if(tb_list_washing.length == 0) return false

            $.ajax({
                type: "POST",
                url: `/Onprocess/New_WashingList`,
                data: {
                    WashingItem : tb_list_washing,
                    OrderId: '{{ $oder_id }}'
                },
                dataType: "json",
                success: function(response) {
                    Oder_item = response.items
                    table_listItem()
                    option_item_washing(Oder_item);
                }
            });

        })

    });
</script>

</html>
