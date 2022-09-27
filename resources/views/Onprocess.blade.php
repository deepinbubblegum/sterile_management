<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sterile traceability</title>

    @include('component.Tagheader')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


    <style>
        .disabledbutton {
            pointer-events: none;
            opacity: 0.4;
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

                        <p class="mb-3 text-3xl text-gray-900 dark:text-white">Oder-ABC123</p>

                        <hr>

                        {{-- State washing --}}
                        <section class="overflow-x-auto mt-8 mb-8" id="washing_state">

                            <p class="text-2xl text-gray-900 dark:text-white" style="color: #ff8026;">Process Washing</p>

                            <div class="mt-5">
                                <form>
                                    <div class="grid gap-6 mb-6 lg:grid-cols-2 md:grid-cols-2">
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือกเครื่อง
                                                Washing</label>
                                            <select id="countries"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option>Washing 01</option>
                                                <option>Washing 02</option>
                                                <option>Washing 03</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="last_name"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                Cycle </label>
                                            <input type="text" id="last_name"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Doe" value="3" disabled>
                                        </div>
                                    </div>

                                    <div class="grid gap-6 mb-6 lg:grid-cols-2 md:grid-cols-2">
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือก
                                                Item</label>
                                            <select id="countries"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option>Item 01</option>
                                                <option>Item 02</option>
                                                <option>Item 03</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เพิ่ม
                                                Item</label>
                                            <button type="button"
                                                class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Add</button>
                                        </div>
                                    </div>

                                    {{-- <div class="grid gap-6 mb-6 lg:grid-cols-2 md:grid-cols-2">
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือกสถานะ
                                                Washing ของ Item</label>
                                            <select id="countries"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option>OnProcess</option>
                                                <option>Finish</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Update
                                                Status</label>
                                            <button type="button"
                                                class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Update</button>
                                        </div>
                                    </div> --}}

                                    <div>
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
                                                            <div
                                                                class="absolute top-0 left-0 inline-flex items-center p-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="w-6 h-6 text-gray-400"
                                                                    dark:text-lightviewBox="0 0 24 24" stroke-width="2"
                                                                    stroke="currentColor" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <rect x="0" y="0" width="24"
                                                                        height="24" stroke="none"></rect>
                                                                    <circle cx="10" cy="10"
                                                                        r="7" />
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
                                                                        stroke-width="2" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <rect x="0" y="0"
                                                                            width="24" height="24"
                                                                            stroke="none"></rect>
                                                                        <path
                                                                            d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5" />
                                                                    </svg>
                                                                    <span class="hidden md:block">แสดง</span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="w-5 h-5 ml-1" width="24"
                                                                        height="24" viewBox="0 0 24 24"
                                                                        stroke-width="2" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <rect x="0" y="0"
                                                                            width="24" height="24"
                                                                            stroke="none"></rect>
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
                                                                                    checked
                                                                                    @click="toggleColumn(heading.key)">
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
                                                            <template x-for="oder in oders" :key="oder.action">
                                                                <tr>
                                                                    <td
                                                                        class="border-dashed border-t border-gray-200 px-3">
                                                                        <label
                                                                            class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                                                            <input type="checkbox"
                                                                                class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light"
                                                                                :name="oder.action"
                                                                                @click="getRowDetail($event, oder.action)">
                                                                        </label>
                                                                    </td>
                                                                    <td
                                                                        class="border-dashed border-t border-gray-200 action">
                                                                        <span
                                                                            class="text-gray-700 dark:text-light px-6 py-1 flex items-center">
                                                                            <button target="_blank"
                                                                                title="Procress Finish"
                                                                                class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">

                                                                                <svg class="w-8 h-8 m-0 fill-white"
                                                                                    version="1.1" id="Capa_1"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                    x="0px" y="0px"
                                                                                    width="405.272px"
                                                                                    height="405.272px"
                                                                                    viewBox="0 0 405.272 405.272"
                                                                                    style="enable-background:new 0 0 405.272 405.272;"
                                                                                    xml:space="preserve">
                                                                                    <path
                                                                                        d="M393.401,124.425L179.603,338.208c-15.832,15.835-41.514,15.835-57.361,0L11.878,227.836
                                                                                   c-15.838-15.835-15.838-41.52,0-57.358c15.841-15.841,41.521-15.841,57.355-0.006l81.698,81.699L336.037,67.064
                                                                                   c15.841-15.841,41.523-15.829,57.358,0C409.23,82.902,409.23,108.578,393.401,124.425z" />
                                                                                </svg>

                                                                            </button>
                                                                            <button target="_blank"
                                                                                class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-warning inline-flex items-center hover:bg-warning-dark focus:outline-none focus:ring focus:ring-warning focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                                                                <svg class="w-8 h-8 m-0 fill-white"
                                                                                    version="1.1" id="Capa_1"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                    viewBox="0 0 47.095 47.095"
                                                                                    style="enable-background:new 0 0 47.095 47.095;"
                                                                                    xml:space="preserve">
                                                                                    <path
                                                                                        d="M45.363,36.234l-13.158-13.16l12.21-12.21c2.31-2.307,2.31-6.049,0-8.358c-2.308-2.308-6.05-2.307-8.356,0l-12.212,12.21 L11.038,1.906c-2.309-2.308-6.051-2.308-8.358,0c-2.307,2.309-2.307,6.049,0,8.358l12.81,12.81L1.732,36.831 c-2.309,2.31-2.309,6.05,0,8.359c2.308,2.307,6.049,2.307,8.356,0l13.759-13.758l13.16,13.16c2.308,2.308,6.049,2.308,8.356,0 C47.673,42.282,47.672,38.54,45.363,36.234z" />
                                                                                </svg>
                                                                            </button>
                                                                        </span>
                                                                    </td>
                                                                    <td
                                                                        class="border-dashed border-t border-gray-200 ItemName">
                                                                        <span
                                                                            class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                            x-text="oder.ItemName"></span>
                                                                    </td>
                                                                    <td
                                                                        class="border-dashed border-t border-gray-200 Washing">
                                                                        <span
                                                                            class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                            x-text="oder.Washing"></span>
                                                                    </td>
                                                                    <td
                                                                        class="border-dashed border-t border-gray-200 Status">
                                                                        <span
                                                                            class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                            x-text="oder.Status"></span>
                                                                    </td>
                                                                    <td
                                                                        class="border-dashed border-t border-gray-200 created_at">
                                                                        <span
                                                                            class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                            x-text="oder.created_at"></span>
                                                                    </td>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>

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
                                                                'key': 'ItemName',
                                                                'value': 'ชื่ออุปกรณ์'
                                                            },
                                                            {
                                                                'key': 'Washing',
                                                                'value': 'เครื่องล้าง'
                                                            },
                                                            {
                                                                'key': 'Status',
                                                                'value': 'สถานะ'
                                                            },
                                                            {
                                                                'key': 'created_at',
                                                                'value': 'วันที่สร้าง'
                                                            }
                                                        ],

                                                        oders: [{
                                                                "action": true,
                                                                "ItemName": "อุปกรณ์-01",
                                                                "Washing": "Washing-01",
                                                                "Status": "Fishnish",
                                                                "created_at": "2021-05-25 10:00:00"
                                                            },
                                                            {
                                                                "action": true,
                                                                "ItemName": "อุปกรณ์-02",
                                                                "Washing": "Washing-02",
                                                                "Status": "Fishnish",
                                                                "created_at": "2021-05-25 10:00:00"
                                                            },
                                                            {
                                                                "action": false,
                                                                "ItemName": "อุปกรณ์-03",
                                                                "Washing": "Washing-03",
                                                                "Status": "on-process",
                                                                "created_at": "2021-05-25 10:00:00"
                                                            },
                                                            {
                                                                "action": true,
                                                                "ItemName": "อุปกรณ์-04",
                                                                "Washing": "Washing-04",
                                                                "Status": "on-process",
                                                                "created_at": "2021-05-25 10:00:00"
                                                            },
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

                                    </div>

                                    <div class="text-center">
                                        <button type="button"
                                            class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">บันทึก</button>
                                    </div>

                                </form>
                            </div>

                        </section>

                        <hr>

                        {{-- State Packing --}}
                        <section class="overflow-x-auto mt-10 mb-8" id="Packing_state">

                            <p class="text-2xl text-gray-900 dark:text-white" style="color: #ffe800;">Process Packing
                            </p>

                            {{-- <div class="grid gap-6 mb-6 lg:grid-cols-2 md:grid-cols-2">
                                <div>
                                    <label for="countries"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">สถานะ
                                        Packing</label>
                                    <select id="countries"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option>OnProcess</option>
                                        <option>Finish</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="countries"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Update
                                        Status</label>
                                    <button type="button"
                                        class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Update</button>
                                </div>
                            </div> --}}

                            <div class="mt-5">
                                <form>
                                    <div class="grid gap-6 mb-6 lg:grid-cols-2 md:grid-cols-2">
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือกเครื่อง
                                                Sterile</label>
                                            <select id="countries"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option>Sterile 01</option>
                                                <option>Sterile 02</option>
                                                <option>Sterile 03</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือกโปรแกรม</label>
                                            <select id="countries"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option>Program 01</option>
                                                <option>Program 02</option>
                                                <option>Program 03</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="last_name"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                Cycle </label>
                                            <input type="text" id="last_name"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Doe" value="3" disabled>
                                        </div>
                                    </div>

                                    <div class="grid gap-6 mb-6 lg:grid-cols-2 md:grid-cols-2">
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">ผู้ตรวจสอบ</label>
                                            <select id="countries"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option>user 01</option>
                                                <option>user 02</option>
                                                <option>user 03</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="grid gap-6 mb-6 lg:grid-cols-3 md:grid-cols-3">
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือก
                                                Item</label>
                                            <select id="countries"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option>Item 01</option>
                                                <option>Item 02</option>
                                                <option>Item 03</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="last_name"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                จำนวน </label>
                                            <input type="text" id="last_name"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="จำนวน">
                                        </div>
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เพิ่ม
                                                Item</label>
                                            <button type="button"
                                                class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Add</button>
                                        </div>
                                    </div>

                                    {{-- <div class="grid gap-6 mb-6 lg:grid-cols-4 md:grid-cols-4">
                                        <div class="col-span-3">
                                            <label for="message"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">List
                                                Item</label>
                                            <textarea id="message" rows="4"
                                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>

                                        </div>
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">ลบ
                                                Item</label>
                                            <button type="button"
                                                class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
                                        </div>
                                    </div> --}}

                                    <div class="overflow-x-auto">
                                        <table class="mt-3 w-full text-sm text-left text-gray-500 dark:text-gray-400"
                                            id="tb_select">
                                            <thead
                                                class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col"  class="py-3 px-6">
                                                        <input type="checkbox" id="all_check" class="w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" />
                                                    </th>
                                                    <th scope="col" class="py-3 px-6">
                                                        Action
                                                    </th>
                                                    <th scope="col" class="py-3 px-6">
                                                        Item ID
                                                    </th>
                                                    <th scope="col" class="py-3 px-6">
                                                        Item Name
                                                    </th>
                                                    <th scope="col" class="py-3 px-6">
                                                        Machine
                                                    </th>
                                                    <th scope="col" class="py-3 px-6">
                                                        Program
                                                    </th>
                                                    <th scope="col" class="py-3 px-6">
                                                        Status-Packing
                                                    </th>
                                                    <th scope="col" class="py-3 px-6">
                                                        QTY
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <td class="py-4 px-6">
                                                        <input type="checkbox" class="w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" />
                                                    </td>
                                                    <td
                                                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <button target="_blank"
                                                            class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">

                                                            <i class="fa-solid fa-print fa-lg fill-white"></i>

                                                        </button>
                                                        <button target="_blank" title="Procress Finish"
                                                            class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">

                                                            <i class="fa-solid fa-print w-8 h-8 fill-white"></i>

                                                        </button>
                                                        <button target="_blank"
                                                            class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                                            <img class="w-8 h-8 fill-white"
                                                                src="{{ asset('icon/image-svgrepo-com.svg') }}"
                                                                alt="*">
                                                        </button>
                                                    </td>
                                                    <th class="py-4 px-6">
                                                        Item 001
                                                    </th>
                                                    <td class="py-4 px-6">
                                                        TestA
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        Machine-001
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        Program-001
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        Success
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        10
                                                    </td>
                                                </tr>
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <td class="py-4 px-6">
                                                        <input type="checkbox" class="w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-dark dark:bg-dark dark:text-light" />
                                                    </td>
                                                    <td
                                                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <button target="_blank"
                                                            class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                                            <svg class="w-8 h-8 fill-white"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                aria-label="Printer" role="img"
                                                                viewBox="0 0 512 512">
                                                                <rect width="16" height="16" rx="15%"
                                                                    fill="#fff" />
                                                                <path
                                                                    d="M416.155 164.483H95.845c-38.895 0-68.638 29.743-68.638 68.638v137.275h91.517v91.518h274.552v-91.518h91.517V233.121c0-38.895-29.743-68.638-68.638-68.638zm-68.638 251.672H164.483V301.759h183.034v114.396zM416.155 256c-13.728 0-22.879-9.152-22.879-22.879 0-13.728 9.151-22.88 22.879-22.88 13.728 0 22.879 9.152 22.879 22.88 0 13.727-9.151 22.879-22.879 22.879zM393.276 50.086H118.724v91.518h274.552V50.086z" />
                                                            </svg>
                                                        </button>
                                                        <button target="_blank" title="Procress Finish"
                                                            class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">

                                                            <svg class="w-8 h-8 fill-white" version="1.1"
                                                                id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                x="0px" y="0px" viewBox="0 0 58 58"
                                                                style="enable-background:new 0 0 58 58;"
                                                                xml:space="preserve">
                                                                <path
                                                                    d="M31,56h24V32H31V56z M33,34h20v20h-9V41.414l4.293,4.293l1.414-1.414L43,37.586l-6.707,6.707l1.414,1.414L42,41.414V54h-9
    V34z" />
                                                                <path
                                                                    d="M21.569,13.569C21.569,10.498,19.071,8,16,8s-5.569,2.498-5.569,5.569c0,3.07,2.498,5.568,5.569,5.568
    S21.569,16.64,21.569,13.569z M12.431,13.569C12.431,11.602,14.032,10,16,10s3.569,1.602,3.569,3.569S17.968,17.138,16,17.138
    S12.431,15.537,12.431,13.569z" />
                                                                <path
                                                                    d="M6.25,36.661C6.447,36.886,6.723,37,7,37c0.234,0,0.47-0.082,0.66-0.249l16.313-14.362l7.319,7.318
    c0.391,0.391,1.023,0.391,1.414,0s0.391-1.023,0-1.414l-1.825-1.824l9.181-10.054l11.261,10.323
    c0.408,0.373,1.04,0.345,1.413-0.062c0.373-0.407,0.346-1.04-0.062-1.413l-12-11c-0.196-0.179-0.452-0.279-0.72-0.262
    c-0.265,0.012-0.515,0.129-0.694,0.325l-9.794,10.727l-4.743-4.743c-0.374-0.372-0.972-0.391-1.368-0.044L6.339,35.249
    C5.925,35.614,5.884,36.246,6.25,36.661z" />
                                                                <path
                                                                    d="M57,2H1C0.448,2,0,2.447,0,3v44c0,0.553,0.448,1,1,1h24c0.552,0,1-0.447,1-1s-0.448-1-1-1H2V4h54v23c0,0.553,0.448,1,1,1
    s1-0.447,1-1V3C58,2.447,57.552,2,57,2z" />

                                                            </svg>

                                                        </button>
                                                        <button target="_blank"
                                                            class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                                            <svg class="w-8 h-8 fill-white" version="1.1"
                                                                id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                x="0px" y="0px"
                                                                viewBox="0 0 59.018 59.018"
                                                                style="enable-background:new 0 0 59.018 59.018;"
                                                                xml:space="preserve">
                                                                <path
                                                                    d="M58.741,54.809l-5.969-6.244c1.746-1.919,2.82-4.458,2.82-7.25c0-5.953-4.843-10.796-10.796-10.796S34,35.361,34,41.314
    S38.843,52.11,44.796,52.11c2.441,0,4.688-0.824,6.499-2.196l6.001,6.277c0.196,0.205,0.459,0.309,0.723,0.309
    c0.249,0,0.497-0.092,0.691-0.277C59.108,55.841,59.123,55.208,58.741,54.809z M36,41.314c0-4.85,3.946-8.796,8.796-8.796
    s8.796,3.946,8.796,8.796s-3.946,8.796-8.796,8.796S36,46.164,36,41.314z" />
                                                                <path
                                                                    d="M10.431,16.088c0,3.07,2.498,5.568,5.569,5.568s5.569-2.498,5.569-5.568c0-3.071-2.498-5.569-5.569-5.569
    S10.431,13.017,10.431,16.088z M19.569,16.088c0,1.968-1.602,3.568-3.569,3.568s-3.569-1.601-3.569-3.568s1.602-3.569,3.569-3.569
    S19.569,14.12,19.569,16.088z" />
                                                                <path
                                                                    d="M30.882,28.987l9.18-10.054l11.262,10.323c0.408,0.373,1.04,0.345,1.413-0.062c0.373-0.407,0.346-1.04-0.062-1.413l-12-11
    c-0.195-0.18-0.46-0.275-0.72-0.262c-0.266,0.012-0.516,0.129-0.694,0.325l-9.794,10.727l-4.743-4.743
    c-0.372-0.372-0.971-0.391-1.368-0.044L6.339,37.768c-0.414,0.365-0.454,0.997-0.09,1.412C6.447,39.404,6.723,39.518,7,39.518
    c0.235,0,0.471-0.082,0.661-0.249l16.313-14.362l7.319,7.318c0.391,0.391,1.023,0.391,1.414,0s0.391-1.023,0-1.414L30.882,28.987z" />
                                                                <path
                                                                    d="M30,46.518H2v-42h54v28c0,0.553,0.447,1,1,1s1-0.447,1-1v-29c0-0.553-0.447-1-1-1H1c-0.553,0-1,0.447-1,1v44
    c0,0.553,0.447,1,1,1h29c0.553,0,1-0.447,1-1S30.553,46.518,30,46.518z" />

                                                            </svg>

                                                        </button>
                                                    </td>
                                                    <th class="py-4 px-6">
                                                        Item 002
                                                    </th>
                                                    <td class="py-4 px-6">
                                                        TestB
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        Machine-002
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        Program-002
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        Success
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        10
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="button"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">บันทึก
                                        </button>
                                    </div>

                                </form>
                            </div>

                        </section>

                        <hr>

                        <section class="overflow-x-auto mt-10 mb-8" id="Sterlie_state">

                            <p class="text-2xl text-gray-900 dark:text-white" style="color: #00ffc0;">Process Sterlie
                            </p>

                            {{-- <div class="grid gap-6 mb-6 lg:grid-cols-2 md:grid-cols-2">
                                <div>
                                    <label for="countries"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือก
                                        Item เพื่อ Update Status</label>
                                    <select id="countries"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option>OnProcess</option>
                                        <option>Finish</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="countries"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Update
                                        Status</label>
                                    <button type="button"
                                        class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Update</button>
                                </div>
                            </div> --}}

                            <div class="overflow-x-auto">
                                <table class="mt-3 w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="py-3 px-6">
                                                Action
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Item ID
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Item Name
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Machine
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Program
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Status-Packing
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                QTY
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <button target="_blank" title="Procress Finish"
                                                    class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">

                                                    <svg class="w-8 h-8 m-0 fill-white" version="1.1" id="Capa_1"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                        y="0px" width="405.272px" height="405.272px"
                                                        viewBox="0 0 405.272 405.272"
                                                        style="enable-background:new 0 0 405.272 405.272;"
                                                        xml:space="preserve">
                                                        <path
                                                            d="M393.401,124.425L179.603,338.208c-15.832,15.835-41.514,15.835-57.361,0L11.878,227.836
                                               c-15.838-15.835-15.838-41.52,0-57.358c15.841-15.841,41.521-15.841,57.355-0.006l81.698,81.699L336.037,67.064
                                               c15.841-15.841,41.523-15.829,57.358,0C409.23,82.902,409.23,108.578,393.401,124.425z" />
                                                    </svg>

                                                </button>
                                            </td>
                                            <th class="py-4 px-6">
                                                Item 001
                                            </th>
                                            <td class="py-4 px-6">
                                                TestA
                                            </td>
                                            <td class="py-4 px-6">
                                                Machine-001
                                            </td>
                                            <td class="py-4 px-6">
                                                Program-001
                                            </td>
                                            <td class="py-4 px-6">
                                                Success
                                            </td>
                                            <td class="py-4 px-6">
                                                10
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <button target="_blank" title="Procress Finish"
                                                    class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">

                                                    <svg class="w-8 h-8 m-0 fill-white" version="1.1" id="Capa_1"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                        y="0px" width="405.272px" height="405.272px"
                                                        viewBox="0 0 405.272 405.272"
                                                        style="enable-background:new 0 0 405.272 405.272;"
                                                        xml:space="preserve">
                                                        <path
                                                            d="M393.401,124.425L179.603,338.208c-15.832,15.835-41.514,15.835-57.361,0L11.878,227.836
                                               c-15.838-15.835-15.838-41.52,0-57.358c15.841-15.841,41.521-15.841,57.355-0.006l81.698,81.699L336.037,67.064
                                               c15.841-15.841,41.523-15.829,57.358,0C409.23,82.902,409.23,108.578,393.401,124.425z" />
                                                    </svg>

                                                </button>
                                                </button>
                                            </td>
                                            <th class="py-4 px-6">
                                                Item 002
                                            </th>
                                            <td class="py-4 px-6">
                                                TestB
                                            </td>
                                            <td class="py-4 px-6">
                                                Machine-002
                                            </td>
                                            <td class="py-4 px-6">
                                                Program-002
                                            </td>
                                            <td class="py-4 px-6">
                                                Success
                                            </td>
                                            <td class="py-4 px-6">
                                                10
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
    $(document).ready(function() {
        $('.selectpicker').select2();
        $('.js-example-basic-single').select2();



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
    });
</script>

</html>
