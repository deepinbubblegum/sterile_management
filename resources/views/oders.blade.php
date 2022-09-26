<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sterile traceability</title>
    @include('component.Tagheader')

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
                                        Oders
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    {{-- Breadcrumb end --}}

                    <div
                        class="mx-auto h-auto w-full rounded-md bg-white dark:bg-darker dark:text-light shadow-sm p-4 leading-6">
                        <div class="flex justify-end">
                            <button target="_blank"
                                class="px-4 mr-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <svg class="mr-2 -ml-1 w-4 h-4 fill-white" aria-hidden="true" focusable="false"
                                    data-prefix="fab" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    width="24" height="24">
                                    <path
                                        d="M8,24H9a1,1,0,0,0,0-2H8a3,3,0,0,1-3-3V5A3,3,0,0,1,8,2h8a3,3,0,0,1,3,3V9a1,1,0,0,0,2,0V5a5.006,5.006,0,0,0-5-5H8A5.006,5.006,0,0,0,3,5V19A5.006,5.006,0,0,0,8,24Z" />
                                    <path
                                        d="M16 5H8A1 1 0 0 0 8 7h8a1 1 0 0 0 0-2zM17 10a1 1 0 0 0-1-1H8a1 1 0 0 0 0 2h8A1 1 0 0 0 17 10zM8 13a1 1 0 0 0 0 2h4a1 1 0 0 0 0-2zM18.879 12.879l-5.657 5.657a1 1 0 0 0-.264.467l-.929 3.757a1 1 0 0 0 .264.947 1.013 1.013 0 0 0 .947.264L17 23.042a.992.992 0 0 0 .467-.264l5.656-5.656a3 3 0 1 0-4.242-4.243zm-2.632 8.288l-1.879.465.465-1.879 3.339-3.339 1.414 1.414zm5.46-5.46L21 16.414 19.586 15l.707-.707a1 1 0 0 1 1.414 0A1.012 1.012 0 0 1 21.707 15.707z" />
                                </svg>
                                สร้าง ออเดอร์
                            </button>

                            <button target="_blank"
                                class="px-4 mr-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white darker:focus:ring-offset-dark">
                                <svg class="mr-2 -ml-1 w-4 h-4 fill-white" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 6.35 6.35">
                                    <path
                                        d="M4.497 0a.265.265 0 0 0-.264.263v1.06c0 .435.358.793.793.793h1.06a.265.265 0 0 0 0-.529h-1.06a.26.26 0 0 1-.263-.264V.263A.265.265 0 0 0 4.497 0Z"
                                        color="#000" />
                                    <path
                                        d="M2.117 0a.798.798 0 0 0-.795.793V2.91a.265.265 0 0 0 .266.266.265.265 0 0 0 .264-.266V.793a.26.26 0 0 1 .265-.264H4.39L5.82 1.961v3.596a.26.26 0 0 1-.263.263h-3.44a.26.26 0 0 1-.265-.263v-.53a.265.265 0 0 0-.264-.265.265.265 0 0 0-.266.265v.53c0 .435.36.793.795.793h3.44a.796.796 0 0 0 .793-.793V1.852a.265.265 0 0 0-.077-.188L4.686.078A.265.265 0 0 0 4.498 0Z"
                                        color="#000" />
                                    <path d="M.264 4.234a.265.265 0 0 1 0-.529h3.175a.265.265 0 1 1 0 .53z"
                                        color="#000" />
                                    <path style="-inkscape-stroke:none"
                                        d="M2.723 2.988a.265.265 0 0 0 0 .373l.607.608-.607.607a.265.265 0 0 0 0 .373.265.265 0 0 0 .375 0l.793-.793a.265.265 0 0 0 0-.375l-.793-.793a.265.265 0 0 0-.375 0z"
                                        color="#000" />
                                </svg>
                                รับ ออเดอร์
                            </button>
                        </div>

                        {{-- table --}}
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
                                                <template x-for="oder in oders" :key="oder.action">
                                                    <tr>
                                                        <td class="border-dashed border-t border-gray-200 px-3">
                                                            <label
                                                                class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                                                <input type="checkbox"
                                                                    class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light"
                                                                    :name="oder.action"
                                                                    @click="getRowDetail($event, oder.action)">
                                                            </label>
                                                        </td>
                                                        <td class="border-dashed border-t border-gray-200 action">
                                                            <span
                                                                class="text-gray-700 dark:text-light px-6 py-1 flex items-center">
                                                                <button target="_blank"
                                                                    class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                                                    <svg class="w-8 h-8 fill-white" version="1.1"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 330 330">
                                                                        <path id="XMLID_24_"
                                                                            d="M75,180v60c0,8.284,6.716,15,15,15h60c3.978,0,7.793-1.581,10.606-4.394l164.999-165 c5.858-5.858,5.858-15.355,0-21.213l-60-60C262.794,1.581,258.978,0,255,0s-7.794,1.581-10.606,4.394l-165,165 C76.58,172.206,75,176.022,75,180z M105,186.213L255,36.213L293.787,75l-150,150H105V186.213z" />
                                                                        <path id="XMLID_27_"
                                                                            d="M315,150.001c-8.284,0-15,6.716-15,15V300H30V30H165c8.284,0,15-6.716,15-15s-6.716-15-15-15H15 C6.716,0,0,6.716,0,15v300c0,8.284,6.716,15,15,15h300c8.284,0,15-6.716,15-15V165.001C330,156.716,323.284,150.001,315,150.001z" />
                                                                    </svg>

                                                                </button>
                                                                <button target="_blank"
                                                                    class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                                                    <svg class="w-8 h-8 fill-white"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        aria-label="Printer" role="img"
                                                                        viewBox="0 0 512 512">
                                                                        <rect width="16" height="16"
                                                                            rx="15%" fill="#fff" />
                                                                        <path
                                                                            d="M416.155 164.483H95.845c-38.895 0-68.638 29.743-68.638 68.638v137.275h91.517v91.518h274.552v-91.518h91.517V233.121c0-38.895-29.743-68.638-68.638-68.638zm-68.638 251.672H164.483V301.759h183.034v114.396zM416.155 256c-13.728 0-22.879-9.152-22.879-22.879 0-13.728 9.151-22.88 22.879-22.88 13.728 0 22.879 9.152 22.879 22.88 0 13.727-9.151 22.879-22.879 22.879zM393.276 50.086H118.724v91.518h274.552V50.086z" />
                                                                    </svg>
                                                                </button>
                                                                <button target="_blank"
                                                                    class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">

                                                                    <svg class="w-8 h-8 fill-white" version="1.1"
                                                                        id="Layer_1"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        x="0px" y="0px"
                                                                        viewBox="0 0 330 330"
                                                                        style="enable-background:new 0 0 330 330;"
                                                                        xml:space="preserve">
                                                                        <path
                                                                            d="M240,121.076H30V275c0,8.284,6.716,15,15,15h60h37.596c19.246,24.348,49.031,40,82.404,40c57.897,0,105-47.103,105-105
                                                                                C330,172.195,290.816,128.377,240,121.076z M225,300c-41.355,0-75-33.645-75-75s33.645-75,75-75s75,33.645,75,75
                                                                                S266.355,300,225,300z" />
                                                                        <path
                                                                            d="M240,90h15c8.284,0,15-6.716,15-15s-6.716-15-15-15h-30h-15V15c0-8.284-6.716-15-15-15H75c-8.284,0-15,6.716-15,15v45H45
                                                                                H15C6.716,60,0,66.716,0,75s6.716,15,15,15h15H240z M90,30h90v30h-15h-60H90V30z" />
                                                                        <path
                                                                            d="M256.819,193.181c-5.857-5.858-15.355-5.858-21.213,0L225,203.787l-10.606-10.606c-5.857-5.858-15.355-5.858-21.213,0
                                                                                c-5.858,5.858-5.858,15.355,0,21.213L203.787,225l-10.606,10.606c-5.858,5.858-5.858,15.355,0,21.213
                                                                                c2.929,2.929,6.768,4.394,10.606,4.394c3.839,0,7.678-1.465,10.607-4.394L225,246.213l10.606,10.606
                                                                                c2.929,2.929,6.768,4.394,10.607,4.394c3.839,0,7.678-1.465,10.606-4.394c5.858-5.858,5.858-15.355,0-21.213L246.213,225
                                                                                l10.606-10.606C262.678,208.535,262.678,199.039,256.819,193.181z" />
                                                                    </svg>

                                                                </button>
                                                                <button target="_blank"
                                                                    class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-warning inline-flex items-center hover:bg-warning-dark focus:outline-none focus:ring focus:ring-warning focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                                                    <svg class="w-8 h-8 m-0 fill-white" version="1.1"
                                                                        id="Capa_1"
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
                                                        <td class="border-dashed border-t border-gray-200 ordersId">
                                                            <span
                                                                class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                x-text="oder.ordersId"></span>
                                                        </td>
                                                        <td
                                                            class="border-dashed border-t border-gray-200 customersName">
                                                            <span
                                                                class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                x-text="oder.customersName"></span>
                                                        </td>
                                                        <td
                                                            class="border-dashed border-t border-gray-200 departmentsName">
                                                            <span
                                                                class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                x-text="oder.departmentsName"></span>
                                                        </td>
                                                        <td class="border-dashed border-t border-gray-200 notes">
                                                            <span
                                                                class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                x-text="oder.notes"></span>
                                                        </td>
                                                        <td class="border-dashed border-t border-gray-200 created_at">
                                                            <span
                                                                class="text-gray-700 dark:text-light px-6 py-1 flex items-center"
                                                                x-text="oder.created_at"></span>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                        <hr class="bg-gray-500 mt-4">
                                        <div class="flex justify-center m-4">
                                            <button target="_blank"
                                                class="px-4 mr-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white darker:focus:ring-offset-dark">
                                                <svg class="mr-2 -ml-1 w-6 h-6 fill-white"
                                                    xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                    width="52px" height="52px" viewBox="0 0 52 52"
                                                    enable-background="new 0 0 52 52" xml:space="preserve">
                                                    <path
                                                        d="M38,8.3v35.4c0,1-1.3,1.7-2.2,0.9L14.6,27.3c-0.8-0.6-0.8-1.9,0-2.5L35.8,7.3C36.7,6.6,38,7.2,38,8.3z" />
                                                </svg>
                                                ย้อนกลับ
                                            </button>
                                            <button target="_blank"
                                                class="px-4 mr-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white darker:focus:ring-offset-dark">
                                                ถัดไป
                                                <svg class="ml-2 w-6 h-6 fill-white" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                    width="52px" height="52px" viewBox="0 0 52 52"
                                                    enable-background="new 0 0 52 52" xml:space="preserve">
                                                    <path
                                                        d="M14,43.7V8.3c0-1,1.3-1.7,2.2-0.9l21.2,17.3c0.8,0.6,0.8,1.9,0,2.5L16.2,44.7C15.3,45.4,14,44.8,14,43.7z" />
                                                </svg>
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

                                            oders: [{
                                                    "action": true,
                                                    "ordersId": "ORD-000000246523515894525",
                                                    "customersName": "โรงพยาบาลสมเด็จพระยุพราช",
                                                    "departmentsName": "OPD สูติ-นรีเวชกรรม",
                                                    "notes": "เอกสารเสร็จสิ้น",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": true,
                                                    "ordersId": "ORD-000000246523515894525",
                                                    "customersName": "โรงพยาบาลกรุงเทพ",
                                                    "departmentsName": "OPD ทางเดินหายใจ",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": false,
                                                    "ordersId": "ORD-000000246523515894525",
                                                    "customersName": "w.อายุเวชกรรมชาย",
                                                    "departmentsName": "ICU อายุรกรรม",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": true,
                                                    "ordersId": "ORD-000000246523515894525",
                                                    "customersName": "นาย สมชาย สมบัติ",
                                                    "departmentsName": "ICU อายุรกรรม",
                                                    "notes": "เอกสารเสร็จสิ้น",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": true,
                                                    "ordersId": "ORD-000000246523515894525",
                                                    "customersName": "w.อายุเวชกรรมชาย",
                                                    "departmentsName": "ICU อายุรกรรม",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": false,
                                                    "ordersId": "ORD-000000246523515894525",
                                                    "customersName": "คลินิคคู่สัญญา",
                                                    "departmentsName": "เวชศาสตร์ฟื้นฟู",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": true,
                                                    "ordersId": "ORD-000000246523515894525",
                                                    "customersName": "นาย สมชาย สมบัติ",
                                                    "departmentsName": "w.อาคาร 2 ชั้น 6",
                                                    "notes": "เอกสารเสร็จสิ้น",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": true,
                                                    "ordersId": "ORD-000000246523515894525",
                                                    "customersName": "คลินิคคู่สัญญา",
                                                    "departmentsName": "คลินิคผู้สูงอายุ",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": false,
                                                    "ordersId": "ORD-000000246523515894525",
                                                    "customersName": "คลินิคคู่สัญญา",
                                                    "departmentsName": "คลินิคผู้สูงอายุ",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                }, {
                                                    "action": true,
                                                    "ordersId": "ORD-000000246523515894525",
                                                    "customersName": "นาย สมชาย สมบัติ",
                                                    "departmentsName": "คลินิคผู้สูงอายุ",
                                                    "notes": "เอกสารเสร็จสิ้น",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": true,
                                                    "ordersId": "ORD-000000246523515894525",
                                                    "customersName": "คลินิคคู่สัญญา",
                                                    "departmentsName": "คลินิคผู้สูงอายุ",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                },
                                                {
                                                    "action": false,
                                                    "ordersId": "ORD-000000246523515894525",
                                                    "customersName": "คลินิคคู่สัญญา",
                                                    "departmentsName": "คลินิคผู้สูงอายุ",
                                                    "notes": "เอกสารมีการแก้ไข",
                                                    "created_at": "2021-05-25 10:00:00"
                                                }
                                            ],

                                            // users: [{
                                            //     "userId": 1,
                                            //     "firstName": "Cort",
                                            //     "lastName": "Tosh",
                                            //     "emailAddress": "ctosh0@github.com",
                                            //     "gender": "Male",
                                            //     "phoneNumber": "327-626-5542"
                                            // }, {
                                            //     "userId": 2,
                                            //     "firstName": "Brianne",
                                            //     "lastName": "Dzeniskevich",
                                            //     "emailAddress": "bdzeniskevich1@hostgator.com",
                                            //     "gender": "Female",
                                            //     "phoneNumber": "144-190-8956"
                                            // }, {
                                            //     "userId": 3,
                                            //     "firstName": "Isadore",
                                            //     "lastName": "Botler",
                                            //     "emailAddress": "ibotler2@gmpg.org",
                                            //     "gender": "Male",
                                            //     "phoneNumber": "350-937-0792"
                                            // }, {
                                            //     "userId": 4,
                                            //     "firstName": "Janaya",
                                            //     "lastName": "Klosges",
                                            //     "emailAddress": "jklosges3@amazon.de",
                                            //     "gender": "Female",
                                            //     "phoneNumber": "502-438-7799"
                                            // }, {
                                            //     "userId": 5,
                                            //     "firstName": "Freddi",
                                            //     "lastName": "Di Claudio",
                                            //     "emailAddress": "fdiclaudio4@phoca.cz",
                                            //     "gender": "Female",
                                            //     "phoneNumber": "265-448-9627"
                                            // }, {
                                            //     "userId": 6,
                                            //     "firstName": "Oliy",
                                            //     "lastName": "Mairs",
                                            //     "emailAddress": "omairs5@fda.gov",
                                            //     "gender": "Female",
                                            //     "phoneNumber": "221-516-2295"
                                            // }, {
                                            //     "userId": 7,
                                            //     "firstName": "Tabb",
                                            //     "lastName": "Wiseman",
                                            //     "emailAddress": "twiseman6@friendfeed.com",
                                            //     "gender": "Male",
                                            //     "phoneNumber": "171-817-5020"
                                            // }, {
                                            //     "userId": 8,
                                            //     "firstName": "Joela",
                                            //     "lastName": "Betteriss",
                                            //     "emailAddress": "jbetteriss7@msu.edu",
                                            //     "gender": "Female",
                                            //     "phoneNumber": "481-100-9345"
                                            // }, {
                                            //     "userId": 9,
                                            //     "firstName": "Alistair",
                                            //     "lastName": "Vasyagin",
                                            //     "emailAddress": "avasyagin8@gnu.org",
                                            //     "gender": "Male",
                                            //     "phoneNumber": "520-669-8364"
                                            // }, {
                                            //     "userId": 10,
                                            //     "firstName": "Nealon",
                                            //     "lastName": "Ratray",
                                            //     "emailAddress": "nratray9@typepad.com",
                                            //     "gender": "Male",
                                            //     "phoneNumber": "993-654-9793"
                                            // }, {
                                            //     "userId": 11,
                                            //     "firstName": "Annissa",
                                            //     "lastName": "Kissick",
                                            //     "emailAddress": "akissicka@deliciousdays.com",
                                            //     "gender": "Female",
                                            //     "phoneNumber": "283-425-2705"
                                            // }, {
                                            //     "userId": 12,
                                            //     "firstName": "Nissie",
                                            //     "lastName": "Sidnell",
                                            //     "emailAddress": "nsidnellb@freewebs.com",
                                            //     "gender": "Female",
                                            //     "phoneNumber": "754-391-3116"
                                            // }, {
                                            //     "userId": 13,
                                            //     "firstName": "Madalena",
                                            //     "lastName": "Fouch",
                                            //     "emailAddress": "mfouchc@mozilla.org",
                                            //     "gender": "Female",
                                            //     "phoneNumber": "584-300-9004"
                                            // }, {
                                            //     "userId": 14,
                                            //     "firstName": "Rozina",
                                            //     "lastName": "Atkins",
                                            //     "emailAddress": "ratkinsd@japanpost.jp",
                                            //     "gender": "Female",
                                            //     "phoneNumber": "792-856-0845"
                                            // }, {
                                            //     "userId": 15,
                                            //     "firstName": "Lorelle",
                                            //     "lastName": "Sandcroft",
                                            //     "emailAddress": "lsandcrofte@google.nl",
                                            //     "gender": "Female",
                                            //     "phoneNumber": "882-911-7241"
                                            // }],
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

                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- All javascript code in this project for now is just for demo DON'T RELY ON IT  -->
</body>

</html>
