$(document).ready(function () {
    // <button type="button" value="${element.Equipment_id}"
    //     class="delete_equipments mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
    //     <i class="fa-solid fa-trash fa-xl mx-auto"></i>
    // </button>
    // function set table
    function setTable(data) {
        $("#equipmentsTable").empty();
        data.forEach((element) => {
            const rowHtml = `
            <tr>
                <td class="border-dashed border-t border-gray-200 action">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        <button type="button" value="${element.Equipment_id}"
                            class="openEditModal mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-regular fa-pen-to-square fa-xl mx-auto"></i>
                        </button>
                        <button type="button" value="${element.Equipment_id}"
                            class="openImageModal mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-solid fa-image fa-xl mx-auto"></i>
                        </button>
                        <button type="button" data-value="${element.Activate == 'A' ? 'I': 'A'}" value="${element.Equipment_id}"
                            class="toggle_activate_equipments mr-1 w-10 h-10 px-2 py-2 text-base text-white ${element.Activate == 'A' ? 'bg-success hover:bg-success-dark focus:ring-success' : 'bg-warning hover:bg-warning-dark focus:ring-warning'} rounded-md inline-flex items-center focus:outline-none focus:ring  focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            ${element.Activate == 'A' ? '<i class="fa-solid fa-check fa-xl mx-auto"></i>' : '<i class="fa-solid fa-x fa-xl mx-auto"></i>'}
                        </button>
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 Order_id">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Name}
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 Order_id">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${Number(element.Price).toFixed(2)} บาท
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 Order_id">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Process.toUpperCase()}
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 Order_id">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Expire} วัน
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 Order_id">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Descriptions ? element.Descriptions : '-'}
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 Order_id">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Item_Type ? element.Item_Type : '-'}
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 Order_id">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Activate == 'A' ? 'ใช้งาน' : 'ปิดใช้งาน'}
                    </span>
                </td>
            </tr>
            `;
            $("#equipmentsTable").append(rowHtml);
        });
        intifuntion();
    }

    // function to get all equipments
    function getEquipments(page = 1, txt_search = "") {
        $.ajax({
            type: "GET",
            url: "/settings/equipments/getlistequipments",
            data: {
                page: page,
                txt_search: txt_search,
            },
            dataType: "json",
            success: function (response) {
                // console.log(response.equipments.data);
                setTable(response.equipments.data);
                $("#txt_firstItem").text(response.equipments.from);
                $("#txt_lastItem").text(response.equipments.to);
                $("#txt_total").text(response.equipments.total);
                $("#lastPage").text(response.equipments.last_page);
                $("#page_input").val(response.equipments.current_page);

                const btn_first_page =
                    document.querySelector(".btn_first_page");
                btn_first_page.setAttribute(
                    "url_data",
                    response.equipments.first_page_url
                );

                const btn_prev_page = document.querySelector(".btn_prev_page");
                btn_prev_page.setAttribute(
                    "url_data",
                    response.equipments.prev_page_url
                );

                const btn_next_page = document.querySelector(".btn_next_page");
                btn_next_page.setAttribute(
                    "url_data",
                    response.equipments.next_page_url
                );

                const btn_last_page = document.querySelector(".btn_last_page");
                btn_last_page.setAttribute(
                    "url_data",
                    response.equipments.last_page_url
                );
            },
        });
    }

    // initial call to get all equipments
    getEquipments();

    function getParameterByName(name, url) {
        name = name.replace(/[\[\]]/g, "\\$&");
        let regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return "";
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
    
    $(document).on("click", "#select_page", function () {
        let type_btn = $(this).attr("type_btn");
        let url_data = $(this).attr("url_data");

        let page = getParameterByName("page", url_data);

        let txt_search = $("#search").val();

        getEquipments(page, txt_search);
    });

    $("#search").keydown(function (e) {
        let txt_search = $("#search").val();
        getEquipments(null, txt_search);
    });


    $('.openAddModal').on('click', function(e){
        $('#interestModal').removeClass('invisible');
    });
    $('.closeModal').on('click', function(e){
        $('#interestModal').addClass('invisible');
    });

    $('#SUD_Check').click(function(){
        if($(this).prop("checked") == true){
            $('#input_div_limit').show();
        }
        else if($(this).prop("checked") == false){
            $('#input_div_limit').hide();
        }
    });

    $('#edit_SUD_Check').click(function(){
        if($(this).prop("checked") == true){
            $('#edit_input_div_limit').show();
        }
        else if($(this).prop("checked") == false){
            $('#edit_input_div_limit').hide();
        }
    });

    $('#add_equip').click(function (e) { 
        e.preventDefault();
        const equip_name = $('#equip_name').val();
        const price = $('#price').val();
        const expire = $('#expire').val();
        const process = $("#process option:selected").val();
        const item_type = $('#item_type').val();
        const descriptions = $('#descriptions').val();
        const sud_checked = $('#SUD_Check').not(this).prop('checked', this.checked);
        const limit = $('#limit').val();
        
        if (process == '0') {
            alert('กรุณาเลือกกระบวนการ');
            return false;
        }

        if (sud_checked.is(":checked")) {
            if (limit <= 0) {
                alert('กรุณากำหนดจำนวนรอบการใช้งานสูงสุด');
                return false;
            }
            sud = 1;
        }else{
            sud = 0;
        }

        $.ajax({
            type: "POST",
            url: "/settings/equipments/createequipments",
            data: {
                equipment_name: equip_name,
                equipment_price: price,
                equipment_expire: expire,
                equipment_process: process,
                equipment_item_type: item_type,
                equipment_descriptions: descriptions,
                equipment_sud: sud,
                equipment_limit: limit
            },
            dataType: "json",
            success: function (response) {
                $('#interestModal').addClass('invisible');
                $('#equip_name').val('');
                $('#price').val('0.00');
                $('#expire').val(0);
                $("#process").val(0).change();
                $('#item_type').val('');
                $('#descriptions').val('');
                $('#SUD_Check').prop('checked', false);
                $('#limit').val('');
                $('#input_div_limit').hide();

                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getEquipments(page, txt_search);
            }
        });
    });

    // funtion active code 
    function intifuntion(){
        $(".delete_equipments").click(function (e) { 
            e.preventDefault();
            let equip_id = $(this).val();
            if (confirm('are you sure to delete this equipment ?')) {
                $.ajax({
                    type: "POST",
                    url: "/settings/equipments/deleteequipments",
                    data: {
                        equipment_id: equip_id
                    },
                    dataType: "json",
                    success: function (response) {
                        let page = $('#page_input').val();
                        let txt_search = $("#search").val();
                        getEquipments(page, txt_search);
                    }
                });
            }
        });

        $(".toggle_activate_equipments").click(function (e) {
            e.preventDefault();
            let equip_id = $(this).val();
            let activate = $(this).attr('data-value');
            $.ajax({
                type: "POST",
                url: "/settings/equipments/activateequipments",
                data: {
                    equipment_id: equip_id,
                    equipment_activate: activate
                },
                dataType: "json",
                success: function (response) {
                    let page = $('#page_input').val();
                    let txt_search = $("#search").val();
                    // console.log(page);
                    getEquipments(page, txt_search);
                }
            });
        });

        $('.openEditModal').on('click', function(e){
            let equip_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "/settings/equipments/getequipmentsdetail",
                data: {
                    equipment_id: equip_id
                },
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    $('#edit_equip_name').attr('data-value', equip_id);
                    $('#edit_equip_name').val(response.equipment.Name);
                    $('#edit_price').val(response.equipment.Price);
                    $('#edit_expire').val(response.equipment.Expire);
                    $('#edit_item_type').val(response.equipment.Item_Type);
                    $('#edit_descriptions').val(response.equipment.Descriptions);
                    $("#edit_process").val(response.equipment.Process).change();
                    $('#editModal').removeClass('invisible');
                    if (response.equipment.SUD == 1) {
                        $('#edit_SUD_Check').prop('checked', true);
                        $('#edit_input_div_limit').show();
                        $('#edit_limit').val(response.equipment.SUD_Limit);
                    }else{
                        $('#edit_SUD_Check').prop('checked', false);
                        $('#edit_input_div_limit').hide();
                        $('#edit_limit').val('');
                    }
                }
            });

        });

        $('.closeModal').on('click', function(e){
            $('#editModal').addClass('invisible');
            $('#modal_images').addClass('invisible');
        });


        $('.openImageModal').click(function (e) { 
            e.preventDefault();
            let equip_id = $(this).val();
            // console.log(equip_id);
            $('#label_tag').attr('data-value', equip_id);
            showImages();
            $('#modal_images').removeClass('invisible');
        });
    }

    $('#save_edit_equip').click(function (e) {
        e.preventDefault();
        let equip_id = $('#edit_equip_name').attr('data-value');
        let edit_equip_name = $('#edit_equip_name').val();
        let edit_price = $('#edit_price').val();
        let edit_expire = $('#edit_expire').val();
        let edit_process = $("#edit_process option:selected").val();
        let edit_item_type = $('#edit_item_type').val();
        let edit_descriptions = $('#edit_descriptions').val();
        let edit_sud_checked = $('#edit_SUD_Check').not(this).prop('checked', this.checked);
        let edit_limit = $('#edit_limit').val();

        if (edit_process == '0') {
            alert('กรุณาเลือกกระบวนการ');
            return false;
        }

        let edit_sud = false;
        if (edit_sud_checked.is(":checked")) {
            if (edit_limit <= 0) {
                alert('กรุณากำหนดจำนวนรอบการใช้งานสูงสุด');
                return false;
            }
            edit_sud = 1;
        }else{
            edit_sud = 0;
        }

        $.ajax({
            type: "POST",
            url: "/settings/equipments/updateequipments",
            data: {
                equipment_id: equip_id,
                equipment_name: edit_equip_name,
                equipment_price: edit_price,
                equipment_expire: edit_expire,
                equipment_process: edit_process,
                equipment_item_type: edit_item_type,
                equipment_descriptions: edit_descriptions,
                equipment_sud: edit_sud,
                equipment_limit: edit_limit
            },
            dataType: "json",
            success: function (response) {
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getEquipments(page, txt_search);
                $('#editModal').addClass('invisible');
            }
        });
    });

    $('#page_input').keydown(function (e) {
        if (e.keyCode == 13) {
            let page = $('#page_input').val();
            let txt_search = $("#search").val();
            getEquipments(page, txt_search);
        }
    });

    $('.dropzone-file').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        console.log('dragenter');
    });

    $('.dropzone-file').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        console.log('dragover');
    });

    function showImages(){
        let equip_id = $('#label_tag').attr('data-value');
        $.ajax({
            type: "GET",
            url: "/settings/equipments/getequipmentsimages",
            data: {
                equipment_id: equip_id
            },
            dataType: "json",
            success: function (response) {
                $('#list_img').empty();
                response.forEach(element => {
                    const html = `
                        <a class="block p-1 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                            <div class="relative" height="40px" width="auto">
                                <img class="w-full" style="height: 15rem; object-fit: contain;" src="/assets/image/equipments/${element.Image_path}" alt="dummy-image">
                                <button src-data="${element.Image_path}" class="btn_View_img absolute top-1 right-1 bg-green-500 text-white p-2 rounded hover:bg-green-800">
                                    View
                                </button>
                                <button data-id_img="${element.Image_id}" data-equipmentid="${element.Equipment_id}" data-image="${element.Image_path}" class="btn_remove_img absolute bottom-1 right-1 bg-red-500 text-white p-2 rounded hover:bg-red-800">
                                    Remove
                                </button>
                            </div>
                        </a>
                    `;
                    $('#list_img').append(html);
                });
                loadedshow();
            }
        });
    }

    function loadedshow(){
        $('.btn_remove_img').click(function (e) { 
            e.preventDefault();
            let image_id = $(this).attr('data-id_img');
            let equipment_id = $(this).attr('data-equipmentid');
            let image_path = $(this).attr('data-image');
            $.ajax({
                type: "POST",
                url: "/settings/equipments/deleteimageequpment",
                data: {
                    image_id: image_id,
                    equipment_id: equipment_id,
                    image_path: image_path
                },
                dataType: "json",
                success: function (response) {
                    showImages();
                }
            });
        });

        $('.btn_View_img').click(function (e) {
            e.preventDefault();
            let src = $(this).attr('src-data');
            $('#modal_Fullimg_packing').attr('src', `/assets/image/equipments/${src}`);
            $('#modal_show_image_packing').removeClass('invisible');
        });
    
        $('#Close_show_image_packing').click(function (e) {
            e.preventDefault();
            $('#modal_show_image_packing').addClass('invisible');
        });
    }

    $('.dropzone-file').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();
        let files = e.originalEvent.dataTransfer.files;
        let imageType = /^image\//;
        if (files.length > 0) {
            if (!imageType.test(files[0].type)) {
                alert('กรุณาเลือกไฟล์รูปภาพ');
                return false;
            }
        }
        console.log(files);
        let equip_id = $('#label_tag').attr('data-value');
        let formData = new FormData();

        for (let i = 0; i < files.length; i++) {
            formData.append('file[]', files[i]);
        }
        formData.append('equipment_id', equip_id);

        sendformData(formData);
    });

    function sendformData(formData){
        $.ajax({
            xhr: function () {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        let percentComplete = e.loaded / e.total;
                        percentComplete = parseInt(percentComplete * 100);
                        percentDecimal = percentComplete * 100;
                        $('.percent_upload_bar').removeClass('invisible');
                        $('.percent_upload').width(`${percentDecimal}%`);
                        console.log(percentComplete);
                        if (percentComplete === 100) {
                            console.log('upload completed');
                            $('.percent_upload_bar').addClass('invisible');
                            $('.percent_upload').width(`100%`);
                        }
                    }
                }, false);
                return xhr;
            },
            type: "POST",
            url: "/settings/equipments/imagesuploadequpment",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            beforeSend: function () {
                console.log('uploading...');
            },
            error: function (response) {
                console.log('error');
            },
            success: function (response) {
                // console.log(response);
                showImages();
            }
        });
    }

    $('#dropzone-file').change(function (e) { 
        e.preventDefault();
        let files = e.target.files;
        let imageType = /^image\//;
        if (files.length > 0) {
            if (!imageType.test(files[0].type)) {
                alert('กรุณาเลือกไฟล์รูปภาพ');
                return false;
            }
        }
        console.log(files);
        let equip_id = $('#label_tag').attr('data-value');
        let formData = new FormData();

        for (let i = 0; i < files.length; i++) {
            formData.append('file[]', files[i]);
        }
        formData.append('equipment_id', equip_id);
        sendformData(formData);
    });
});
