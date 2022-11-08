$(document).ready(function () {
    var path = window.location.pathname;
    var order_id = path.split("/").pop();
    var delete_data = [];
    var delete_images = [];
    var delete_images_id = [];
    $(".select2").select2({});
    var formDataImage = new FormData();
    //Functions
    // function getcustomers() {
    function getcustomers() {
        $.ajax({
            type: "GET",
            url: "/orders/create/getcustomers",
            dataType: "json",
            success: function (response) {
                if (response.length === 1) {
                    response.forEach((element) => {
                        $("#customers").append(
                            `<option selected value="${element.Customer_id}">${element.Customer_name}</option>`
                        );
                        getdepartment(element.Customer_id);
                    });
                } else if (response.length > 1) {
                    response.forEach((element) => {
                        $("#customers").append(
                            `<option value="${element.Customer_id}">${element.Customer_name}</option>`
                        );
                    });
                }
            },
        });
    }

    // function getdepartment()
    function getdepartment(Customer_id) {
        $.ajax({
            type: "GET",
            url: "/orders/create/getdepartments",
            data: {
                Customer_id: Customer_id,
            },
            dataType: "json",
            success: function (response) {
                // console.log(response.length);
                // response.length;
                if (response.length > 0) {
                    $("#departments").prop("disabled", false);
                    $("#departments").empty();
                    $("#departments").append(
                        `<option value="" disabled selected> --- แผนก หรือ หน่วยงาน --- </option>`
                    );
                    response.forEach((element) => {
                        $("#departments").append(
                            `<option value="${element.Department_id}">${element.Department_name}</option>`
                        );
                    });
                } else {
                    $("#departments").prop("disabled", true);
                    $("#departments").empty();
                    $("#departments").append(
                        `<option value="" disabled selected>--- ไม่พบข้อมูล แผนก ภายใต้ สถานพยาบาล หรือ ศูนย์การแพทย์ นี้  ---</option>`
                    );
                }

                // loadset
                getOrderItemsList();
            },
        });
    }

    // function getequipments()
    function getequipments(Department_id) {
        $.ajax({
            type: "GET",
            url: "/orders/create/getequipments",
            data: {
                Department_id: Department_id,
            },
            dataType: "json",
            success: function (response) {
                // console.log(response);
                $("#item_name").prop("disabled", false);
                $("#item_name").empty();
                $("#item_name").append(
                    `<option value="" disabled selected>--- โปรดเลือกอุปการณ์  ---</option>`
                );
                response.forEach((element) => {
                    $("#item_name").append(
                        `<option data-value='{"Equipment_id" : "${element.Equipment_id}", "Process" : "${element.Process}", "Name" : "", "Situation_id": "", "Situation_name" : "", "qty" : "", "Price" : ${element.Price} }' data-name='${element.Name}' >${element.Name}</option>`
                    );
                });
            },
        });
    }

    function getsituations(params) {
        $.ajax({
            type: "GET",
            url: "/orders/create/getsituations",
            dataType: "json",
            success: function (response) {
                // console.log(response);

                $("#Situation").empty();
                $("#Situation").append(
                    `<option value="false" disabled selected>--- โปรดเลือก  ---</option>`
                );
                response.forEach((element) => {
                    $("#Situation").append(
                        `<option value="${element.Situation_id}">${element.Situation_name}</option>`
                    );
                });
            },
        });
    }

    // function EditOrders()
    function EditOrders(notes_messages, items, customers_id, departments_id, delete_data) {
        var form = new FormData();
        formDataImage.forEach((value, key) => {
            form.append('file[]', value);
        });
        form.append("notes_messages", notes_messages);
        form.append("items", JSON.stringify(items));
        form.append("customers_id", customers_id);
        form.append("departments_id", departments_id);
        form.append("order_id", order_id);
        form.append("delete_data", JSON.stringify(delete_data));
        form.append("delete_images", JSON.stringify(delete_images));
        form.append("delete_images_id", JSON.stringify(delete_images_id));
        $.ajax({
            type: "POST",
            url: "/orders/edit/editorder",
            data: form,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                console.log(response);
                if (response == true) {
                    window.location.href="/orders";
                }else{
                    alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                    window.location.href="/orders/create";
                }
            }
        });
    }

    // function addtoTable()
    function addtoTable(val) {
        html_txt = `<tr class="row_data bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td scope="row"
                            class="py-4 px-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <input type="text" name="Equipment_id"
                            class="${val.Equipment_id} bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="" data-value="${val.Equipment_id}" data-item_id="null" disabled>
                        </td>
                        <td class="py-4 px-1">
                        <input type="text" name="Process" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="${val.Process}" disabled>
                        </td>
                        <td class="py-4 px-1">
                        <select id="countries" class="Situation_set bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option ${val.Situation_id == 'STT-0001' ? 'selected':''} value="STT-0001">Sterlie</option>
                            <option ${val.Situation_id == 'STT-0002' ? 'selected':''} value="STT-0002">Re-Sterlie</option>
                            <option ${val.Situation_id == 'STT-0003' ? 'selected':''} value="STT-0003">Claim</option>>
                            <option ${val.Situation_id == 'STT-0004' ? 'selected':''} value="STT-0004">Borrow</option>
                            <option ${val.Situation_id == 'STT-0005' ? 'selected':''} value="STT-0005">Damage</option>
                            <option ${val.Situation_id == 'STT-0006' ? 'selected':''} value="STT-0006">Loss</option>
                        </select>
                        <td class="py-4 px-1">
                        <input type="number" name="qty"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="จำนวน" value="${val.qty}" disabled>
                        </td>
                        <td class="py-4 px-1">
                        <input type="number"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="${val.Price * val.qty}" disabled>
                        </td>
                        <td class="py-4 px-1 text-center">
                            <button type="button" data-item_id="null"
                                class="delete-row mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-warning inline-flex items-center hover:bg-warning-dark focus:outline-none focus:ring focus:ring-warning focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-solid fa-xmark fa-2xl mx-auto"></i>
                            </button>
                        </td>
                    </tr>`;
        $("table tbody").prepend(html_txt);
        $("." + val.Equipment_id).val(val.Name);
    }

    function setItemLoaded(Items){
        console.log(Items);
        Items.forEach((element) => {
            html_txt =`
                <tr class="row_data bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td scope="row"
                        class="py-4 px-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <input type="text" name="Equipment_id"
                        class="${element.Equipment_id} bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="${element.Name}" data-value="${element.Equipment_id}" data-item_id="${element.Item_id}" disabled>
                    </td>
                    <td class="py-4 px-1">
                    <input type="text" name="Process" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="${element.Process}" disabled>
                    </td>
                    <td class="py-4 px-1">
                        <select id="countries" class="Situation_set bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option ${element.Situation_id == 'STT-0001' ? 'selected':''} value="STT-0001">Sterlie</option>
                            <option ${element.Situation_id == 'STT-0002' ? 'selected':''} value="STT-0002">Re-Sterlie</option>
                            <option ${element.Situation_id == 'STT-0003' ? 'selected':''} value="STT-0003">Claim</option>>
                            <option ${element.Situation_id == 'STT-0004' ? 'selected':''} value="STT-0004">Borrow</option>
                            <option ${element.Situation_id == 'STT-0005' ? 'selected':''} value="STT-0005">Damage</option>
                            <option ${element.Situation_id == 'STT-0006' ? 'selected':''} value="STT-0006">Loss</option>
                        </select>
                    </td>
                    <td class="py-4 px-1">
                    <input type="number" name="qty"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="จำนวน" value="${element.Quantity}">
                    </td>
                    <td class="py-4 px-1">
                    <input type="number"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="${element.Price * element.Quantity}" disabled>
                    </td>
                    <td class="py-4 px-1 text-center">
                        <button type="button" data-item_id="${element.Item_id}"
                            class="delete-row mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-warning inline-flex items-center hover:bg-warning-dark focus:outline-none focus:ring focus:ring-warning focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-solid fa-xmark fa-2xl mx-auto"></i>
                        </button>
                    </td>
                </tr>
            `;
            $("table tbody").prepend(html_txt);
            $("." + element.Equipment_id).val(element.Name);
            console.log(element.Situation_id);
        });
        $(".delete-row").click(function (e) {
            e.preventDefault();
            console.log("delete");
            var item_id = $(this).data("item_id");
            console.log(item_id);
            delete_data.push(item_id);
            console.log(delete_data);
            $(this).parents("tr").remove();
            check_disable();
        });
    }

    
    function getOrderItemsList() {
        $.ajax({
            type: "GET",
            url: "/orders/edit/getorder",
            data: {
                order_id: order_id,
            },
            dataType: "json",
            success: function (response) {
                $('#customers').val(response.Customer_id).change();
                $('#departments').val(response.Department_id).change();
                $('#departments').prop('disabled', true);
                getequipments(response.Department_id);
                $('#notes_messages').val(response.Notes_messages);

                $.ajax({
                    type: "GET",
                    url: "/orders/edit/getitemslist",
                    data: {
                        order_id: order_id,
                    },
                    dataType: "json",
                    success: function (response) {
                        $("#div_tablefrom").prop("hidden", false);
                        $("#div_btn_save").prop("hidden", false);
                        setItemLoaded(response);
                    }
                });
            }
        });
    }

    //Initialize function start here
    getcustomers();
    getsituations();

    $("#customers").on("select2:select", function (e) {
        customers_selected = e.params.data;

        getdepartment(customers_selected.id);

        $("#item_name").prop("disabled", true);
        $("#item_name").empty();
        $("#item_name").append(
            `<option value="" disabled selected>--- โปรดเลือกอุปการณ์  ---</option>`
        );
    });

    $("#departments").on("select2:selecting", function (e) {
        departments_selected = e.params.args.data;
        getequipments(departments_selected.id);
    });

    $("#item_name").change(function (e) {
        e.preventDefault();
        item_name_selected = $("#item_name option:selected").text();
        item_value_selected = $(this).find(":selected").data("value");
        item_value_selected.Name = item_name_selected;
        // console.log(item_value_selected);
        $("#request_reason").val(item_value_selected.Process);
        $("#Situation").prop("disabled", false);
        $("#qty").prop("disabled", false);
        // getdate situtation
        qty = $("#qty").val();
        Price = item_value_selected.Price * qty;
        $("#total_price").val(Price);

        $("#add_item").prop("disabled", false);
        $.ajax({
            type: "GET",
            url: "/orders/create/getequipimages",
            data: {
                equip_id: item_value_selected.Equipment_id,
            },
            dataType: "json",
            success: function (response) {
                let length = response.length;
                console.log(response);
                $('.images-slides-show').empty();
                $('.thumbnail-images').empty();
                
                if (length >= 1){
                    $("#img_item").attr("src", `/assets/image/equipments/${response[0]['Image_path']}`);
                    response.forEach((val, index) => {
                        const html_txt = `
                            <div class="mySlides p-1">
                                <div class="numbertext">${index+1} / ${length}</div>
                                <img class="max-w-full h-auto rounded-md object-center" src="/assets/image/equipments/${val['Image_path']}">
                            </div>
                        `;
                        $('.images-slides-show').append(html_txt);
                        const html_txt2 = `
                            <div class="column p-1">
                                <img class="demo cursor max-w-full h-auto" src="/assets/image/equipments/${val['Image_path']}" 
                                data-currentSlide="${index+1}" alt="${val['Image_path']}">
                            </div>
                        `;
                        $('.thumbnail-images').append(html_txt2);
                    });
                }else{
                    $("#img_item").attr("src", `/assets/image/image_preview.jpg`);
                    const html_txt = `
                        <div class="images-slides-show grid justify-items-center">
                            <!-- Full-width images with number text -->
                            <div class="mySlides p-1">
                                <div class="numbertext">1 / 1</div>
                                <img class="max-w-full h-auto rounded-md object-center" src="/assets/image/image_preview.jpg">
                            </div>
                        </div>
                    `;
                    $('.images-slides-show').append(html_txt);
                    const html_txt2 = `
                        <div class="column p-1">
                            <img class="demo cursor max-w-full h-auto" src="/assets/image/image_preview.jpg"
                                data-currentSlide="1" alt="image_preview">
                        </div>
                    `;
                    $('.thumbnail-images').append(html_txt2);
                }
                image_slider_init();
            }
        });
    });

    $("#qty").change(function (e) {
        e.preventDefault();
        item_name_selected = $("#item_name option:selected").text();
        item_value_selected = $("#item_name").find(":selected").data("value");
        item_value_selected.Name = item_name_selected;
        qty = $("#qty").val();
        Price = item_value_selected.Price * qty;
        $("#total_price").val(Price);
    });

    $("#add_item").click(function (e) {
        e.preventDefault();
        $("#div_tablefrom").prop("hidden", false);
        $("#div_btn_save").prop("hidden", false);

        item_name_selected = $("#item_name option:selected").text();
        item_value_selected = $("#item_name").find(":selected").data("value");

        situation_value_selected = $("#Situation").find(":selected").val();
        if (situation_value_selected == "false") {
            alert("โปรดเลือก Situation");
            return false;
        }
        situation_text_selected = $("#Situation").find(":selected").text();
        qty = $("#qty").val();

        item_value_selected.Name = item_name_selected;
        item_value_selected.Situation_id = situation_value_selected;
        item_value_selected.Situation_name = situation_text_selected;
        item_value_selected.qty = qty;
        // console.log(item_value_selected);
        addtoTable(item_value_selected);

        $(".delete-row").click(function (e) {
            e.preventDefault();
            // console.log("delete");
            $(this).parents("tr").remove();
            check_disable();
        });
        check_disable();
    });

    function check_disable(){
        var tbl = $('#tbody_data tr:has(td)').map(function(index, cell) {
            var $td = $('td', this);
                return {
                    id: ++index,
                    // equipment_id: $td.eq(0).find('input').data('value'),
                    // situation: $td.eq(2).find('input').data('value'),
                    // qty: $td.eq(3).find('input').val()
                }
        }).get();
        if(tbl.length > 0){
            $("#departments").prop("disabled", true);
        }else{
            $("#departments").prop("disabled", false);
        }
    }

    $("#create_orders_save").click(function (e) {
        e.preventDefault();
        notes_messages = $("#notes_messages").val();
        customers_id = $("#customers").find(":selected").val();
        departments_id = $("#departments").find(":selected").val();
        // console.log(customers_id);
        // return;
        var tbl = $('#tbody_data tr:has(td)').map(function(index, cell) {
            var $td = $('td', this);
                return {
                    // id: ++index,
                    item_id: $td.eq(0).find('input').data('item_id'),
                    equipment_id: $td.eq(0).find('input').data('value'),
                    situation: $td.eq(2).find('select').val(),
                    qty: $td.eq(3).find('input').val()
                }
        }).get();
        console.log(tbl);
        EditOrders(notes_messages, tbl, customers_id, departments_id, delete_data);
    });


    $('.show-image').click(function (e) { 
        e.preventDefault();
        $('#modal_show_image_packing').removeClass('invisible');
    });

    $('#Close_show_image_packing').click(function (e) { 
        e.preventDefault();
        $('#modal_show_image_packing').addClass('invisible');
    });

    image_slider_init();
    function image_slider_init(){
        // images slider
        let slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        $('.demo.cursor').click(function (e) { 
            e.preventDefault();
            let currentIndex = $(this).attr('data-currentSlide');
            currentSlide(currentIndex);
        });

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("demo");
            // let captionText = document.getElementById("caption");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += "active";
            // captionText.innerHTML = dots[slideIndex-1].alt;
        }

        $('.next').click(function (e) { 
            e.preventDefault();
            plusSlides(1)
        });
        $('.prev').click(function (e) { 
            e.preventDefault();
            plusSlides(-1)
        });
    }

    function showImages(formDataImage){
        $('#list_img').empty();
        let index = 0;
        formDataImage.forEach((value, key, fD) => {
            // console.log(value.name);
            // const [file] = value;
            const html = `
                <a class="block p-1 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <div class="relative" height="40px" width="auto">
                        <img class="w-full" style="height: 15rem; object-fit: contain;" src="${URL.createObjectURL(value)}" alt="dummy-image">
                        <button data-key="${key}" data-index="${index}" class="btn_remove_img absolute bottom-1 right-1 bg-red-500 text-white p-2 rounded hover:bg-red-800">
                            Remove
                        </button>
                    </div>
                </a>
            `;
            index++;
            $('#list_img').append(html);
        });

        $('.btn_remove_img').click(function (e) {
            e.preventDefault();
            let key = $(this).attr('data-key');
            formDataImage.delete(key);
            showImages(formDataImage);
        });
    }

    $('.closeModal').on('click', function(e){
        $('#modal_images').addClass('invisible');
    });

    function imagefromserver(images){
        $('#list_img_inserver').empty();
        console.log(images);
        images.forEach((value, key) => {
        const html = `
            <a class="${value.Image_id} block p-1 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <div class="relative" height="40px" width="auto">
                    <img class="w-full" style="height: 15rem; object-fit: contain;" src="/assets/image/orders/${value.Image_name}" alt="${value.Image_id}">
                    <button data-key="${value.Image_id}" data-name="${value.Image_name}" class="btn_remove_img_inserver absolute bottom-1 right-1 bg-red-500 text-white p-2 rounded hover:bg-red-800">
                        Remove
                    </button>
                </div>
            </a>
        `;
        $('#list_img_inserver').append(html);
        });

        $('.btn_remove_img_inserver').click(function (e) { 
            e.preventDefault();
            remove_img_inserver = $(this).attr('data-key');
            remove_img_name_inserver = $(this).attr('data-name');
            delete_images_id.push(remove_img_inserver);
            delete_images.push(remove_img_name_inserver);
            $(`.${remove_img_inserver}`).remove();
        });
    }

    function loadImages(){
        $.ajax({
            type: "GET",
            url: "/orders/edit/getitemsimages",
            data: {
                order_id: order_id
            },
            dataType: "json",
            success: function (response) {
                // console.log(response);
                imagefromserver(response);
                $('#modal_images').removeClass('invisible');
            }
        });
    }

    $('.openImageModal').click(function (e) { 
        e.preventDefault();
        loadImages();
    });

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

        for (let i = 0; i < files.length; i++) {
            formDataImage.append(i, files[i]);
        }
        showImages(formDataImage);
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

        for (let i = 0; i < files.length; i++) {
            formDataImage.append(i, files[i]);
        }
        showImages(formDataImage);
    });

    $("#btnApprove").click(function (e) {
        $.ajax({
            type: "POST",
            url: "/orders/edit/approve",
            data: {
                order_id: order_id,
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('#create_orders_save').trigger('click');
            }
        });
    });
});