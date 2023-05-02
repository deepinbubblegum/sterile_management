<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    @include('component.Tagheader')

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

    </style>

    {{-- <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" /> --}}
    {{-- <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script> --}}

</head>

<body id="body_html" class="overflow-y-hidden">
    <div x-data="setup()" x-init="$refs.loading.classList.add('hidden');
    setColors(color);" :class="{ 'dark': isDark }" @resize.window="watchScreen()">
        <div class="flex h-screen antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
            <!-- Loading screen -->
            <div x-ref="loading"
                class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-primary-darker">
                Loading.....
            </div>

            @include('component.slidebar')

            @include('component.Loading')


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
                                        {{-- <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg> --}}
                                        <i class="fa-solid fa-file-medical fa-lg mr-2"></i>
                                        COA Report
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    {{-- Breadcrumb end --}}

                    <div
                        class="mx-auto h-auto w-full rounded-md bg-white dark:bg-darker dark:text-light shadow-sm p-4 leading-6">

                        COA Report

                        <div class="mt-5 mb-5">


                            <div class="mt-5">
                                <form>
                                    <div class="grid gap-6 mb-6 md:grid-cols-2">

                                        <div>
                                            <label for="option_machine_sterile_search"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                                                ค้นหาโดย เครื่องSterile
                                            </label>
                                            <select id="option_machine_sterile_search" data-type=""
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                {{-- <option>Sterile 01</option>
                                                <option>Sterile 02</option>
                                                <option>Sterile 03</option> --}}
                                            </select>
                                        </div>

                                        <div>
                                            <label for="t_date"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">ค้นหาโดยรอบวันที่</label>
                                            <div class="relative">
                                                <div
                                                    class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                    <svg aria-hidden="true"
                                                        class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                        fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <input datepicker type="text" id="Search_datepicker"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Select date">
                                            </div>
                                        </div>

                                    </div>
                                    <button type="button" id="btn_search"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ค้นหา
                                    </button>
                                    <button type="button" id="btn_clear_search"
                                        class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">ล้างการค้นหา
                                    </button>
                                </form>
                            </div>

                            <section id="section_table">

                                <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-5">
                                    <table
                                        class="w-full text-sm text-center text-gray-900 dark:text-gray-100 table-auto">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="py-3 px-6">
                                                    Action
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    Machine
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    Cycle
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    รอบวันที่
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="COA_TBody">

                                        </tbody>
                                    </table>
                                </div>
                                {{-- {{ $users->links('pagination::tailwind') }} --}}


                                <div class="mt-3">

                                    <div class="text-end text-slate-600 mr-2">
                                        View <span id="txt_firstItem"></span> - <span id="txt_lastItem"></span> of <span
                                            id="txt_total"></span>
                                    </div>

                                    <div class="text-center w-full">
                                        <button
                                            class="btn_first_page bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
                                            type="button" id="select_page" url_data="">
                                            << </button> <button
                                                class="btn_prev_page bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
                                                type="button" id="select_page" url_data="">
                                                < </button> Page <input type="text" id="page_input" value=""
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
                                                        type="button" id="select_page" url_data="lastPage">
                                                        >>
                                                    </button>
                                    </div>
                                </div>

                            </section>

                            <hr class="my-4">


                            <div class="grid gap-6 mb-6 lg:grid-cols-3 md:grid-cols-3">
                                <div>
                                    <label for="option_machine_sterile"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือกเครื่อง
                                        Sterile</label>
                                    <select id="option_machine_sterile" data-type=""
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        {{-- <option>Sterile 01</option>
                                        <option>Sterile 02</option>
                                        <option>Sterile 03</option> --}}
                                    </select>
                                </div>

                                <div>
                                    <label for="Cycle"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือก
                                        Cycle</label>
                                    <input type="number" id="input_Cycle"
                                        class="input-number-only bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="t_date"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือกวันที่</label>
                                    <div class="relative">
                                        <div
                                            class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <input datepicker type="text" id="datepickerId"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Select date">
                                    </div>
                                </div>
                            </div>

                            <div class="grid gap-6 mb-6 lg:grid-cols-3 md:grid-cols-3">
                                <div>
                                    <label for="option_user"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                                        ผู้ตรวจสอบ (QC) </label>
                                    <select id="option_user" data-type=""
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        {{-- <option>Sterile 01</option>
                                        <option>Sterile 02</option>
                                        <option>Sterile 03</option> --}}
                                    </select>
                                </div>

                                <div>
                                    <label for="option_pass_status"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                                        ผลการตรวจสอบ </label>
                                    <select id="option_pass_status" data-type=""
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="" disabled="" selected="">-เลือกสถานะตรวจสอบ-</option>
                                        <option value="1">ผ่าน</option>
                                        <option value="0">ไม่ผ่าน</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid gap-6 mb-6 lg:grid-cols-3 md:grid-cols-3">
                                <div class="div_img">
                                    <p class="text-orange-600 text-xl mb-2"> <b><u>
                                                Bowie dick test (Record AutoclavePrevacuum only)
                                            </u></b> </p>
                                    <a
                                        class="block p-1 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                        <div class="relative" height="12rem" width="auto" id="list_image_Bowie">
                                            <div class="flex p-2 space-x-4 flex justify-center">
                                                <img class="w-auto" style="height: 12rem; object-fit: contain;" src=""
                                                    id="View_img_Bowie" style="">
                                            </div>


                                            <button id="btn_View_img_Full" src-data=''
                                                class="absolute top-1 right-1 bg-green-500 text-white p-2 rounded hover:bg-green-800">
                                                view
                                            </button>
                                        </div>
                                    </a>
                                    <input accept="image/png, image/jpeg"
                                        class="mt-2 w-min-[-webkit-fill-available] block text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        id="file_input_Bowie" type="file" data-type="A001">
                                </div>

                                <div class="div_img">
                                    <p class="text-orange-600 text-xl mb-2"> <b><u> Physicak Monitoring </u></b> </p>
                                    <a
                                        class="block p-1 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                        <div class="relative" height="12rem" width="auto" id="list_image_Physicak">
                                            <div class="flex p-2 space-x-4 flex justify-center">
                                                <img class="w-auto" style="height: 12rem; object-fit: contain;" src=""
                                                    id="View_img_Physicak" style="">
                                            </div>
                                            <button id="btn_View_img_Full" src-data=''
                                                class="absolute top-1 right-1 bg-green-500 text-white p-2 rounded hover:bg-green-800">
                                                view
                                            </button>
                                        </div>
                                    </a>
                                    <input accept="image/png, image/jpeg"
                                        class="mt-2 w-min-[-webkit-fill-available] block text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        id="file_input_Physicak" type="file" data-type="A002">
                                </div>
                            </div>


                            <div class="mt-[3rem] mb-2">
                                <p class="text-orange-600 text-xl"> <b><u> Chemical Monotoring </u></b> </p>
                            </div>
                            <div class="grid gap-6 mb-6 lg:grid-cols-3 md:grid-cols-3">

                                <div class="div_img">
                                    <p class="mb-1 text-green-400"> Pre-Test </p>
                                    <a
                                        class="block p-1 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                        <div class="relative" height="12rem" width="auto" id="list_image_Chemical_Pre">
                                            <div class="flex p-2 space-x-4 flex justify-center">
                                                <img class="w-auto" style="height: 12rem; object-fit: contain;" src=""
                                                    id="View_img_Chemical_Pre" style="">
                                            </div>
                                            <button id="btn_View_img_Full" src-data=''
                                                class="absolute top-1 right-1 bg-green-500 text-white p-2 rounded hover:bg-green-800">
                                                view
                                            </button>
                                        </div>
                                    </a>
                                    <input accept="image/png, image/jpeg"
                                        class="mt-2 w-min-[-webkit-fill-available] block text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        id="file_input_Chemical_Pre" type="file" data-type="A003">
                                </div>

                                <div class="div_img">
                                    <p class="mb-1 text-green-400"> Post-Test </p>
                                    <a
                                        class="block p-1 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                        <div class="relative" height="12rem" width="auto" id="list_image_Chemical_Post">
                                            <div class="flex p-2 space-x-4 flex justify-center">
                                                <img class="w-auto" style="height: 12rem; object-fit: contain;" src=""
                                                    id="View_img_Chemical_Post" style="">
                                            </div>
                                            <button id="btn_View_img_Full" src-data=''
                                                class="absolute top-1 right-1 bg-green-500 text-white p-2 rounded hover:bg-green-800">
                                                view
                                            </button>
                                        </div>
                                    </a>
                                    <input accept="image/png, image/jpeg"
                                        class="mt-2 w-min-[-webkit-fill-available] block text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        id="file_input_Chemical_Post" type="file" data-type="A004">
                                </div>
                            </div>

                            <div class="mt-[3rem] mb-2">
                                <p class="text-orange-600 text-xl"> <b><u> Biological Monotoring </u></b> </p>
                            </div>
                            <div class="grid gap-6 mb-6 lg:grid-cols-3 md:grid-cols-3">

                                <div class="div_img">
                                    <p class="mb-1 text-green-400"> Pre-Test </p>
                                    <a
                                        class="block p-1 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                        <div class="relative" height="12rem" width="auto"
                                            id="list_image_Biological_Pre">
                                            <div class="flex p-2 space-x-4 flex justify-center">
                                                <img class="w-auto" style="height: 12rem; object-fit: contain;" src=""
                                                    id="View_img_Biological_Pre" style="">
                                            </div>
                                            <button id="btn_View_img_Full" src-data=''
                                                class="absolute top-1 right-1 bg-green-500 text-white p-2 rounded hover:bg-green-800">
                                                view
                                            </button>
                                        </div>
                                    </a>
                                    <input accept="image/png, image/jpeg"
                                        class="mt-2 w-min-[-webkit-fill-available] block text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        id="file_input_Biological_Pre" type="file" data-type="A005">
                                </div>

                                <div class="div_img">
                                    <p class="mb-1 text-green-400"> Post-Test </p>
                                    <a
                                        class="block p-1 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                        <div class="relative" height="12rem" width="auto"
                                            id="list_image_Biological_Post">
                                            <div class="flex p-2 space-x-4 flex justify-center">
                                                <img class="w-auto" style="height: 12rem; object-fit: contain;" src=""
                                                    id="View_img_Biological_Post" style="">
                                            </div>
                                            <button id="btn_View_img_Full" src-data=''
                                                class="absolute top-1 right-1 bg-green-500 text-white p-2 rounded hover:bg-green-800">
                                                view
                                            </button>
                                        </div>
                                    </a>
                                    <input accept="image/png, image/jpeg"
                                        class="mt-2 w-min-[-webkit-fill-available] block text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        id="file_input_Biological_Post" type="file" data-type="A006">
                                </div>
                            </div>

                            <div class="lg:grid-cols-1 md:grid-cols-1 mt-1 text-center">
                                <div>
                                    <button type="button" id="btn_save_coa"
                                        class="my-2 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-lg  px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-400 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        บันทึก COA Report
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


                {{-- Modal Show Images --}}
                <div id="modal_show_image_full"
                    class="z-50 hidden fixed top-0 left-0 w-screen h-screen bg-black/90 flex justify-center items-center overflow-auto">

                    <!-- The close button -->
                    <a class="fixed z-50 top-6 right-8 text-white text-5xl font-bold cursor-pointer text-orange-500"
                        id="Close_show_image">&times;</a>

                    <!-- A big image will be displayed here -->
                    <img id="modal_Fullimg" class="flex flex-col h-auto max-h-[80%] max-w-[80%]" src="" />
                </div>


            </main>
        </div>
    </div>

    <!-- All javascript code in this project for now is just for demo DON'T RELY ON IT  -->

</body>


<script>
    $(document).ready(function () {

        $('#option_user').select2();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // init
        Get_mechine();
        get_COA();
        Get_User();

        let Data_COA;

        function Get_mechine() {

            $.ajax({
                type: "POST",
                url: `/coa/Get_mechine`,
                dataType: "json",
                success: function (response) {
                    html_list = ''

                    // response.machines
                    html_list +=
                        `<option value="" disabled selected>-เลือกเครื่อง Sterile-</option>`
                    for (let item of response.machine) {
                        html_list +=
                            `<option value='${item.Machine_id}' data-process='${item.Machine_type}' >${item.Machine_name}</option>`
                    }

                    $('#option_machine_sterile').html(html_list)
                    $('#option_machine_sterile_search').html(html_list)

                }
            });
        }

        function Get_User() {
            $.ajax({
                type: "POST",
                url: `/coa/Get_User`,
                dataType: "json",
                success: function (response) {
                    html_list = ''

                    html_list +=
                        `<option value="" disabled selected>-เลือกผู้ตรวจสอบ-</option>`
                    for (let item of response.user) {
                        html_list +=
                            `<option value='${item.User_id}' >${item.Name}</option>`
                    }

                    $('#option_user').html(html_list)

                }
            });
        }

        function get_COA(page = 1, txt_search = '', Date = '') {

            $(".background_loading").css("display", "block");

            $.ajax({
                type: "POST",
                url: `/coa/Get_COA?page=${page}`,
                dataType: "json",
                data: {
                    txt_search: txt_search,
                    Date: Date
                },
                success: function (response) {

                    $('#txt_firstItem').text(response.COA.from)
                    $('#txt_lastItem').text(response.COA.to)
                    $('#txt_total').text(response.COA.total)
                    $('#lastPage').text(response.COA.last_page)
                    $('#page_input').val(response.COA.current_page)


                    const btn_first_page = document.querySelector(".btn_first_page");
                    btn_first_page.setAttribute("url_data", response.COA.first_page_url);

                    const btn_prev_page = document.querySelector(".btn_prev_page");
                    btn_prev_page.setAttribute("url_data", response.COA.prev_page_url);

                    const btn_next_page = document.querySelector(".btn_next_page");
                    btn_next_page.setAttribute("url_data", response.COA.next_page_url);

                    const btn_last_page = document.querySelector(".btn_last_page");
                    btn_last_page.setAttribute("url_data", response.COA.last_page_url);

                    Data_COA = response.COA.data;

                    html_list = '';
                    for (let item of response.COA.data) {

                        html_list += `
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a type="button" href="/COA_Report_PDF/${item.coa_id}" target="_blank"
                                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        <i class="fa-solid fa-print fa-lg fill-white icon_center"></i>
                                    </a>

                                    <button type="button" id="btn_edit" data-coa_id="${item.coa_id}"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <i class="fa-solid fa-wrench fa-lg fill-white icon_center"></i>
                                    </button>

                                    <button type="button" id="btn_Delete" data-coa_id="${item.coa_id}"
                                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                        <i class="fa-solid fa-trash fa-lg fill-white icon_center"></i>
                                    </button>

                                </td>
                                <td class="py-4 px-6" value="${item.Machine_id}"> ${item.Machine_name} </td>
                                <td class="py-4 px-6" value="${item.cycle}"> ${item.cycle} </td>
                                <td class="py-4 px-6" value="${item.date}"> ${item.date} </td>
                            </tr>
                        `
                    }
                    $('#COA_TBody').html(html_list)

                    $(".background_loading").css("display", "none");


                    document.querySelector('#page_input').addEventListener('keypress', function (
                        e) {
                        if (e.key === 'Enter') {
                            // code for enter
                            let input = $('#page_input').val()

                            changPage(input, response.COA.last_page)
                        }
                    });

                }
            });
        }



        // list_img = ['file_input_Bowie', 'file_input_Physicak', 'file_input_Chemical_Pre',
        //         'file_input_Chemical_Post', 'file_input_Biological_Pre',
        //         'file_input_Biological_Post'
        //     ];


        $(document).on('change', '#file_input_Bowie', function () {
            let files = $(this).prop('files');
            $('#View_img_Bowie').attr('src', '')
            preview_img(files, 'View_img_Bowie')
        })

        $(document).on('change', '#file_input_Physicak', function () {
            let files = $(this).prop('files');
            $('#View_img_Physicak').attr('src', '')
            preview_img(files, 'View_img_Physicak')
        })

        $(document).on('change', '#file_input_Chemical_Pre', function () {
            let files = $(this).prop('files');
            $('#View_img_Chemical_Pre').attr('src', '')
            preview_img(files, 'View_img_Chemical_Pre')
        })

        $(document).on('change', '#file_input_Chemical_Post', function () {
            let files = $(this).prop('files');
            $('#View_img_Chemical_Post').attr('src', '')
            preview_img(files, 'View_img_Chemical_Post')
        })

        $(document).on('change', '#file_input_Biological_Pre', function () {
            let files = $(this).prop('files');
            $('#View_img_Biological_Pre').attr('src', '')
            preview_img(files, 'View_img_Biological_Pre')
        })

        $(document).on('change', '#file_input_Biological_Post', function () {
            let files = $(this).prop('files');
            $('#View_img_Biological_Post').attr('src', '')
            preview_img(files, 'View_img_Biological_Post')
        })



        function preview_img(files, id_preview) {

            reader = new FileReader();
            // console.log(files)
            reader.onload = function () {
                let output = document.getElementById(id_preview);
                output.src = reader.result;
                output.style.height = "12rem";
                output.style.width = "auto";
                $('#' + id_preview).parent().parent().children("#btn_View_img_Full").attr('src-data', reader
                    .result)
                // $('#' + id_modal_preview).attr('src-data', reader.result)
            };

            reader.readAsDataURL(event.target.files[0]);
        }


        $(document).on('click', '#btn_View_img_Full', function () {
            let src_img = $(this).attr('src-data')
            if (src_img == '' | src_img == null) {
                alert('ไม่มีรูปภาพ')
                return false
            }
            $('#modal_show_image_full').removeClass('hidden')
            $('#modal_Fullimg').attr('src', src_img)
        })



        $(document).on('click', '#Close_show_image', function () {
            $('#modal_Fullimg').attr('src', '');
            $('#modal_show_image_full').addClass('hidden')
        })



        $('#btn_save_coa').on('click', function () {

            let item_machines = $('#option_machine_sterile').find(":selected").val();
            let pass_status = $('#option_pass_status').find(":selected").val();
            let user_qc = $('#option_user').find(":selected").val();
            let input_Cycle = $('#input_Cycle').val();
            let date = $('#datepickerId').val();

            if (item_machines == '') {
                alert('กรุณาระบุเครื่อง Sterile')
                return false
            }

            if (user_qc == '') {
                alert('กรุณาระบุผู้ตรวจสอบ')
                return false
            }

            if (input_Cycle == '') {
                alert('กรุณาระบุ Cycle')
                return false
            }

            if (date == '') {
                alert('กรุณาระบุวันที่')
                return false
            }

            list_img = ['file_input_Bowie', 'file_input_Physicak', 'file_input_Chemical_Pre',
                'file_input_Chemical_Post', 'file_input_Biological_Pre',
                'file_input_Biological_Post'
            ];

            let Formdata = new FormData();
            for (const [index, element] of list_img.entries()) {
                let files = document.getElementById(element).files;
                // console.log(files)
                if (files.length == 0 || files[0] == undefined) {
                    alert('กรุณาอัปโหลดรูปให้ครบถ้วน')
                    return false;
                }
                let type = $('#' + element).attr('data-type')


                Formdata.append('img[' + index + ']', files[0]);
                Formdata.append('type[' + index + ']', type);
                Formdata.append('img_id[' + index + ']', null);
            }

            $(".background_loading").css("display", "block");

            Formdata.append('item_machines', item_machines);
            Formdata.append('input_Cycle', input_Cycle);
            Formdata.append('date', date);
            Formdata.append('user_qc', user_qc);
            Formdata.append('pass_status', pass_status);

            Formdata.append('coa_id', null);

            $.ajax({
                type: "POST",
                url: `/coa/New_COA_report`,
                cache: false,
                contentType: false,
                processData: false,
                data: Formdata,
                dataType: "json",
                success: function (response) {

                    if (response.code != '0000') {
                        alert('ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง' + ' (' +
                            response.message + ')')
                    }

                    $("#option_machine_sterile").val($(
                        "#option_machine_sterile option:first").val());

                    $("#option_user").val($(
                        "#option_user option:first").val());

                    $("#option_pass_status").val($(
                        "#option_pass_status option:first").val());

                    $('#input_Cycle').val('');
                    $('#datepickerId').val();

                    $('img').attr('src', '')

                    $('input').val('')

                    $('button[id=btn_View_img_Full]').attr('src-data', '')

                    get_COA()
                }
            });
        })



        $(document).on('click', '#btn_edit', function () {
            let coa_id = $(this).attr('data-coa_id')


            let _Item = Data_COA.filter(v => v.coa_id == coa_id);

            // console.log(_Item[0]['Machine_id'])

            $('#option_machine_sterile').val(_Item[0]['Machine_id'])
            $('#option_user').val(_Item[0]['user_qc']).change();
            $('#option_pass_status').val(_Item[0]['status']).change();
            $('#input_Cycle').val(_Item[0]['cycle']);
            let date = new Date(_Item[0]['date']);
            $('#datepickerId').val(date.toLocaleDateString("en-US"));

            list_img = ['file_input_Bowie', 'file_input_Physicak', 'file_input_Chemical_Pre',
                'file_input_Chemical_Post', 'file_input_Biological_Pre',
                'file_input_Biological_Post'
            ];

            _Item[0].image.forEach((element, index) => {
                let view_img = element['image']
                $('input[data-type="' + element['coa_type'] + '"]').parent().children(
                    "a").children("div").children("div").children("img").attr('src',
                    `{{ asset('assets/image/COA_Report/${view_img}') }}`);

                let fileInput = document.querySelector('input[data-type="' + element[
                    'coa_type'] + '"]');

                // Create a new File object
                let Url_img = `{{ asset('assets/image/COA_Report/${view_img}') }}`

                let type = Url_img.split(".").slice(-1)[0];
                let name_file = Url_img.split("/").slice(-1)[0];

                let img_type = 'image/png'
                if (type == 'jpg') {
                    img_type = 'image/jpeg'
                } else {
                    img_type = 'image/png'
                }

                fetch(Url_img)
                    .then(response => response.blob())
                    .then(blob => {
                        // const file = new File([blob], blob.name);
                        let myFile = new File([blob], name_file, {
                            type: img_type,
                            lastModified: new Date(),
                        });
                        // console.log(myFile)
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(myFile);
                        fileInput.files = dataTransfer.files;
                    });

                getBase64Image(`{{ asset('assets/image/COA_Report/${view_img}') }}`,
                    function (base64image) {
                        // console.log(base64image);
                        let aa = $('input[data-type="' + element['coa_type'] + '"]')
                            .parent()
                            .children(
                                "a").children("div").children('#btn_View_img_Full').attr(
                                'src-data', base64image)
                    });
            });

            document.getElementById('option_machine_sterile').focus();
        })


        $(document).on('click', '#btn_Delete', function () {

            if (!confirm('ยืนยันการลบช้อมูล')) {
                return false;
            }

            $(".background_loading").css("display", "block");

            let coa_id = $(this).attr('data-coa_id')
            $.ajax({
                type: "POST",
                url: `/coa/Delete_COA`,
                data: {
                    coa_id: coa_id
                },
                dataType: "json",
                success: function (response) {
                    // $(".background_loading").css("display", "none");
                    get_COA();
                }
            });
        })



        function getBase64Image(imgUrl, callback) {

            var img = new Image();

            // onload fires when the image is fully loadded, and has width and height

            img.onload = function () {

                var canvas = document.createElement("canvas");
                canvas.width = img.width;
                canvas.height = img.height;
                var ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0);
                var dataURL = canvas.toDataURL("image/png");
                // dataURL = dataURL.replace(/^data:image\/(png|jpg);base64,/, "");

                callback(dataURL); // the base64 string

            };

            // set attributes and src
            img.setAttribute('crossOrigin', 'anonymous'); //
            img.src = imgUrl;

        }



        // -------------------------------Page---------------------------------------//

        function getParameterByName(name, url) {
            name = name.replace(/[\[\]]/g, '\\$&');
            let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }


        $(document).on('click', '#select_page', function () {
            let type_btn = $(this).attr("type_btn")
            let url_data = $(this).attr("url_data")

            let page = getParameterByName('page', url_data)

            let txt_search = $('#option_machine_sterile_search').find(":selected").val();
            let Date = $('#Search_datepicker').val();

            get_COA(page, txt_search, Date);
        })


        $('#btn_search').on('click', function () {
            let txt_search = $('#option_machine_sterile_search').find(":selected").val();
            let Date = $('#Search_datepicker').val()
            get_COA(1, txt_search, Date);
        })

        $('#btn_clear_search').on('click', function () {
            let txt_search = '';
            let Date = ''
            $("#option_machine_sterile_search").val('');
            $('#Search_datepicker').val('');

            get_COA(1, txt_search, Date);
        })

        function changPage(input, last_page) {

            let txt_search = $('#option_machine_sterile_search').find(":selected").val();
            let Date = $('#Search_datepicker').val()

            if (input != parseInt(input)) {
                input = 1;
            } else if (input > last_page) {
                input = last_page
            }

            get_COA(input, txt_search, Date);
        }


    })

</script>

</html>
