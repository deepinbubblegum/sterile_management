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
                    <label for="option_Process_sterile"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Process
                        Sterile</label>
                    <select id="option_Process_sterile"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        {{-- <option>Sterile 01</option>
                        <option>Sterile 02</option>
                        <option>Sterile 03</option> --}}
                    </select>
                </div>
                <div>
                    <label for="option_machine_sterile"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือกเครื่อง
                        Sterile</label>
                    <select id="option_machine_sterile"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        {{-- <option>Sterile 01</option>
                        <option>Sterile 02</option>
                        <option>Sterile 03</option> --}}
                    </select>
                </div>
                <div>
                    <label for="option_program_sterile"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เลือกโปรแกรม</label>
                    <select id="option_program_sterile"
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
                <label for="notes_packing_messages"
                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">หมายเหตุ</label>
                <textarea id="notes_packing_messages" name="notes_messages" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="ข้อความหมายเหตุ..." value=""></textarea>
            </div>

            <div class="grid gap-6 mb-6 lg:grid-cols-3 md:grid-cols-3 mt-3">
                <div>
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">เพิ่ม
                        Item</label>
                    <button type="button" id="item_add_packing"
                        class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">เพิ่ม</button>
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
                            {{-- <th scope="col" class="py-3 px-6 text-center">
                                <input type="checkbox" id="all_check_Packing"
                                    class="w-6 h-6 rounded focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light" />
                                <label class="">QRcode</label>
                            </th> --}}
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
                            {{-- <th scope="col" class="py-3 px-6">
                                PassStatus
                            </th> --}}
                            <th scope="col" class="py-3 px-6">
                                QC by
                            </th>
                            <th scope="col" class="py-3 px-6">
                                QTY
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Exp Date
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Note
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Create
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Delete
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tb_list_packing">
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
                <div class="lg:grid-cols-1 md:grid-cols-1 mt-1">
                    <div>
                        {{-- <a type="button" id="btn_pdf_packing" href="/Onprocess/pdf/{{ $oder_id }}" target="_blank"
                            class="my-2 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg  px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Print QR Code
                        </a> --}}

                        <button type="button" id="btn_save_packing"
                            class="my-2 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg  px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            บันทึก
                        </button>
                    </div>
                </div>
            </div>

        </form>


        <!-- Main modal -->
        <div class="fixed z-10 inset-0 w-full invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true" id="Modal_Img_Packing">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
                <div
                    class="inline-block align-bottom bg-white dark:bg-darker dark:text-light rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-top sm:max-w-2xl w-full">
                    <div class="bg-white dark:bg-darker dark:text-light px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                {{-- <i class="fa-regular fa-building text-gray-700"></i> --}}
                                <i class="fa-regular fa-file-image fa-lg  text-gray-700 fill-white"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg mt-2 leading-6 font-medium bg-white dark:bg-darker dark:text-light"
                                    id="modal-title">
                                    เพิ่มข้อมูลรูปภาพ <span id="textIdpacking"></span>
                                </h3>
                            </div>
                        </div>

                        <button id="modal_Packing_close" type="button" style="position: fixed; top: 1rem; right: 1rem;"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="Modal_Img_Packing">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>

                        <p class="mt-4">
                        <div class="text-sm dark:text-light">

                            <div class="mt-3 mb-3">
                                <div class="flex justify-center items-center w-full">
                                    <label for="Input_Image_packing"
                                        class="flex flex-col justify-center items-center w-full h-auto bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                        <div class="flex flex-col justify-center items-center pt-5 pb-6">
                                            <svg aria-hidden="true" class="mb-3 w-10 h-10 text-gray-400"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                </path>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                    class="font-semibold">Click to upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF</p>
                                        </div>
                                        <input id="Input_Image_packing" type="file" class="hidden" accept="image/png, image/gif, image/jpeg" />
                                        <input id="id_packing_modal" type="text" class="hidden" />
                                    </label>
                                </div>

                                <div class="flex p-2 space-x-4 flex justify-center">
                                    <img id="packing_img_preview" src="" alt="" style="object-fit:contain !important;">
                                </div>

                                <div class="flex p-2 space-x-4 flex justify-center">
                                    <button type="button" id="add_img_pakcing"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary hover:bg-primary-dark text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        เพื่มรูป
                                    </button>
                                </div>

                            </div>

                            <hr class="mb-3">

                            <div class="grid gap-6 mb-6 lg:grid-cols-2 md:grid-cols-2" id="list_img_packing">

                                {{-- <div class="relative" height="40px" width="auto">
                                    <img class="w-full" src="{{ asset('assets/image/S__40607792.jpg') }}"
                                        alt="dummy-image">
                                    <button
                                        class="absolute top-1 right-1 bg-red-500 text-white p-2 rounded hover:bg-red-800">
                                        remove </button>
                                </div> --}}

                            </div>

                        </div>
                        </p>
                    </div>

                    <div class="bg-white dark:bg-darker dark:text-light px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="modal_Packing_close"
                            class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            ปิด
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>


<script>
    $(document).ready(function() {

    })
</script>
