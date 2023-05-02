$(document).ready(function () {
    const url_path = window.location.pathname;
    // set Table
    function setTable(data) {
        // console.log(data);
        $("#machineprograme-table").empty();
        data.forEach((element) => {
            const rowHtml = `
                <tr>
                    <td class="border-dashed border-t border-gray-200 action">
                        <span
                            class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                            <button type="button" value="${element.Program_id}"
                                class="delete_data mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
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
            $("#machineprograme-table").append(rowHtml);
        });
        initEvent();
    }

    // function to get program list
    function getProgramList(page = 1, txt_search = "") {
        $.ajax({
            type: "GET",
            url: `${url_path}/getlistlinkmachines`,
            data: {
                page: page,
                txt_search: txt_search,
            },
            dataType: "json",
            success: function (response) {
                // console.log(response.listPrograme.data);
                setTable(response.listPrograme.data);
                $("#txt_firstItem").text(response.listPrograme.from);
                $("#txt_lastItem").text(response.listPrograme.to);
                $("#txt_total").text(response.listPrograme.total);
                $("#lastPage").text(response.listPrograme.last_page);
                $("#page_input").val(response.listPrograme.current_page);

                const btn_first_page =
                    document.querySelector(".btn_first_page");
                btn_first_page.setAttribute(
                    "url_data",
                    response.listPrograme.first_page_url
                );

                const btn_prev_page = document.querySelector(".btn_prev_page");
                btn_prev_page.setAttribute(
                    "url_data",
                    response.listPrograme.prev_page_url
                );

                const btn_next_page = document.querySelector(".btn_next_page");
                btn_next_page.setAttribute(
                    "url_data",
                    response.listPrograme.next_page_url
                );

                const btn_last_page = document.querySelector(".btn_last_page");
                btn_last_page.setAttribute(
                    "url_data",
                    response.listPrograme.last_page_url
                );
            },
        });
    }

    // function to get program
    function getProgram() {
        $("#select_program").empty();
        $.ajax({
            type: "GET",
            url: `${url_path}/getprogram`,
            dataType: "json",
            success: function (response) {
                console.log(response);
                response.forEach((element) => {
                    const optionHtml = `
                        <option value="${element.Program_id}">
                            ${element.Program_name}
                        </option>
                    `;
                    $("#select_program").append(optionHtml);
                });
                $('#interestModal').removeClass('invisible');
            },
        });
    }

    // init function
    getProgramList();
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

        getProgramList(page, txt_search);
    });

    $("#search").keydown(function (e) {
        if (e.keyCode == 13) {
            let txt_search = $("#search").val();
            getProgramList(null, txt_search);
        }
    });

    $('#delete_data').click(function (e) { 
        e.preventDefault();
        let id = $(this).val();
        $.ajax({
            type: "POST",
            url: `${url_path}/deletelink`,
            data: {
                program_id: id,
            },
            dataType: "json",
            success: function (response) {
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getProgramList(page, txt_search);
            }
        });
    });

    // open modal add
    $('.openAddModal').on('click', function(e){
        getProgram();
    });
    $('.closeModal').on('click', function(e){
        $('#interestModal').addClass('invisible');
    });

    // add program
    $('#add_program_machine').on('click', function(e){
        e.preventDefault();
        let program_id = $('#select_program').val();

        $.ajax({
            type: "POST",
            url: `${url_path}/addlink`,
            data: {
                program_id: program_id,
            },
            dataType: "json",
            success: function (response) {
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getProgramList(page, txt_search);
                $('#interestModal').addClass('invisible');
            }
        });
    });

    function initEvent() {
        $(".delete_data").click(function (e) { 
            e.preventDefault();
            let id = $(this).val();
            if(confirm('Are you sure to delete this program in machine?')){
                $.ajax({
                    type: "POST",
                    url: `${url_path}/deletelink`,
                    data: {
                        program_id: id,
                    },
                    dataType: "json",
                    success: function (response) {
                        let page = $('#page_input').val();
                        let txt_search = $("#search").val();
                        getProgramList(page, txt_search);
                        $('#interestModal').addClass('invisible');
                    }
                });
            }
        });
    }
});
