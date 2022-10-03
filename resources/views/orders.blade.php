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

                            <button target="_blank"
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


                        {{-- table --}}
                        {{-- <div>
                            <!-- component -->
                            <div class="antialiased sans-serif h-auto">
                                <div class="mx-auto py-6 px-0" x-data="datatables()" x-cloak>
                                    <div x-show="selectedRows.length"
                                        class="bg-teal-200 fixed top-0 left-0 right-0 z-40 w-full shadow">
                                        <div class="container mx-auto px-4 py-4">
                                            <div class="flex md:items-center">
                                                <div class="mr-4 flex-shrink-0">
                                                    <svg class="h-8 w-8 text-teal-600" dark:text-light
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div x-html="selectedRows.length + ' rows are selected'"
                                                    class="text-teal-800 text-lg"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4 flex justify-between items-center">
                                        <div class="flex-1 pr-4">
                                            <div class="relative md:w-1/3">
                                                <input type="search"
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
                                        <div>
                                            <div class="shadow rounded-lg flex">
                                                <div class="relative">
                                                    <button @click.prevent="open = !open"
                                                        class="rounded-lg inline-flex items-center bg-white dark:bg-dark dark:text-light hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="w-6 h-6 md:hidden" viewBox="0 0 24 24"
                                                            stroke-width="2" stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <rect x="0" y="0" width="24"
                                                                height="24" stroke="none"></rect>
                                                            <path
                                                                d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5" />
                                                        </svg>
                                                        <span class="hidden md:block">แสดง</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1"
                                                            width="24" height="24" viewBox="0 0 24 24"
                                                            stroke-width="2" stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <rect x="0" y="0" width="24"
                                                                height="24" stroke="none"></rect>
                                                            <polyline points="6 9 12 15 18 9" />
                                                        </svg>
                                                    </button>

                                                    <div x-show="open" @click.away="open = false"
                                                        class="z-40 absolute top-0 right-0 w-40 bg-white dark:bg-dark dark:text-light rounded-lg shadow-lg mt-12 -mr-1 block py-1 overflow-hidden">
                                                        <template x-for="heading in headings">
                                                            <label
                                                                class="flex justify-start items-center text-truncate hover:bg-gray-100 px-4 py-2">
                                                                <div class="text-teal-600 mr-3">
                                                                    <input type="checkbox"
                                                                        class="form-checkbox focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light"
                                                                        checked @click="toggleColumn(heading.key)">
                                                                </div>
                                                                <div class="select-none text-gray-700"
                                                                    x-text="heading.value"></div>
                                                            </label>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="overflow-x-auto h-auto whitespace-nowrap bg-white dark:bg-dark dark:text-light rounded-lg shadow overflow-y-auto relative">
                                        <table
                                            class="border-collapse table-auto w-full whitespace-no-wrap bg-white dark:bg-dark dark:text-light table-striped relative">
                                            <thead>
                                                <tr class="text-left">
                                                    <th
                                                        class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100 dark:bg-dark dark:text-light">
                                                        <label
                                                            class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                                            <input type="checkbox"
                                                                class="form-checkbox focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light"
                                                                @click="selectAllCheckbox($event);">
                                                        </label>
                                                    </th>
                                                    <template x-for="heading in headings">
                                                        <th class="bg-gray-100 dark:bg-dark dark:text-light sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs"
                                                            x-text="heading.value" :x-ref="heading.key"
                                                            :class="{
                                                                [heading.key]: true
                                                            }">
                                                        </th>
                                                    </template>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="order in orders" :key="order.action">
                                                    <tr>
                                                        <td class="border-dashed border-t border-gray-200 px-3">
                                                            <label
                                                                class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                                                <input type="checkbox"
                                                                    class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light"
                                                                    :name="order.action"
                                                                    @click="getRowDetail($event, order.action)">
                                                            </label>
                                                        </td>
                                                        <td class="border-dashed border-t border-gray-200 action">
                                                            <span
                                                                class="text-gray-700 dark:text-light px-6 py-1 flex items-center">
                                                                <button target="_blank"
                                                                    class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                                                    <i class="fa-regular fa-pen-to-square fa-xl mx-auto"></i>
                                                                </button>
                                                                <button target="_blank"
                                                                    class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                                                    <i class="fa-solid fa-print fa-xl mx-auto"></i>
                                                                </button>
                                                                <button target="_blank"
                                                                    class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                                                    <i class="fa-solid fa-trash fa-xl mx-auto"></i>
                                                                </button>
                                                                <button target="_blank"
                                                                    class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-warning inline-flex items-center hover:bg-warning-dark focus:outline-none focus:ring focus:ring-warning focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                                                    <i class="fa-solid fa-xmark fa-2xl mx-auto"></i>
                                                                </button>
                                                            </span>
                                                        </td>
                                                        <td class="border-dashed border-t border-gray-200 ordersId">
                                                            <span
                                                                class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                x-text="order.ordersId"></span>
                                                        </td>
                                                        <td
                                                            class="border-dashed border-t border-gray-200 customersName">
                                                            <span
                                                                class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                x-text="order.customersName"></span>
                                                        </td>
                                                        <td
                                                            class="border-dashed border-t border-gray-200 departmentsName">
                                                            <span
                                                                class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                x-text="order.departmentsName"></span>
                                                        </td>
                                                        <td class="border-dashed border-t border-gray-200 notes">
                                                            <span
                                                                class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                x-text="order.notes"></span>
                                                        </td>
                                                        <td class="border-dashed border-t border-gray-200 created_at">
                                                            <span
                                                                class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                x-text="order.created_at"></span>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                        <hr class="bg-gray-500 mt-4">
                                        <div class="flex justify-center m-4">
                                            <button target="_blank"
                                                class="px-4 w-24 mr-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white darker:focus:ring-offset-dark">
                                                <i class="fa-solid fa-caret-left fa-xl mr-2 -ml-1"></i>
                                                ย้อนกลับ
                                            </button>
                                            <button target="_blank"
                                                class="px-4 w-24 mr-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white darker:focus:ring-offset-dark">
                                                ถัดไป
                                                <i class="fa-solid fa-caret-right fa-xl ml-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function datatables() {
                                        return {
                                            headings: [{
                                                    'key': 'action',
                                                    'value': 'Actions'
                                                },
                                                {
                                                    'key': 'ordersId',
                                                    'value': 'หมายเลข ออเดอร์'
                                                },
                                                {
                                                    'key': 'customersName',
                                                    'value': 'ชื่อลูกค้า'
                                                },
                                                {
                                                    'key': 'departmentsName',
                                                    'value': 'หน่วยงาน'
                                                },
                                                {
                                                    'key': 'notes',
                                                    'value': 'หมายเหตุ'
                                                },
                                                {
                                                    'key': 'created_at',
                                                    'value': 'วันที่สร้าง'
                                                }
                                            ],

                                            orders: [{
                                                    "action": true,
                                                    "ordersId": "ORD-23515894525",
                                                    "customersName": "โรงพยาบาลสมเด็จพระยุพราช",
                                                    "departmentsName": "OPD สูติ-นรีเวชกรรม",
                                                    "notes": "เอกสารเสร็จสิ้น",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": true,
                                                    "ordersId": "ORD-23515894525",
                                                    "customersName": "โรงพยาบาลกรุงเทพ",
                                                    "departmentsName": "OPD ทางเดินหายใจ",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": false,
                                                    "ordersId": "ORD-23515894525",
                                                    "customersName": "w.อายุเวชกรรมชาย",
                                                    "departmentsName": "ICU อายุรกรรม",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": true,
                                                    "ordersId": "ORD-23515894525",
                                                    "customersName": "นาย สมชาย สมบัติ",
                                                    "departmentsName": "ICU อายุรกรรม",
                                                    "notes": "เอกสารเสร็จสิ้น",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": true,
                                                    "ordersId": "ORD-23515894525",
                                                    "customersName": "w.อายุเวชกรรมชาย",
                                                    "departmentsName": "ICU อายุรกรรม",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": false,
                                                    "ordersId": "ORD-23515894525",
                                                    "customersName": "คลินิคคู่สัญญา",
                                                    "departmentsName": "เวชศาสตร์ฟื้นฟู",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": true,
                                                    "ordersId": "ORD-23515894525",
                                                    "customersName": "นาย สมชาย สมบัติ",
                                                    "departmentsName": "w.อาคาร 2 ชั้น 6",
                                                    "notes": "เอกสารเสร็จสิ้น",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": true,
                                                    "ordersId": "ORD-23515894525",
                                                    "customersName": "คลินิคคู่สัญญา",
                                                    "departmentsName": "คลินิคผู้สูงอายุ",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": false,
                                                    "ordersId": "ORD-23515894525",
                                                    "customersName": "คลินิคคู่สัญญา",
                                                    "departmentsName": "คลินิคผู้สูงอายุ",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                }, {
                                                    "action": true,
                                                    "ordersId": "ORD-23515894525",
                                                    "customersName": "นาย สมชาย สมบัติ",
                                                    "departmentsName": "คลินิคผู้สูงอายุ",
                                                    "notes": "เอกสารเสร็จสิ้น",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": true,
                                                    "ordersId": "ORD-23515894525",
                                                    "customersName": "คลินิคคู่สัญญา",
                                                    "departmentsName": "คลินิคผู้สูงอายุ",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": false,
                                                    "ordersId": "ORD-23515894525",
                                                    "customersName": "คลินิคคู่สัญญา",
                                                    "departmentsName": "คลินิคผู้สูงอายุ",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                }
                                            ],
                                            selectedRows: [],

                                            open: false,

                                            toggleColumn(key) {
                                                // Note: All td must have the same class name as the headings key! 
                                                let columns = document.querySelectorAll('.' + key);

                                                if (this.$refs[key].classList.contains('hidden') && this.$refs[key].classList.contains(key)) {
                                                    columns.forEach(column => {
                                                        column.classList.remove('hidden');
                                                    });
                                                } else {
                                                    columns.forEach(column => {
                                                        column.classList.add('hidden');
                                                    });
                                                }
                                            },

                                            getRowDetail($event, id) {
                                                let rows = this.selectedRows;

                                                if (rows.includes(id)) {
                                                    let index = rows.indexOf(id);
                                                    rows.splice(index, 1);
                                                } else {
                                                    rows.push(id);
                                                }
                                            },

                                            selectAllCheckbox($event) {
                                                let columns = document.querySelectorAll('.rowCheckbox');

                                                this.selectedRows = [];

                                                if ($event.target.checked == true) {
                                                    columns.forEach(column => {
                                                        column.checked = true
                                                        this.selectedRows.push(parseInt(column.name))
                                                    });
                                                } else {
                                                    columns.forEach(column => {
                                                        column.checked = false
                                                    });
                                                    this.selectedRows = [];
                                                }
                                            }
                                        }
                                    }
                                </script>
                            </div>

                        </div> --}}

                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- All javascript code in this project for now is just for demo DON'T RELY ON IT  -->
</body>

</html>
