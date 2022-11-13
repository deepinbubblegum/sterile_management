$(document).ready(function () {
    // set tables
    function setTable(data) {
        console.log(data);
        $("#machineswashing-table").empty();
        data.forEach((element) => {
            const rowHtml = `
                <tr>
                    <td class="border-dashed border-t border-gray-200 action">
                        <span
                            class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                            <button type="button" value="${element.MachinesWashing_id}"
                                class="openEditModal mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-regular fa-pen-to-square fa-xl mx-auto"></i>
                            </button>
                            <button type="button" data-value="${element.Active == '1' ? '0': '1'}" value="${element.MachinesWashing_id}"
                                class="toggle_activate_equipments mr-1 w-10 h-10 px-2 py-2 text-base text-white ${element.Active == '1' ? 'bg-success hover:bg-success-dark focus:ring-success' : 'bg-warning hover:bg-warning-dark focus:ring-warning'} rounded-md inline-flex items-center focus:outline-none focus:ring  focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                ${element.Active == '1' ? '<i class="fa-solid fa-check fa-xl mx-auto"></i>' : '<i class="fa-solid fa-x fa-xl mx-auto"></i>'}
                            </button>
                            <button type="button" value="${element.MachinesWashing_id}"
                                class="delete_data mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-solid fa-trash fa-xl mx-auto"></i>
                            </button>
                        </span>
                    </td>
                    <td
                        class="border-dashed border-t border-gray-200 Order_id">
                        <span
                            class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                            ${element.MachinesWashingName}
                        </span>
                    </td>
                </tr>
            `;
            $("#machineswashing-table").append(rowHtml);
        });
        initLoaded();
    }

    // get list machines washing
    function getListMachinesWashing(page = 1, txt_search = "") {
        $.ajax({
            type: "GET",
            url: "/settings/machineswashings/getlistmachines",
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


    // init function
    getListMachinesWashing();
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

        getListMachinesWashing(page, txt_search);
    });

    $("#search").keydown(function (e) {
        if (e.keyCode == 13) {
            let txt_search = $("#search").val();
            getListMachinesWashing(null, txt_search);
        }
    });

    // open modal add
    $('.openAddModal').on('click', function(e){
        $('#interestModal').removeClass('invisible');
    });
    $('.closeModal').on('click', function(e){
        $('#interestModal').addClass('invisible');
    });


    // init loaded
    function initLoaded(){
        $('.delete_data').click(function (e) {
            e.preventDefault();
            let machine_id = $(this).val();
            if (confirm('Are you sure you want to delete this machines?')) {
                $.ajax({
                    type: "POST",
                    url: "/settings/machineswashings/deletemachines",
                    data: {
                        machine_id: machine_id
                    },
                    dataType: "json",
                    success: function (response) {
                        let page = $('#page_input').val();
                        let txt_search = $("#search").val();
                        getListMachinesWashing(page, txt_search);
                    }
                });
            }
        });

        $('.openEditModal').click(function (e) {
            e.preventDefault();
            let machine_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "/settings/machineswashings/getmachinesdetail",
                data: {
                    machine_id: machine_id
                },
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('#machine_name_edit').val(response.MachinesWashingName);
                    $('#machine_name_edit').attr('data-value', response.MachinesWashing_id);
                    $('#editMachineWashingModal').removeClass('invisible');
                }
            });
        });

        $('.closeModal').on('click', function(e){
            $('#editMachineWashingModal').addClass('invisible');
        });

        $('.toggle_activate_equipments').click(function (e) { 
            e.preventDefault();
            let machine_id = $(this).val();
            let Active = $(this).attr('data-value');
            $.ajax({
                type: "POST",
                url: "/settings/machineswashings/activate",
                data: {
                    machine_id: machine_id,
                    Active: Active
                },
                dataType: "json",
                success: function (response) {
                    let page = $('#page_input').val();
                    let txt_search = $("#search").val();
                    getListMachinesWashing(page, txt_search);
                }
            });
        });
    }


    // create machines washing
    $('#add_machine').click(function (e) {
        e.preventDefault();
        let machine_name = $('#machine_name').val();
        $.ajax({
            type: "POST",
            url: "/settings/machineswashings/createmachines",
            data: {
                machine_name: machine_name
            },
            dataType: "json",
            success: function (response) {
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getListMachinesWashing(page, txt_search);
                $('#interestModal').addClass('invisible');
                $('#machine_name').val('');
            }
        });
    });

    // edit machines washing
    $('#edit_machine').click(function (e) {
        e.preventDefault();
        let machine_id = $('#machine_name_edit').attr('data-value');
        let machine_name = $('#machine_name_edit').val();
        $.ajax({
            type: "POST",
            url: "/settings/machineswashings/updatemachines",
            data: {
                machine_id: machine_id,
                machine_name: machine_name
            },
            dataType: "json",
            success: function (response) {
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getListMachinesWashing(page, txt_search);
                $('#editMachineWashingModal').addClass('invisible');
            }
        });
    });

    $("#page_input").keydown(function (e) { 
        if (e.keyCode == 13) {
            let txt_search = $("#search").val();
            let page = $("#page_input").val();
            getListMachinesWashing(page, txt_search);
        }
    });
});