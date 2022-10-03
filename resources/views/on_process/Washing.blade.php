<section class="overflow-x-auto mt-8 mb-8" id="washing_state">

    <p class="text-2xl text-gray-900 dark:text-white" style="color: #ff8026;">Process Washing
    </p>

    <div class="mt-5">
        <form>
            <div class="grid gap-6 mb-6 lg:grid-cols-3 md:grid-cols-2">
                <div>
                    <label for="machineswashing"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือกเครื่อง
                        Washing</label>
                    <select id="option_machineswashing" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        {{-- <option>Washing 01</option>
                        <option>Washing 02</option>
                        <option>Washing 03</option> --}}
                    </select>
                </div>
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        Cycle </label>
                    <input type="text" id="last_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Doe" value="3" disabled>
                </div>
            </div>

            <div class="grid gap-6 mb-6 lg:grid-cols-3 md:grid-cols-3">
                <div>
                    <label for="item_washing" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือก
                        Item</label>
                    <select id="option_item_washing"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        {{-- <option>Item 01</option>
                        <option>Item 02</option>
                        <option>Item 03</option> --}}
                    </select>
                </div>
                <div>
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เพิ่ม
                        Item</label>
                    <button type="button" id="item_add_washing"
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

            <div class="overflow-x-auto">
                <table class="mt-3 w-full text-sm text-left text-gray-500 dark:text-gray-400" id="tb_select">
                    <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                <input type="checkbox" id="washing_all_check"
                                    class="w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" />
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Action
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Washing_id
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Item_ID
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Machines
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Cycle
                            </th>
                            <th scope="col" class="py-3 px-6">
                                QTY
                            </th>
                            <th scope="col" class="py-3 px-6">
                                PassStatus
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Create_at
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tb_list_washing">
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-3 px-6">
                                <input type="checkbox"
                                    class="w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" />
                            </td>
                            <td class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                                    <i class="fa-regular fa-file-image fa-lg fill-white icon_center"></i>
                                </button>
                            </td>
                            <td scope="col" class="py-3 px-6">
                                Washing_id 001
                            </td>
                            <td scope="col" class="py-3 px-6">
                                Item_ID 001
                            </td>
                            <td scope="col" class="py-3 px-6">
                                Machines 001
                            </td>
                            <td scope="col" class="py-3 px-6">
                                Cycle 001
                            </td>
                            <td scope="col" class="py-3 px-6">
                                QTY 001
                            </td>
                            <td scope="col" class="py-3 px-6">
                                PassStatus 001
                            </td>
                            <td scope="col" class="py-3 px-6">
                                Create_at 001
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <button type="button" id="btn_save_washing"
                    class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">บันทึก</button>
            </div>

        </form>
    </div>

</section>

