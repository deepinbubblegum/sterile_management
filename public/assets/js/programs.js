$(document).ready(function () {
    // set tables
    function setTable(data) {
        $("#programs-table").empty();
        // console.log(data);
        data.forEach((element) => {
            const rowHtml = `
                <tr>
                    <td class="border-dashed border-t border-gray-200 action">
                        <span
                            class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                            <button type="button" value="${element.Program_id}"
                                class="openEditModal mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-regular fa-pen-to-square fa-xl mx-auto"></i>
                            </button>
                            <button type="button" value="${element.Program_id}"
                                class="delete_program mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-solid fa-trash fa-xl mx-auto"></i>
                            </button>
                        </span>
                    </td>
                    <td
                        class="border-dashed border-t border-gray-200 Order_id">
                        <span
                            class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                            ${element.Program_name}
                        </span>
                    </td>
                </tr>
            `;
            $("#programs-table").append(rowHtml);
        });
        initLoaded();
    }

    // get data programs list
    function getListPrograms(page = 1, txt_search = ""){
        $.ajax({
            type: "GET",
            url: "/settings/programs/getlistprograms",
            data: {
                page: page,
                txt_search: txt_search
            },
            dataType: "json",
            success: function (response) {
                // console.log(response.programs.data);
                setTable(response.programs.data);
                $("#txt_firstItem").text(response.programs.from);
                $("#txt_lastItem").text(response.programs.to);
                $("#txt_total").text(response.programs.total);
                $("#lastPage").text(response.programs.last_page);
                $("#page_input").val(response.programs.current_page);

                const btn_first_page =
                    document.querySelector(".btn_first_page");
                btn_first_page.setAttribute(
                    "url_data",
                    response.programs.first_page_url
                );

                const btn_prev_page = document.querySelector(".btn_prev_page");
                btn_prev_page.setAttribute(
                    "url_data",
                    response.programs.prev_page_url
                );

                const btn_next_page = document.querySelector(".btn_next_page");
                btn_next_page.setAttribute(
                    "url_data",
                    response.programs.next_page_url
                );

                const btn_last_page = document.querySelector(".btn_last_page");
                btn_last_page.setAttribute(
                    "url_data",
                    response.programs.last_page_url
                );
            }
        });
    }

    // init funtions
    getListPrograms();

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

        getListPrograms(page, txt_search);
    });

    $("#search").keydown(function (e) {
        if (e.keyCode == 13) {
            let txt_search = $("#search").val();
            getListPrograms(null, txt_search);
        }
    });
    
    // add new program
    $('.openAddModal').on('click', function(e){
        $('#interestModal').removeClass('invisible');
    });
    $('.closeModal').on('click', function(e){
        $('#interestModal').addClass('invisible');
    });


    function initLoaded(){
        // edit program
        $('.openEditModal').on('click', function(e){
            let program_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "/settings/programs/getprogramsdetail",
                data: {
                    program_id: program_id
                },
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    $('#edit_program_name').attr('data-value', program_id);
                    $('#edit_program_name').val(response.Program_name);
                    $('#editModal').removeClass('invisible');
                }
            });
        });

        $('.closeModal').on('click', function(e){
            $('#editModal').addClass('invisible');
        });

        // delete program
        $('.delete_program').click(function (e) { 
            e.preventDefault();
            let program_id = $(this).val();
            if (confirm("Are you sure you want to delete this program?")) {
                $.ajax({
                    type: "POST",
                    url: "/settings/programs/deleteprograms",
                    data: {
                        program_id: program_id
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        let page = $('#page_input').val();
                        let txt_search = $("#search").val();
                        getListPrograms(page, txt_search);
                    }
                });
            }
        });
    }

    $('#add_program').click(function (e) { 
        e.preventDefault();
        let program_name = $('#program_name').val();
        $.ajax({
            type: "POST",
            url: "/settings/programs/createprograms",
            data: {
                program_name: program_name
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getListPrograms(page, txt_search);
                $('#interestModal').addClass('invisible');
                $('#program_name').val('');
            }
        });
    });

    $('#edit_program').click(function (e) {
        e.preventDefault();
        let program_id = $('#edit_program_name').attr('data-value');
        let program_name = $('#edit_program_name').val();
        $.ajax({
            type: "POST",
            url: "/settings/programs/updateprograms",
            data: {
                program_id: program_id,
                program_name: program_name
            },
            dataType: "json",
            success: function (response) {
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getListPrograms(page, txt_search);
                $('#editModal').addClass('invisible');
            }
        });
    });

    $("#page_input").keydown(function (e) { 
        if (e.keyCode == 13) {
            let txt_search = $("#search").val();
            let page = $("#page_input").val();
            getListPrograms(page, txt_search);
        }
    });

});