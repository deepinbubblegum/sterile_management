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
<script>
    $(document).ready(function() {

    })
</script>
