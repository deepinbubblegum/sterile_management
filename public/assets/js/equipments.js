$(document).ready(function () {
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
                            class="disable_equipments mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-warning inline-flex items-center hover:bg-warning-dark focus:outline-none focus:ring focus:ring-warning focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            ${element.Activate == 'A' ? '<i class="fa-solid fa-x fa-xl mx-auto"></i>' : '<i class="fa-solid fa-check fa-xl mx-auto"></i>'}
                        </button>
                        <button type="button" value="${element.Equipment_id}"
                            class="delete_equipments mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-solid fa-trash fa-xl mx-auto"></i>
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
                        ${element.Price.toFixed(2)} บาท
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
                        ${element.Descriptions}
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 Order_id">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Item_Type}
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 Order_id">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Activate == 'A' ? 'ใช้งาน' : 'ไม่ใช้งาน'}
                    </span>
                </td>
            </tr>
            `;
            $("#equipmentsTable").append(rowHtml);
        });
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

    $('#add_equip').click(function (e) { 
        e.preventDefault();
        let equip_name = $('#equip_name').val();
        let price = $('#price').val();
        let expire = $('#expire').val();
        let process = $("#process option:selected").val();
        let item_type = $('#item_type').val();
        let descriptions = $('#descriptions').val();
        if (process == '0') {
            alert('กรุณาเลือกกระบวนการ');
            return false;
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
                equipment_descriptions: descriptions
            },
            dataType: "json",
            success: function (response) {
                $('#interestModal').addClass('invisible');
                $('#equip_name').val('');
                $('#price').val('');
                $('#expire').val('');
                $('#item_type').val('');
                $('#descriptions').val('');
                getEquipments();
            }
        });
    });
});
