<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    @include('component.Tagheader')

    <script src="{{asset('assets/js/equipments.js')}}"></script>
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
                                        Equipments
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    {{-- Breadcrumb end --}}
                    <div
                        class="mx-auto h-auto w-full rounded-md bg-white dark:bg-darker dark:text-light shadow-sm p-4 leading-6">
                        <div class="flex justify-end">
                            <button type="button"
                                class="openAddModal px-4 mr-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-solid fa-file-pen mr-2 -ml-1 w-4 h-4 fill-white"></i>
                                เพิ่มข้อมูลอุปกรณ์
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
                                                Actions
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                ชื่ออุปกรณ์
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                ราคา
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                กระบวนการ
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                จำนวนวันหมดอายุ (วัน)
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                คำอธิบาย
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                ประเภทอุปกรณ์
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                เปิดใช้งาน
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="equipmentsTable">
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
            </div>

            <div class="fixed z-10 inset-0 w-full invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="interestModal">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
                        <div class="inline-block align-bottom bg-white dark:bg-darker dark:text-light rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-top sm:max-w-2xl w-full">
                            <div class="bg-white dark:bg-darker dark:text-light px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <i class="fa-regular fa-building text-gray-700"></i>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg mt-2 leading-6 font-medium bg-white dark:bg-darker dark:text-light" id="modal-title">
                                        เพิ่มข้อมูลอุปกรณ์
                                        </h3>
                                </div>
                            </div>
                            <p class="mt-4">
                                <div class="text-sm dark:text-light">
                                    <div class="flex flex-col flex-wrap">
                                        <div class="mr-2 ml-2">
                                            <label for="equip_name" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">ชื่ออุปกรณ์</label>
                                            <input type="text" id="equip_name" name="equip_name" class="block p-2 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="mr-2 ml-2">
                                            <label for="price" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">ราคา</label>
                                            <input type="number" id="price" value="0.00" name="price" min="0" step="0.01" class="block p-2 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="mr-2 ml-2">
                                            <label for="expire" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">จำนวนวันหมดอายุ</label>
                                            <input type="number" id="expire" name="expire" value="0" min="0" step="1" class="block p-2 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="mr-2 ml-2">
                                            <label for="process" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">กระบวนการ</label>
                                            <select id="process" class="block p-2 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="0" disabled selected>เลือก Process Type</option>
                                                <option value="STEAM">STEAM</option>
                                                <option value="plasma">PLASMA</option>
                                                <option value="eo">EO</option>
                                                <option value="Wash&Disinfection">Wash&Disinfection</option>
                                            </select>
                                        </div>
                                        <div class="mr-2 ml-2">
                                            <label for="item_type" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">ประเภทอุปกรณ์</label>
                                            <input type="text" id="item_type" name="item_type" class="block p-2 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="mr-2 ml-2">
                                            <label for="descriptions" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">คำอธิบาย</label>
                                            <textarea id="descriptions" name="descriptions" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=""></textarea>                                            
                                        </div>
                                        <div class="flex items-center mr-3 ml-3 mt-2">
                                            <input id="SUD_Check" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="SUD_Check" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">อุปกรณ์ SUD</label>
                                        </div>
                                        <div class="mr-2 ml-2" hidden id="input_div_limit">
                                            <label for="limit" class="block mt-1 mb-1 text-sm font-medium text-gray-900 dark:text-gray-400">จำนวนรอบสูงสุด</label>
                                            <input type="number" id="limit" value="0" name="limit" min="0" step="0" class="block p-2 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                            </p>
                        </div>
                        <div class="bg-white dark:bg-darker dark:text-light px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" id="add_equip" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary hover:bg-primary-dark text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                เพื่มอุปกรณ์
                            </button>
                            <button type="button" class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                ยกเลิก
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- edit --}}
            <div class="fixed z-10 inset-0 w-full invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="editModal">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
                        <div class="inline-block align-bottom bg-white dark:bg-darker dark:text-light rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-top sm:max-w-2xl w-full">
                            <div class="bg-white dark:bg-darker dark:text-light px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <i class="fa-regular fa-building text-gray-700"></i>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg mt-2 leading-6 font-medium bg-white dark:bg-darker dark:text-light" id="modal-title">
                                            แก้ไขข้อมูลอุปกรณ์
                                        </h3>
                                </div>
                            </div>
                            <p class="mt-4">
                                <div class="text-sm dark:text-light">
                                    <div class="flex flex-col flex-wrap">
                                        <div class="mr-2 ml-2">
                                            <label for="edit_equip_name" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">ชื่ออุปกรณ์</label>
                                            <input type="text" data-value="" id="edit_equip_name" name="edit_equip_name" class="block p-2 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="mr-2 ml-2">
                                            <label for="price" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">ราคา</label>
                                            <input type="number" id="edit_price" value="0.00" name="edit_price" min="0" step="0.01" class="block p-2 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="mr-2 ml-2">
                                            <label for="edit_expire" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">จำนวนวันหมดอายุ</label>
                                            <input type="number" id="edit_expire" name="edit_expire" value="0" min="0" step="1" class="block p-2 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="mr-2 ml-2">
                                            <label for="edit_process" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">กระบวนการ</label>
                                            <select id="edit_process" class="block p-2 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="0" disabled selected>เลือก Process Type</option>
                                                <option value="STEAM">STEAM</option>
                                                <option value="plasma">PLASMA</option>
                                                <option value="eo">EO</option>
                                                <option value="Wash&Disinfection">Wash&Disinfection</option>
                                            </select>
                                        </div>
                                        <div class="mr-2 ml-2">
                                            <label for="edit_item_type" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">ประเภทอุปกรณ์</label>
                                            <input type="text" id="edit_item_type" name="edit_item_type" class="block p-2 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="mr-2 ml-2">
                                            <label for="edit_descriptions" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">คำอธิบาย</label>
                                            <textarea id="edit_descriptions" name="edit_descriptions" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=""></textarea>                                            
                                        </div>
                                        <div class="flex items-center mr-3 ml-3 mt-2">
                                            <input id="edit_SUD_Check" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="edit_SUD_Check" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">อุปกรณ์ SUD</label>
                                        </div>
                                        <div class="mr-2 ml-2" id="edit_input_div_limit" hidden>
                                            <label for="edit_limit" class="block mt-1 mb-1 text-sm font-medium text-gray-900 dark:text-gray-400">จำนวนรอบสูงสุด</label>
                                            <input type="number" id="edit_limit" value="0" name="edit_price" min="0" step="0" class="block p-2 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                            </p>
                        </div>
                        <div class="bg-white dark:bg-darker dark:text-light px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" id="save_edit_equip" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary hover:bg-primary-dark text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                แก้ไขข้อมูล
                            </button>
                            <button type="button" class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                ยกเลิก
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fixed z-10 inset-0 w-full invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal_images">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
                        <div class="inline-block align-bottom bg-white dark:bg-darker dark:text-light rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-top sm:max-w-2xl w-full">
                            <div class="bg-white dark:bg-darker dark:text-light px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        {{-- <i class="fa-regular fa-building text-gray-700"></i> --}}
                                        <i class="fa-solid fa-image fa-lg text-gray-700"></i>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg mt-2 leading-6 font-medium bg-white dark:bg-darker dark:text-light" id="modal-title">
                                            เพิ่มรูปภาพ
                                        </h3>
                                </div>
                            </div>
                            <p class="mt-4">
                                <div class="text-sm dark:text-light">
                                    <div class="flex flex-col flex-wrap">
                                        <div class="flex justify-center items-center w-full">
                                            <label for="dropzone-file" id="label_tag" data-value="" class="dropzone-file flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                                <div class="flex flex-col justify-center items-center pt-5 pb-6">
                                                    <svg aria-hidden="true" class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF</p>
                                                </div>
                                                <input id="dropzone-file" type="file" accept="image/svg, image/png, image/gif, image/jpeg" class="hidden" multiple>
                                            </label>
                                        </div> 
                                        <div class="py-2">
                                            <span>
                                                <h3 class="text-lg"><hr></h3> 
                                                <div class="mb-1 text-base font-medium dark:text-white"></div>
                                                    <div class="percent_upload_bar w-full invisible bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-700">
                                                    <div class="percent_upload bg-blue-600 h-1.5 rounded-full dark:bg-blue-500" style="width: 0%"></div>
                                                </div>
                                            </span>
                                            <div class="grid gap-6 mb-6 lg:grid-cols-2 md:grid-cols-2" id="list_img">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </p>
                        </div>
                        <div class="bg-white dark:bg-darker dark:text-light px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                ปิด
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal_show_image_packing" class="z-50 invisible fixed top-0 left-0 w-screen h-screen bg-black/70 flex justify-center items-center overflow-auto">

                <!-- The close button -->
                <a class="fixed z-50 top-6 right-8 text-5xl font-bold cursor-pointer text-orange-500" id="Close_show_image_packing">×</a>
        
                <!-- A big image will be displayed here -->
                <img id="modal_Fullimg_packing" class="flex flex-col h-auto max-h-full" src="">
            </div>

            </main>
        </div>
    </div>

</body>

</html>
