$(document).ready(function () {
    $('#users').select2();
    const url_path = window.location.pathname;
    // set table
    function setTable(data) {
        // console.log(data);
        $('#userdepartment-table').empty();
        data.forEach((element) => {
            const rowHtml = `
            <tr>
                <td class="border-dashed border-t border-gray-200 action">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        <button type="button" value="${element.User_id}"
                            class="delete_data mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
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
                        ${element.Group_name}
                    </span>
                </td>
            </tr>
            `;
            $('#userdepartment-table').append(rowHtml);
        });
        loaded();
    }

    function getListUsersDepartment(page = 1, txt_search = "") {
        $.ajax({
            type: "GET",
            url: `${url_path}/getlistusersdepartment`,
            data: {
                page: page,
                txt_search: txt_search,
            },
            dataType: "json",
            success: function (response) {
                setTable(response.usersDepartment.data);
                $("#txt_firstItem").text(response.usersDepartment.from);
                $("#txt_lastItem").text(response.usersDepartment.to);
                $("#txt_total").text(response.usersDepartment.total);
                $("#lastPage").text(response.usersDepartment.last_page);
                $("#page_input").val(response.usersDepartment.current_page);

                const btn_first_page =
                    document.querySelector(".btn_first_page");
                btn_first_page.setAttribute(
                    "url_data",
                    response.usersDepartment.first_page_url
                );

                const btn_prev_page = document.querySelector(".btn_prev_page");
                btn_prev_page.setAttribute(
                    "url_data",
                    response.usersDepartment.prev_page_url
                );

                const btn_next_page = document.querySelector(".btn_next_page");
                btn_next_page.setAttribute(
                    "url_data",
                    response.usersDepartment.next_page_url
                );

                const btn_last_page = document.querySelector(".btn_last_page");
                btn_last_page.setAttribute(
                    "url_data",
                    response.usersDepartment.last_page_url
                );
            }
        });
    }

    // initial call to get all usersdepartment
    getListUsersDepartment();
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

        getListUsersDepartment(page, txt_search);
    });

    $("#search").keydown(function (e) {
        if (e.keyCode == 13) {
            let txt_search = $("#search").val();
            getListUsersDepartment(null, txt_search);
        }
    });

    // open modal add
    $('.openAddModal').on('click', function(e){
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: `${url_path}/getlistusers`,
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('#users').empty();
                response.forEach((element) => {
                    const rowHtml = `
                    <option value="${element.User_id}">${element.Name}</option>
                    `;
                    $('#users').append(rowHtml);
                });
                $('#interestModal').removeClass('invisible');
            }
        });
    });
    $('.closeModal').on('click', function(e){
        $('#interestModal').addClass('invisible');
    });

    // add usersdepartment
    $('#add_users').click(function (e) { 
        e.preventDefault();
        let user_id = $('#users').val();
        console.log(user_id);
        $.ajax({
            type: "POST",
            url: `${url_path}/createusersdepartment`,
            data: {
                user_id: user_id,
            },
            dataType: "json",
            success: function (response) {
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getListUsersDepartment(page, txt_search);
                $('#interestModal').addClass('invisible');
            }
        });
    });

    function loaded() {
        // delete usersdepartment
        $('.delete_data').click(function (e) { 
            e.preventDefault();
            if(confirm('do you want to delete this user in department ?')){
                let user_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: `${url_path}/deleteusersdepartment`,
                    data: {
                        user_id: user_id,
                    },
                    dataType: "json",
                    success: function (response) {
                        let page = $('#page_input').val();
                        let txt_search = $("#search").val();
                        getListUsersDepartment(page, txt_search);
                    }
                });
            }
        });
    }

    $("#page_input").keydown(function (e) { 
        if (e.keyCode == 13) {
            let txt_search = $("#search").val();
            let page = $("#page_input").val();
            getListUsersDepartment(page, txt_search);
        }
    });
});