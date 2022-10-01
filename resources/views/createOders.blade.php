<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sterile traceability</title>

    @include('component.Tagheader')

    <script src="{{ asset('assets/js/createOders.js') }}"></script>
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
                <div class="flex flex-col flex-1 h-full min-h-screen p-4  ">

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
                                        Create Oders
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    {{-- Breadcrumb end --}}
                    <div class="mt-10 text-base sm:mt-0">
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form action="#" method="POST">
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-4 py-5 bg-white dark:bg-darker dark:text-light sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="customers"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">สถานพยาบาล
                                                    หรือ ศูนย์การแพทย์ *</label>
                                                <select id="customers" name="customers" autocomplete="customers"
                                                    class="select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option value="" disabled selected> --- โปรดเลือก สถานพยาบาล
                                                        หรือ ศูนย์การแพทย์ --- </option>
                                                </select>
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="departments"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">แผนก
                                                    *</label>
                                                <select disabled id="departments" name="departments"
                                                    autocomplete="departments"
                                                    class="select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option value="" disabled selected> --- แผนก หรือ หน่วยงาน ---
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-span-6 sm:col-span-6">
                                                <label for="notes_messages"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">หมายเหตุ</label>
                                                <textarea id="notes_messages" name="notes_messages" rows="4"
                                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="ข้อความหมายเหตุ..." value="" ></textarea>
                                            </div>
                                            <div class="col-span-6 sm:col-span-6">
                                                <hr class="mt-2">
                                            </div>
                                            <div class="col-span-6 sm:col-span-1">
                                                <label for="item_name"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">Item name</label>
                                                <select disabled autocomplete="" id="item_name" name="item_name"
                                                    class="select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option value="" disabled selected>--- โปรดเลือกอุปการณ์  ---</option>
                                                </select>
                                            </div>

                                            <div class="col-span-6 sm:col-span-1">
                                                <label for="request_reason"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">Request
                                                    reason</label>
                                                <input disabled type="text" id="request_reason" name="request_reason"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    value="" disabled>
                                            </div>

                                            <div class="col-span-6 sm:col-span-1">
                                                <label for="Situation"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">Situation</label>
                                                <select disabled autocomplete="" id="Situation" name="Situation"
                                                    class="select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option value="" disabled selected>--- โปรดเลือก  ---</option>
                                                </select>
                                            </div>

                                            <div class="col-span-6 sm:col-span-1">
                                                <label for="qty"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">Qty.</label>
                                                <input disabled type="number" id="qty" name="qty"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="จำนวน" value="1" min="1" required>

                                                <label for="total_price"
                                                    class="mt-4 block text-base font-medium dark:bg-darker dark:text-light mb-2">Total
                                                    Price</label>
                                                <input type="number" id="total_price" name="total_price"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    value="0" disabled>
                                            </div>

                                            <div class="col-span-6 sm:col-span-2">
                                                <figure class="max-w-lg">
                                                    <img class="max-w-full h-auto rounded-md"
                                                        src="{{ asset('assets/image/image_preview.jpg') }}"
                                                        alt="image description">
                                                </figure>
                                            </div>
                                        </div>

                                        <hr class="mt-2">
                                        <div class="px-4 py-3 dark:bg-darker dark:text-light text-right sm:px-6">
                                            <button disabled
                                                class="px-4 mr-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                                <i class="fa-solid fa-camera fa-xl mr-2"></i>
                                                แนบรูปภาพ
                                            </button>

                                            <button id="add_item" disabled
                                                class="px-4 mr-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                                <i class="fa-solid fa-plus fa-xl mr-2"></i>
                                                เพิ่มรายการอุปกรณ์
                                            </button>
                                        </div>

                                        <div hidden id="div_tablefrom" class="overflow-x-auto text-base rounded-lg mt-4 relative">
                                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                <thead
                                                    class="text-sm text-gray-700  bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                    <tr>
                                                        <th scope="col" class="py-3 px-6">
                                                            Item Name
                                                        </th>
                                                        <th scope="col" class="py-3 px-6">
                                                            Request Reason
                                                        </th>
                                                        <th scope="col" class="py-3 px-6">
                                                            Situation
                                                        </th>
                                                        <th scope="col" class="py-3 px-6">
                                                            Qty.
                                                        </th>
                                                        <th scope="col" class="py-3 px-6">
                                                            Total Amount
                                                        </th>
                                                        <th scope="col" class="py-3 px-6">
                                                            Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_data" class="align-top">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div hidden id="div_btn_save"
                                        class="px-4 py-3 bg-white dark:bg-darker dark:text-light text-right sm:px-6">
                                        <button type="button" id="create_oders_save"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-md text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            สร้างใบออเดอร์
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
