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

                        {{-- State washing--}}
                        <section class="overflow-x-auto mt-8 mb-8" id="washing_state">

                            <p class="text-2xl text-gray-900 dark:text-white" style="color: lime;">Process Washing</p>

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

                                    <div class="grid gap-6 mb-6 lg:grid-cols-2 md:grid-cols-2">
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือกสถานะ Washing ของ Item</label>
                                            <select id="countries"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option>OnProcess</option>
                                                <option>Finish</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Update Status</label>
                                            <button type="button"
                                                class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Update</button>
                                        </div>
                                    </div>

                                    <table class="mt-3 w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="py-3 px-6">
                                                    Item ID
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    Item Name
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    machine
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    Status-Washing
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    QTY
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <th scope="row"
                                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    Item 001
                                                </th>
                                                <td class="py-4 px-6">
                                                    TestA
                                                </td>
                                                <td class="py-4 px-6">
                                                    machine-01
                                                </td>
                                                <td class="py-4 px-6">
                                                    Success
                                                </td>
                                                <td class="py-4 px-6">
                                                    10
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <th scope="row"
                                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    Item 002
                                                </th>
                                                <td class="py-4 px-6">
                                                    TestB
                                                </td>
                                                <td class="py-4 px-6">
                                                    machine-01
                                                </td>
                                                <td class="py-4 px-6">
                                                    Success
                                                </td>
                                                <td class="py-4 px-6">
                                                    5
                                                </td>
                                            </tr>
                                            <tr class="bg-white dark:bg-gray-800">
                                                <th scope="row"
                                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    Item 003
                                                </th>
                                                <td class="py-4 px-6">
                                                    TestC
                                                </td>
                                                <td class="py-4 px-6">
                                                    machine-02
                                                </td>
                                                <td class="py-4 px-6">
                                                    Success
                                                </td>
                                                <td class="py-4 px-6">
                                                    1
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="text-center">
                                        <button type="button"
                                        class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">บันทึก</button>
                                    </div>

                                </form>
                            </div>

                        </section>

                        <hr>

                        {{-- State Packing--}}
                        <section class="overflow-x-auto mt-10 mb-8" id="Packing_state">

                            <p class="text-2xl text-gray-900 dark:text-white" style="color: #ffe800;">Process Packing</p>

                            <div class="grid gap-6 mb-6 lg:grid-cols-2 md:grid-cols-2">
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
                            </div>

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

                                    <div class="grid gap-6 mb-6 lg:grid-cols-4 md:grid-cols-4">
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
                                    </div>

                                    <button type="button"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">บันทึก</button>
                                </form>
                            </div>

                            <table class="mt-3 w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
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
                                        <th scope="row"
                                            class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                                        <th scope="row"
                                            class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                                            5
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </section>

                        <hr>

                        <section class="overflow-x-auto mt-10 mb-8" id="Sterlia_state">

                            <p class="text-2xl text-gray-900 dark:text-white" style="color: #00ffc0;">Process Sterlia</p>

                            <div class="grid gap-6 mb-6 lg:grid-cols-2 md:grid-cols-2">
                                <div>
                                    <label for="countries"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือก Item เพื่อ Update Status</label>
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
                            </div>

                            <table class="mt-3 w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
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
                                            Status-Sterlia
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            QTY
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                                        <th scope="row"
                                            class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                                            5
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

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
    });
</script>

</html>
