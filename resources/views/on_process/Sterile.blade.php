<section class="overflow-x-auto mt-10 mb-8" id="sterile_state">

    <p class="text-2xl text-gray-900 dark:text-white" style="color: #00ffc0;">Process sterile
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
        <table class="mt-3 w-full text-sm text-left text-gray-500 dark:text-gray-400" id="tb_select">
            <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6 text-center">
                        <input type="checkbox" id="all_check_sterile"
                            class="w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" />
                        <br>
                        <label class="">เสร็จ</label>
                    </th>
                    <th scope="col" class="py-3 px-6">
                        sterile ID
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Item ID
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Item Name
                    </th>
                    <th scope="col" class="py-3 px-6">
                        QTY
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Exp Date
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Machine
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Program
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Cycle
                    </th>
                    <th scope="col" class="py-3 px-6">
                        {{-- Status-sterile --}}
                        Status Process
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Note
                    </th>
                </tr>
            </thead>
            <tbody id="tb_list_sterile">
                {{-- <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-4 px-6">
                        <input type="checkbox"
                            class="w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" />
                    </td>
                    <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <button target="_blank"
                            class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-solid fa-print fa-lg fill-white icon_center"></i>
                        </button>

                        <button
                            class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-success inline-flex items-center hover:bg-success-dark focus:outline-none focus:ring focus:ring-success focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-solid fa-camera fa-lg fill-white icon_center"></i>
                        </button>

                        <button
                            class="text-center w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-regular fa-file-image fa-lg  fill-white icon_center"></i>
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
                </tr> --}}
            </tbody>
        </table>
    </div>
    <div class="text-center mt-3">
        <button type="button" id="btn_save_sterile"
            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Finish
        </button>
    </div>

</section>
<script>
    $(document).ready(function() {

    })
</script>
