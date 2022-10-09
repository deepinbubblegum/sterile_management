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


            <div class="grid gap-6 mb-6 lg:grid-cols-3 md:grid-cols-3">
                <div>
                    <label for="item_packing"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือก
                        Item</label>
                    <select id="item_packing"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        {{-- <option>Item 01</option>
                        <option>Item 02</option>
                        <option>Item 03</option> --}}
                    </select>
                </div>
            </div>


            <div class="grid gap-6 mb-6 lg:grid-cols-3 md:grid-cols-3">
                <div>
                    <label for="option_Process_sterlie"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Process
                        Sterile</label>
                    <select id="option_Process_sterlie"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        {{-- <option>Sterile 01</option>
                        <option>Sterile 02</option>
                        <option>Sterile 03</option> --}}
                    </select>
                </div>
                <div>
                    <label for="option_machine_sterlie"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือกเครื่อง
                        Sterile</label>
                    <select id="option_machine_sterlie"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        {{-- <option>Sterile 01</option>
                        <option>Sterile 02</option>
                        <option>Sterile 03</option> --}}
                    </select>
                </div>
                <div>
                    <label for="option_program_sterlie"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือกโปรแกรม</label>
                    <select id="option_program_sterlie"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        {{-- <option>Program 01</option>
                        <option>Program 02</option>
                        <option>Program 03</option> --}}
                    </select>
                </div>
            </div>

            <div class="grid gap-6 mb-6 lg:grid-cols-3 md:grid-cols-3">
                <div>
                    <label for="option_userQC"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">ผู้ตรวจสอบ</label>
                    <select id="option_userQC"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        {{-- <option>user 01</option>
                        <option>user 02</option>
                        <option>user 03</option> --}}
                    </select>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-6">
                <label for="notes_messages"
                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">หมายเหตุ</label>
                <textarea id="Packing_notes_messages" name="notes_messages" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="ข้อความหมายเหตุ..." value=""></textarea>
            </div>

            <div class="grid gap-6 mb-6 lg:grid-cols-3 md:grid-cols-3 mt-3">
                <div>
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เพิ่ม
                        Item</label>
                    <button type="button" id="item_add_packing"
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
                <table class="mt-3 w-full text-sm text-left text-gray-500 dark:text-gray-400" id="tb_select">
                    <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                <input type="checkbox" id="all_check_Packing"
                                    class="w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" />
                                <label class="">เสร็จ</label>
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Action
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Packing ID
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
                                Cycle
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Status-Packing
                            </th>
                            <th scope="col" class="py-3 px-6">
                                QC_by
                            </th>
                            <th scope="col" class="py-3 px-6">
                                QTY
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Exp_date
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Create_at
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tb_list_packing">
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
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
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <button type="button" id="btn_save_packing"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">บันทึก
                </button>
            </div>

        </form>
    </div>

</section>


<script>
    $(document).ready(function() {

    })
</script>
