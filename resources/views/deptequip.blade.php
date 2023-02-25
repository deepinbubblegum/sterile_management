<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    @include('component.Tagheader')
    <script src="{{asset('assets/js/deptequip.js')}}"></script>
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
                                        <a class="hover:underline" href="/settings/customers"> Customers </a>
                                        <i class="fa-solid fa-angle-right inline-flex ml-1 mr-1 mt-1 align-middle"></i>
                                        <a class="hover:underline" href="/settings/customers/departments/{{$customer_id}}">Departments</a>
                                        <i class="fa-solid fa-angle-right inline-flex ml-1 mr-1 mt-1 align-middle"></i>
                                        <a class="">Equipments</a>
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
                                เพิ่มอุปกรณ์ในแผนก
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
                                                ชื่ออุปกรณ์
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                กระบวนการ
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                ประเภทอุปกรณ์
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                คำอธิบาย
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                ชื่อลูกค้า
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                แผนก
                                            </th>
                                            <th scope="col" class="py-2 px-1">
                                                Actions
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
                                        เพิ่มอุปกรณ์ในแผนก
                                        </h3>
                                </div>
                            </div>
                            <p class="mt-2">
                                <div class="text-sm dark:text-light">
                                    <div class="w-full mt-3">
                                        <label for="small-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">ชื่ออุปกรณ์</label>
                                        <select id="equipment_list" name="equipment_list" autocomplete="equipment_list"
                                            class="select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="" disabled selected> --- โปรดเลือก อุปกรณ์ --- </option>
                                        </select>
                                    </div>
                                </div>
                            </p>
                        </div>
                        <div class="bg-white dark:bg-darker dark:text-light px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" id="add_equipment" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary hover:bg-primary-dark text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                เพื่มอุปกรณ์
                            </button>
                            <button type="button" class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                ปิด
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            </main>
        </div>
    </div>
</body>

</html>
