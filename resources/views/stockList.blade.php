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

                    </div>
                </div>
            </main>
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
                        </tr>
                        `
                    };

                    $('#list_item_id').html(html_item_list)

                }
            });
        }

        Get_Oder_item()

    })
</script>
