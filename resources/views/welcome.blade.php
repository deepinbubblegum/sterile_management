<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    @include('component.Tagheader')


    {{-- <script src="{{ asset('assets/js_chart/jquery.jqplot.min.js') }}"></script> --}}
    {{-- <link href="{{ asset('assets/js_chart/jquery.jqplot.min.css') }}" rel="stylesheet" /> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}

    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" />

    <style>
        .ui-datepicker-calendar {
            display: none !important;
        }

    </style>

</head>

<body id="body_html">

    @php
    use App\Http\Controllers\UsersPermission_Controller;
    $users_permit = new UsersPermission_Controller();
    $permissions = $users_permit->UserPermit();
    @endphp

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
                                        Process
                                    </a>
                                </li>
                            </ol>
                        </nav>
                        <div class="grid grid-cols-1 gap-8 p-4 lg:grid-cols-2 xl:grid-cols-6 mt-5">
                            <div>
                                <label for="option_machine_sterile_search"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                                    Select Month
                                </label>
                                <select id="option_month"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    {{-- Breadcrumb end --}}

                    <div class="mx-auto text-center">
                        <span class="text-2xl">Dashboard</span>
                        <hr>
                        <div class="text-center mt-1 text-2xl">
                            <h1 id="Dashboard_month"></h1>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-8 p-4 lg:grid-cols-2 xl:grid-cols-3">
                        <div class="flex flex-col items-center justify-between">
                            <div class="flex col_fles mb-3 bg-white rounded-md dark:bg-darker w-full h-full p-1">
                                <div class="m-auto text-center">
                                    <span class="text-2xl">Equipments/Year</span>
                                    <hr>
                                    <div class="text-center text-6xl">
                                        <h1 id="item_per_year"></h1>
                                    </div>
                                </div>
                            </div>

                            <div class="flex col_fles bg-white rounded-md dark:bg-darker w-full h-full p-1">
                                <div class="m-auto text-center">
                                    <span class="text-2xl">Equipments/Month</span>
                                    <hr>
                                    <div class="text-center text-6xl">
                                        <h1 id="item_per_month"></h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker div_chart_Sterile">
                            <span class="text-sm">Situation Sterile</span>
                            <div>
                                <canvas width="auto" height="200" id="chart_Sterile"></canvas>
                            </div>
                        </div>

                        <!-- Orders card -->
                        <div
                            class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker div_donut_item_backlog">
                            <span class="text-sm">Complete / Incomplete</span>
                            <div>
                                {{-- <canvas width="472" height="236" id="donut_item_customer"></canvas> --}}
                                <canvas id="donut_item_backlog" width="auto" height="200"></canvas>
                            </div>
                        </div>
                    </div>


                    @if ($permissions->{'Dashboard Admin'} == 1)
                    <div class="grid grid-cols-1 gap-8 p-4 lg:grid-cols-3 xl:grid-cols-3">
                        <div
                            class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker div_donut_item_SUD">
                            <span class="text-sm">Single Use of device</span>
                            <div>
                                {{-- <canvas width="472" height="236" id="donut_item_customer"></canvas> --}}
                                <canvas id="donut_item_SUD" width="auto" height="200"></canvas>
                            </div>
                        </div>

                        <div class="flex flex-col items-center justify-between">
                            <div class="flex col_fles mb-3 bg-white rounded-md dark:bg-darker w-full h-full p-1">
                                <div class="m-auto text-center">
                                    <span class="text-2xl">Customer</span>
                                    <hr>
                                    <div class="text-center text-6xl">
                                        <h1 id="txt_Customer"></h1>
                                    </div>
                                </div>
                            </div>

                            <div class="flex col_fles bg-white rounded-md dark:bg-darker w-full h-full p-1">
                                <div class="m-auto text-center">
                                    <span class="text-2xl">Department</span>
                                    <hr>
                                    <div class="text-center text-6xl">
                                        <h1 id="txt_Department"></h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">Single Use of device / Month</span>
                            <div class="div_donut_item_SUD_month">
                                <canvas width="auto" height="200" id="donut_item_SUD_month"></canvas>
                            </div>
                        </div>

                    </div>



                    <div class="grid grid-cols-1 gap-8 p-4 lg:grid-cols-1 xl:grid-cols-3">
                        <!-- Value card -->
                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">KPI Set Accuracy Target</span>
                            <div class="dev_chart_kpi_Accuracy_Target">
                                <canvas width="auto" height="250" id="chart_kpi_Accuracy_Target"></canvas>
                            </div>

                        </div>

                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">KPI Perfect Sterile Target</span>
                            <div class="div_chart_kpi_Sterile_Target">
                                <canvas width="auto" height="300" id="chart_kpi_Sterile_Target"></canvas>
                            </div>

                        </div>

                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">KPI Instrument Loss Target</span>
                            <div class="div_chart_kpi_Loss_Target">
                                <canvas width="auto" height="300" id="chart_kpi_Loss_Target"></canvas>
                            </div>

                        </div>

                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">KPI Instrument Damage Target</span>
                            <div class="div_chart_kpi_Damage_Target">
                                <canvas width="auto" height="300" id="chart_kpi_Damage_Target"></canvas>
                            </div>

                        </div>

                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">KPI Ontime Delivery Target</span>
                            <div class="div_chart_kpi_Delivery_Target">
                                <canvas width="auto" height="300" id="chart_kpi_Delivery_Target"></canvas>
                            </div>

                        </div>

                    </div>
                    @endif



                    </section>


                </div>
        </div>
        </main>
    </div>
    </div>

    <!-- All javascript code in this project for now is just for demo DON'T RELY ON IT  -->

</body>


<script>
    $(document).ready(function () {

        var date = new Date(),

            now_month = date.getMonth(),

            now_year = date.getFullYear();

        var months_th = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม",
            "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม",
        ];
        var months_th_mini = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.",
            "พ.ย.", "ธ.ค.",
        ];

        var month_EN_Names = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        $('#option_month').val(now_month + 1).change()

        Get_Data();

        $('#option_month').on("change", function () {
            let month = $(this).val()
            Get_Data(parseInt(month));
        })

        var refreshId = setInterval(function () {
            let month = $('#option_month').val()
            Get_Data(parseInt(month));
        }, 1200000);


        function Get_Data(month = now_month + 1) {
            $('#Dashboard_month').text((month_EN_Names[month - 1]))

            $.ajax({
                type: "POST",
                url: `/dashboard/Get_Data`,
                data: {
                    month: month
                },
                dataType: "json",
                success: function (response) {
                    console.log(response)
                    // item_per_month item_per_year txt_Customer txt_Department
                    $('#item_per_month').text(response.item_month)
                    $('#item_per_year').text(response.item_year)

                    $('#txt_Customer').text(response.customers)
                    $('#txt_Department').text(response.departments)

                    Chart_item_sterile(response.type_sterile);
                    donut_item_backlog(response.backlog_item);
                    donut_item_SUD(response.SUD);
                    donut_item_SUD_month(response.SUD_Month);
                    chart_kpi_Accuracy_Target(response.month_Claim, response.month_list_item);
                    chart_kpi_Sterile_Target(response.Sterile_Fail);
                    chart_kpi_Loss_Target(response.month_loss, response.month_list_item);
                    chart_kpi_Damage_Target(response.month_Damage, response.month_list_item);
                    chart_kpi_Delivery_Target(response.deliver_late)
                }
            });
        }


        function Chart_item_sterile(list_data) {

            $('#chart_Sterile').remove(); // this is my <canvas> element
            $('.div_chart_Sterile').append('<canvas width="auto" height="200" id="chart_Sterile"></canvas>');

            let list_datasets = Object.values(list_data)
            let list_labels = Object.keys(list_data)

            const data = {
                labels: list_labels,
                datasets: [{
                    label: 'QTY',
                    data: list_datasets,
                    backgroundColor: ['rgb(255, 99, 132)', 'rgb(220,20,60)', 'rgb(255, 159, 64)',
                        'rgb(154,205,50)', 'rgb(50,205,50)', 'rgb(100,149,237)'
                    ],
                    order: 3,
                    stack: 'stack1'
                }]
            }

            const config = {
                type: 'bar',
                data: data,
                options: {
                    plugins: {
                        tooltip: {
                            mode: 'index'
                        }
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    },
                    aspectRatio: 2
                },
            };

            const reportOutput = new Chart(
                document.getElementById('chart_Sterile'),
                config
            );

        }

        function donut_item_backlog(list_data) {

            $('#donut_item_backlog').remove(); // this is my <canvas> element
            $('.div_donut_item_backlog').append(
                '<canvas id="donut_item_backlog" width="auto" height="200"> </canvas> ');


            // let list_datasets = Object.values(list_data)
            // let list_labels = Object.keys(list_data)
            let list_datasets = [];
            list_datasets.push(list_data['all'] - list_data['backlog'], list_data['backlog']);
            let list_labels = ['Complete', 'Incomplete']

            var ctx = document.getElementById("donut_item_backlog");
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: list_datasets,
                        backgroundColor: ['rgb(255, 99, 132)', 'rgb(255, 159, 64)'],
                    }, ],
                    labels: list_labels,
                },
                options: {
                    plugins: {
                        datalabels: {
                            formatter: (value) => {
                                return value + '%';
                            }
                        }
                    },
                    aspectRatio: 2
                }
            });
        }


        function donut_item_SUD(list_data) {
            let list_datasets = Object.values(list_data)
            // let list_labels = Object.keys(list_data)
            let list_labels = ['Other', 'SUD']


            $('#donut_item_SUD').remove(); // this is my <canvas> element
            $('.div_donut_item_SUD').append('<canvas id="donut_item_SUD" width="auto" height="200"></canvas>');

            var ctx = document.getElementById("donut_item_SUD");
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: list_datasets,
                        backgroundColor: ['rgb(106, 194, 0)', 'rgb(106, 194, 217)'],
                    }, ],
                    labels: list_labels,
                },
                options: {
                    plugins: {
                        datalabels: {
                            formatter: (value) => {
                                return value + '%';
                            }
                        }
                    },
                    aspectRatio: 2
                }
            });
        }

        function donut_item_SUD_month(list_data) {
            let list_datasets = Object.values(list_data)
            // let list_labels = Object.keys(list_data)
            let list_labels = ['Other', 'SUD']


            $('#donut_item_SUD_month').remove(); // this is my <canvas> element
            $('.div_donut_item_SUD_month').append(
                '<canvas id="donut_item_SUD_month" width="auto" height="200"></canvas>');

            var ctx = document.getElementById("donut_item_SUD_month");
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: list_datasets,
                        backgroundColor: ['rgb(106, 194, 0)', 'rgb(106, 194, 217)'],
                    }, ],
                    labels: list_labels,
                },
                options: {
                    plugins: {
                        datalabels: {
                            formatter: (value) => {
                                return value + '%';
                            }
                        }
                    },
                    aspectRatio: 2
                }
            });
        }


        function chart_kpi_Accuracy_Target(list_data, month_list_item) {

            $('#chart_kpi_Accuracy_Target').remove(); // this is my <canvas> element
            $('.dev_chart_kpi_Accuracy_Target').append(
                '<canvas width="auto" height="250" id="chart_kpi_Accuracy_Target"></canvas>');

            let monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            let list_datasets = []
            for (const [key, value] of Object.entries(list_data)) {
                // console.log(key, value);
                // console.log(month_list_item[key]);
                let cal = parseInt(((month_list_item[key] - value) * 100) / month_list_item[key]) || 0
                list_datasets.push(cal)
            }

            const data = {
                labels: monthNames,
                datasets: [{
                    label: 'percentage',
                    data: list_datasets,
                    backgroundColor: 'rgb(0, 178, 169)',
                    // order: 3,
                    // stack: 'stack1'
                }]
            }

            const config = {
                type: 'bar',
                data: data,
                options: {
                    plugins: {
                        tooltip: {
                            mode: 'index'
                        }
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    },
                    aspectRatio: 1.5
                },
            };

            const reportOutput = new Chart(
                document.getElementById('chart_kpi_Accuracy_Target'),
                config
            );
        }


        function chart_kpi_Sterile_Target(list_data) {

            $('#chart_kpi_Sterile_Target').remove(); // this is my <canvas> element
            $('.div_chart_kpi_Sterile_Target').append(
                '<canvas width="auto" height="300" id="chart_kpi_Sterile_Target"></canvas>');

            let monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];


            let list_datasets = []
            for (const [key, value] of Object.entries(list_data.fail)) {
                // console.log(key, value);
                // console.log(list_data.fail[key]);

                let cal = parseInt(((list_data.all[key] - value) * 100) / list_data.all[key]) || 0
                list_datasets.push(cal)
            }

            const data = {
                labels: monthNames,
                datasets: [{
                    label: 'percentage',
                    data: list_datasets,
                    backgroundColor: 'rgb(0, 178, 169)',
                    order: 3,
                    stack: 'stack1'
                }]
            }

            const config = {
                type: 'bar',
                data: data,
                options: {
                    plugins: {
                        tooltip: {
                            mode: 'index'
                        }
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    },
                    aspectRatio: 1.5
                },
            };

            const reportOutput = new Chart(
                document.getElementById('chart_kpi_Sterile_Target'),
                config
            );
        }


        function chart_kpi_Loss_Target(list_data, month_list_item) {

            $('#chart_kpi_Loss_Target').remove(); // this is my <canvas> element
            $('.div_chart_kpi_Loss_Target').append(
                '<canvas width="auto" height="300" id="chart_kpi_Loss_Target"></canvas>');

            let monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            let list_datasets = []
            for (const [key, value] of Object.entries(list_data)) {
                // console.log(key, value);
                // console.log(month_list_item[key]);
                let cal = parseInt(((month_list_item[key] - value) * 100) / month_list_item[key]) || 0
                list_datasets.push(cal)
            }

            const data = {
                labels: monthNames,
                datasets: [{
                    label: 'percentage',
                    data: list_datasets,
                    backgroundColor: 'rgb(0, 178, 169)',
                    // order: 3,
                    // stack: 'stack1'
                }]
            }

            const config = {
                type: 'bar',
                data: data,
                options: {
                    plugins: {
                        tooltip: {
                            mode: 'index'
                        }
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    },
                    aspectRatio: 1.5
                },
            };

            const reportOutput = new Chart(
                document.getElementById('chart_kpi_Loss_Target'),
                config
            );
        }


        function chart_kpi_Damage_Target(list_data, month_list_item) {

            $('#chart_kpi_Damage_Target').remove(); // this is my <canvas> element
            $('.div_chart_kpi_Damage_Target').append(
                '<canvas width="auto" height="300" id="chart_kpi_Damage_Target"></canvas>');

            let monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            let list_datasets = []
            for (const [key, value] of Object.entries(list_data)) {
                // console.log(key, value);
                // console.log(month_list_item[key]);
                let cal = parseInt(((month_list_item[key] - value) * 100) / month_list_item[key]) || 0
                list_datasets.push(cal)
            }

            const data = {
                labels: monthNames,
                datasets: [{
                    label: 'percentage',
                    data: list_datasets,
                    backgroundColor: 'rgb(0, 178, 169)',
                    // order: 3,
                    // stack: 'stack1'
                }]
            }

            const config = {
                type: 'bar',
                data: data,
                options: {
                    plugins: {
                        tooltip: {
                            mode: 'index'
                        }
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    },
                    aspectRatio: 1.5
                },
            };

            const reportOutput = new Chart(
                document.getElementById('chart_kpi_Damage_Target'),
                config
            );
        }


        function chart_kpi_Delivery_Target(list_data) {

            $('#chart_kpi_Delivery_Target').remove(); // this is my <canvas> element
            $('.div_chart_kpi_Delivery_Target').append(
                '<canvas width="auto" height="300" id="chart_kpi_Delivery_Target"></canvas>');

            let monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];


            let list_datasets = []
            for (const [key, value] of Object.entries(list_data.late)) {
                // console.log(key, value);
                // console.log(list_data.fail[key]);

                let cal = parseInt(((list_data.all[key] - value) * 100) / list_data.all[key]) || 0
                list_datasets.push(cal)
            }

            const data = {
                labels: monthNames,
                datasets: [{
                    label: 'percentage',
                    data: list_datasets,
                    backgroundColor: 'rgb(0, 178, 169)',
                    order: 3,
                    stack: 'stack1'
                }]
            }

            const config = {
                type: 'bar',
                data: data,
                options: {
                    plugins: {
                        tooltip: {
                            mode: 'index'
                        }
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    },
                    aspectRatio: 1.5
                },
            };

            const reportOutput = new Chart(
                document.getElementById('chart_kpi_Delivery_Target'),
                config
            );
        }

    })

</script>

</html>
