<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sterile traceability</title>
    @include('component.Tagheader')
    <script src="{{asset('assets/js/orderPage.js')}}"></script>
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

                {{-- Breadcrumb --}}
                <div class="h-full min-w-screen p-4 overflow-x-hidden overflow-y-auto">

                    <div class="mx-auto rounded-md w-full bg-white dark:bg-darker dark:text-light p-4 mb-4 leading-6 ">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a
                                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg>
                                        Orders
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    {{-- Breadcrumb end --}}

                    <div
                        class="mx-auto h-auto w-full rounded-md bg-white dark:bg-darker dark:text-light shadow-sm p-4 leading-6">
                        <div class="flex justify-end">
                            <a href="{{url('/orders/create')}}"
                                class="px-4 mr-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-solid fa-file-pen mr-2 -ml-1 w-4 h-4 fill-white"></i>
                                สร้าง ออเดอร์
                            </a>

                            <button type="button" id="btnApprove"
                                class="px-4 mr-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white darker:focus:ring-offset-dark">

                                <i class="fa-solid fa-file-export mr-2 -ml-1 w-4 h-4 fill-white"></i>
                                รับ ออเดอร์
                            </button>
                        </div>

                        <div class="mb-4 mt-4 flex justify-between items-center">
                            <div class="flex-1 pr-4">
                                <div class="relative md:w-1/3">
                                    <input type="search" id="search"
                                        class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light font-medium"
                                        placeholder="ค้นหา...">
                                    <div class="absolute top-0 left-0 inline-flex items-center p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-6 h-6 text-gray-400" dark:text-lightviewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="0" y="0" width="24"
                                                height="24" stroke="none"></rect>
                                            <circle cx="10" cy="10" r="7" />
                                            <line x1="21" y1="21" x2="15"
                                                y2="15" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section id="section_table">

                            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-5">
                                <table class="w-full text-nowrap nowrap whitespace-nowrap text-md text-left text-gray-500 dark:text-gray-400 table-auto">
                                    <thead
                                        class="text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="py-2 px-6">
                                                #
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                Actions
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                หมายเลข ออเดอร์
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                ลูกค้า
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                หน่วยงาน
                                            </th>
                                            <th scope="col" class="truncate w-64 py-2 px-1">
                                                หมายเหตุ
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                สร้างโดย
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                วันที่สร้าง
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                ผู้รับ ออเดอร์
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                วันที่รับ ออเดอร์
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderTable">
                                    </tbody>
                                </table>
                            </div>

                        {{-- page control --}}
                        <div class="mt-3">
                            <div class="text-end text-slate-600 mr-2">
                                View <span id="txt_firstItem"></span> - <span id="txt_lastItem"></span> of <span
                                    id="txt_total"></span>
                            </div>

                            <div class="text-center w-full">
                                <button
                                    class="btn_first_page bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
                                    type="button" id="select_page" url_data="">
                                    <<
                                </button>
                                <button
                                    class="btn_prev_page bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
                                    type="button" id="select_page" url_data="">
                                    <
                                </button>
                                        Page
                                <input type="text" id="page_input" value=""
                                    class="text-center bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 p-[7px] w-20 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                of <span id="lastPage"></span>
                                <button
                                    class="btn_next_page bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
                                    type="button" id="select_page" url_data="nextPageUrl">
                                    >
                                </button>
                                <button
                                    class="btn_last_page bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
                                    type="button"id="select_page" url_data="lastPage">
                                    >>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- All javascript code in this project for now is just for demo DON'T RELY ON IT  -->
</body>

</html>
