{{-- Modal Show Images --}}
{{-- <div id="modal_show_QR_code"
    class="z-50 hidden fixed top-0 left-0 w-screen h-screen bg-black/90 flex justify-center items-center overflow-auto">

    <!-- The close button -->
    <a class="fixed z-50 top-6 right-8 text-white text-5xl font-bold cursor-pointer text-orange-500"
        id="Close_show_image">&times;</a>

    <!-- A big image will be displayed here -->
    <div id="qr-reader" style="width:500px"></div>
    <div id="qr-reader-results"></div>
</div> --}}


<!-- Main modal -->
<div class="fixed z-10 inset-0 w-full invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true" id="modal_show_QR_code">
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
                            แสกน QR Code <span id="textIdwashing"></span>
                        </h3>
                    </div>
                </div>

                <button id="modal_QR_code_close" type="button" style="position: fixed; top: 1rem; right: 1rem;"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
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
                                <div id="qr-reader" style="width:500px"></div>
                                <div id="qr-reader-results"></div>
                            </div>

                        </div>
                    </div>
                </p>
            </div>

            <div class="bg-white dark:bg-darker dark:text-light px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="modal_QR_code_close"
                    class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    ปิด
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;

        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                // console.log(`Scan result ${decodedText}`, decodedResult);
                check_order(decodedText)
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250,
                rememberLastUsedCamera: false
            });
        html5QrcodeScanner.render(onScanSuccess);

        $('#scan_qr_order').on('click', function () {
            html5QrcodeScanner.render(onScanSuccess);
            $('#modal_show_QR_code').removeClass('invisible');
        })

        $(document).on('click', '#modal_QR_code_close', function () {
            html5QrcodeScanner.clear();
            $('#modal_show_QR_code').addClass('invisible');
        })

        function check_order(order_id) {

            html5QrcodeScanner.clear();

            $.ajax({
                type: "POST",
                url: `/QR_code/Check_order`,
                data: {
                    order_id: order_id
                },
                dataType: "json",
                success: function (response) {
                    // $(".background_loading").css("display", "none");
                    if (response.code != '0000') {
                        alert('ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง' + ' (' +
                            response.message + ')')
                    } else {
                        let list_url = [{
                                state: "On Process",
                                url: "Onprocess",
                            },
                            {
                                state: "Stock",
                                url: "stock",
                            },
                            {
                                state: "Deliver",
                                url: "stock",
                            }
                        ]

                        let _Item = list_url.filter(v => v.state == response.orders.StatusOrder);

                        if (_Item.length == 0) {
                            window.location = `{{ url('orders') }}`;
                        } else {
                            let url_ = _Item[0]['url'] ? _Item[0]['url'] : null;
                            let get_order_id = response.orders.Order_id;

                            window.location = `{{ url('${url_}/${get_order_id}') }}`;
                        }

                        console.log(response.orders.Order_id)
                    }
                }
            });
        }

    })

</script>
