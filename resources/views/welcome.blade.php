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

</head>

<body id="body_html">
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
            <main class="flex-1 overflow-x-hidden hidden">

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
                    </div>
                    {{-- Breadcrumb end --}}

                    <div class="grid grid-cols-1 gap-8 p-4 lg:grid-cols-2 xl:grid-cols-3">
                        <div class="flex flex-col items-center justify-between">
                            <div class="flex col_fles mb-3 bg-white rounded-md dark:bg-darker w-full h-full p-1">
                                <div class="m-auto text-center">
                                    <span class="text-2xl">เครื่องมือ/ปี</span>
                                    <hr>
                                    <div class="text-center text-6xl">
                                        <h1>5000</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="flex col_fles bg-white rounded-md dark:bg-darker w-full h-full p-1">
                                <div class="m-auto text-center">
                                    <span class="text-2xl">เครื่องมือ/เดือน</span>
                                    <hr>
                                    <div class="text-center text-6xl">
                                        <h1>250</h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">การทำ Sterile</span>
                            <div>
                                <canvas width="472" height="480" id="chart_display"></canvas>
                            </div>
                        </div>

                        <!-- Orders card -->
                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">การทำ Sterile</span>
                            <div>
                                {{-- <canvas width="472" height="236" id="donut_item_customer"></canvas> --}}
                                <canvas id="donut_item_customer" width="472" height="480"></canvas>
                            </div>
                        </div>
                    </div>



                    <div class="grid grid-cols-1 gap-8 p-4 lg:grid-cols-5 xl:grid-cols-5">
                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">การทำ Sterile</span>
                            <div>
                                {{-- <canvas width="472" height="236" id="donut_item_customer"></canvas> --}}
                                <canvas id="donut_item_customer" width="472" height="480"></canvas>
                            </div>
                        </div>

                        <div class="flex flex-col items-center justify-between">
                            <div class="flex col_fles mb-3 bg-white rounded-md dark:bg-darker w-full h-full p-1">
                                <div class="m-auto text-center">
                                    <span class="text-2xl">Customer</span>
                                    <hr>
                                    <div class="text-center text-6xl">
                                        <h1>5000</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="flex col_fles bg-white rounded-md dark:bg-darker w-full h-full p-1">
                                <div class="m-auto text-center">
                                    <span class="text-2xl">Department</span>
                                    <hr>
                                    <div class="text-center text-6xl">
                                        <h1>250</h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">การทำ Sterile</span>
                            <div>
                                <canvas width="472" height="480" id="chart_display"></canvas>
                            </div>
                        </div>

                    </div>



                    <div class="grid grid-cols-1 gap-8 p-4 lg:grid-cols-5 xl:grid-cols-5">
                        <!-- Value card -->
                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">การทำ Sterile</span>
                            <div>
                                <canvas width="auto" height="250" id="chart_display"></canvas>
                            </div>

                        </div>

                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">การทำ Sterile</span>
                            <div>
                                <canvas width="auto" height="300" id="chart_display"></canvas>
                            </div>

                        </div>

                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">การทำ Sterile</span>
                            <div>
                                <canvas width="auto" height="300" id="chart_display"></canvas>
                            </div>

                        </div>

                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">การทำ Sterile</span>
                            <div>
                                <canvas width="auto" height="300" id="chart_display"></canvas>
                            </div>

                        </div>

                        <div class="items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <span class="text-sm">การทำ Sterile</span>
                            <div>
                                <canvas width="auto" height="300" id="chart_display"></canvas>
                            </div>

                        </div>

                    </div>



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

        Get_Data();

        function Get_Data() {

            $.ajax({
                type: "POST",
                url: `/dashboard/Get_Data`,
                dataType: "json",
                success: function (response) {

                }
            });
        }

        Chart_item_sterile();

        function Chart_item_sterile() {

            let a = [62, 68, 74, 80, 66, 84]

            const data = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [{
                        label: 'a',
                        data: a,
                        backgroundColor: 'rgb(0, 178, 169)',
                        order: 3,
                        stack: 'stack1'
                    },
                    {
                        label: 'Expired',
                        data: [50, 3, 7, 9, 2, 4],
                        backgroundColor: 'rgb(207, 16, 45)',
                        order: 3,
                        stack: 'stack1'
                    }
                ]
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
                    }
                },
            };

            const reportOutput = new Chart(
                document.getElementById('chart_display'),
                config
            );
        }

        donut_item_customer();

        function donut_item_customer() {
            // const reportOutput = new Chart(
            //     document.getElementById('donut_item_customer'),
            //     config
            // );

            var ctx = document.getElementById("donut_item_customer");
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [10, 20, 15, 5, 50],
                        backgroundColor: ['rgb(255, 99, 132)', 'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)', 'rgb(75, 192, 192)', 'rgb(54, 162, 235)',
                        ],
                    }, ],
                    labels: ['Red', 'Orange', 'Yellow', 'Green', 'Blue'],
                },
                options: {
                    plugins: {
                        datalabels: {
                            formatter: (value) => {
                                return value + '%';
                            }
                        }
                    }
                }
            });
        }



    })

</script>

</html>
