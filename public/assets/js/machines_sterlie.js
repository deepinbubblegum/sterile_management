$(document).ready(function () {
    // set tables
    function setTable(data) {
        console.log(data);
        $("#machinesterile-table").empty();
        data.forEach((element) => {
            const rowHtml = `
                <tr>
                    <td class="border-dashed border-t border-gray-200 action">
                        <span
                            class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                            <a href="/settings/machinessterile/${element.Machine_id}/programes" type="button" value="${element.Machine_id}"
                                class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-solid fa-screwdriver-wrench fa-xl mx-auto"></i>
                            </a>
                            <button type="button" value="${element.Machine_id}"
                                class="openEditModal mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-regular fa-pen-to-square fa-xl mx-auto"></i>
                            </button>
                            <button type="button" value="${element.Machine_id}"
                                class="delete_data mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-solid fa-trash fa-xl mx-auto"></i>
                            </button>
                        </span>
                    </td>
                    <td
                        class="border-dashed border-t border-gray-200 Order_id">
                        <span
                            class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                            ${element.Machine_name}
                        </span>
                    </td>
                    <td
                        class="border-dashed border-t border-gray-200 Order_id">
                        <span
                            class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                            ${element.Machine_type}
                        </span>
                    </td>
                </tr>
            `;
            $("#machinesterile-table").append(rowHtml);
        });
        initLoaded();
    }

    // get list machines
    function getListMachines(page = 1, txt_search = "") {
        $.ajax({
            type: "GET",
            url: "/settings/machinessterile/getlistmachines",
            data: {
                page: page,
                txt_search: txt_search
            },
            dataType: "json",
            success: function (response) {
                // console.log(response.machines.data);
                setTable(response.machines.data);
                $("#txt_firstItem").text(response.machines.from);
                $("#txt_lastItem").text(response.machines.to);
                $("#txt_total").text(response.machines.total);
                $("#lastPage").text(response.machines.last_page);
                $("#page_input").val(response.machines.current_page);

                const btn_first_page =
                    document.querySelector(".btn_first_page");
                btn_first_page.setAttribute(
                    "url_data",
                    response.machines.first_page_url
                );

                const btn_prev_page = document.querySelector(".btn_prev_page");
                btn_prev_page.setAttribute(
                    "url_data",
                    response.machines.prev_page_url
                );

                const btn_next_page = document.querySelector(".btn_next_page");
                btn_next_page.setAttribute(
                    "url_data",
                    response.machines.next_page_url
                );

                const btn_last_page = document.querySelector(".btn_last_page");
                btn_last_page.setAttribute(
                    "url_data",
                    response.machines.last_page_url
                );
            }
        });
    }

    // init funtions
    getListMachines();
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

        getListMachines(page, txt_search);
    });

    $("#search").keydown(function (e) {
        if (e.keyCode == 13) {
            let txt_search = $("#search").val();
            getListMachines(null, txt_search);
        }
    });

    // open modal add
    $('.openAddModal').on('click', function(e){
        $('#interestModal').removeClass('invisible');
    });
    $('.closeModal').on('click', function(e){
        $('#interestModal').addClass('invisible');
    });

    $('#add_machine').on('click', function(e){
        e.preventDefault();
        let Machine_name = $('#machine_name').val();
        let Machine_type = $('#machine_type option:selected').val();
        if (Machine_name == '') {
            $('#machine_name').addClass('border-red-500');
            $('#machine_name').focus();
            return false;
        }
        if (Machine_type == '0') {
            $('#machine_type').addClass('border-red-500');
            $('#machine_type').focus();
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/settings/machinessterile/createmachines",
            data: {
                machines_name: Machine_name,
                machines_type: Machine_type
            },
            dataType: "json",
            success: function (response) {
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getListMachines(page, txt_search);
                $('#interestModal').addClass('invisible');
            }
        });
    });
    
    function initLoaded(){
        $('.delete_data').click(function (e) { 
            e.preventDefault();
            let machine_id = $(this).val();
            if (confirm('Are you sure you want to delete this item?')) {
                $.ajax({
                    type: "POST",
                    url: "/settings/machinessterile/deletemachines",
                    data: {
                        machine_id: machine_id
                    },
                    dataType: "json",
                    success: function (response) {
                        let page = $('#page_input').val();
                        let txt_search = $("#search").val();
                        getListMachines(page, txt_search);
                    }
                });
            }
        });

        $('.openEditModal').click(function (e) {
            e.preventDefault();
            let machine_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "/settings/machinessterile/getmachinesdetail",
                data: {
                    machine_id: machine_id
                },
                dataType: "json",
                success: function (response) {
                    $('#machine_name_edit').attr('data-value', response.Machine_id);
                    $('#machine_name_edit').val(response.Machine_name);
                    $("#machine_type_edit").val(response.Machine_type).change();
                    $('#ModalEdit').removeClass('invisible');
                    console.log(response);

                }
            });
        });

        $('.closeModal').on('click', function(e){
            $('#ModalEdit').addClass('invisible');
        });
    }

    $('#edit_machine').click(function (e) { 
        e.preventDefault();
        let Machine_id = $('#machine_name_edit').attr('data-value');
        let Machine_name = $('#machine_name_edit').val();
        let Machine_type = $('#machine_type_edit option:selected').val();
        if (Machine_name == '') {
            $('#machine_name_edit').addClass('border-red-500');
            $('#machine_name_edit').focus();
            return false;
        }
        if (Machine_type == '0') {
            $('#machine_type_edit').addClass('border-red-500');
            $('#machine_type_edit').focus();
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/settings/machinessterile/updatemachines",
            data: {
                machine_id: Machine_id,
                machine_name: Machine_name,
                machine_type: Machine_type
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getListMachines(page, txt_search);
                $('#ModalEdit').addClass('invisible');
            }
        });
        
    });
});