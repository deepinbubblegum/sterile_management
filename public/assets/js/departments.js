$(document).ready(function () {
    const url_path = window.location.pathname;

    // funtion set table
    function setTable(data) {
        $("#departmentsTable").empty();
        data.forEach((element) => {
            // console.log(element);
            const rowHtml = `
            <tr>
                <td class="border-dashed border-t border-gray-200 action">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        <a href="" value="${element.Department_id}"
                            class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-solid fa-toolbox fa-xl mx-auto"></i>
                        </a>
                        <button type="button" value="${element.Department_id}"
                            class="openEditModal mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-regular fa-pen-to-square fa-xl mx-auto"></i>
                        </button>
                        <button type="button" value="${element.Department_id}"
                            class="delete_department mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-solid fa-trash fa-xl mx-auto"></i>
                        </button>
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Department_name}
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Customer_name}
                    </span>
                </td>
            </tr>
            `;
            $("#departmentsTable").append(rowHtml);
        });
        activefun();
    }

    // function to get all departments
    function getDepartments(page = 1, txt_search = "") {
        $.ajax({
            type: "GET",
            url: `${url_path}/getlistdepartments`,
            data: {
                page: page,
                txt_search: txt_search,
            },
            dataType: "json",
            success: function (response) {
                // console.log(response.departments.data);
                setTable(response.departments.data);
                $("#txt_firstItem").text(response.departments.from);
                $("#txt_lastItem").text(response.departments.to);
                $("#txt_total").text(response.departments.total);
                $("#lastPage").text(response.departments.last_page);
                $("#page_input").val(response.departments.current_page);

                const btn_first_page =
                document.querySelector(".btn_first_page");
                btn_first_page.setAttribute(
                    "url_data",
                    response.departments.first_page_url
                );

                const btn_prev_page = document.querySelector(".btn_prev_page");
                btn_prev_page.setAttribute(
                    "url_data",
                    response.departments.prev_page_url
                );

                const btn_next_page = document.querySelector(".btn_next_page");
                btn_next_page.setAttribute(
                    "url_data",
                    response.departments.next_page_url
                );

                const btn_last_page = document.querySelector(".btn_last_page");
                btn_last_page.setAttribute(
                    "url_data",
                    response.departments.last_page_url
                );
            }
        });
    }

    // initial call to get all departments
    getDepartments();

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

        getDepartments(page, txt_search);
    });

    $("#search").keydown(function (e) {
        if (e.keyCode == 13) {
            let txt_search = $("#search").val();
            getDepartments(null, txt_search);
        }
    });

    $('.openAddModal').on('click', function(e){
        $('#interestModal').removeClass('invisible');
    });
    $('.closeModal').on('click', function(e){
        $('#interestModal').addClass('invisible');
    });

    // function to add new department
    $('#add_departments').click(function (e) { 
        e.preventDefault();
        let department_name = $('#department_name').val();
        // console.log(department_name);
        $.ajax({
            type: "POST",
            url: `${url_path}/createdepartments`,
            data: {
                department_name: department_name,
            },
            dataType: "json",
            success: function (response) {
                getDepartments();
                $('#interestModal').addClass('invisible');
            }
        });
    });

    function activefun() {
        // function to delete department
        $('.delete_department').click(function (e) {
            e.preventDefault();
            let department_id = $(this).val();
            console.log(department_id);
            if (confirm("Are you sure you want to delete this department?")) {
                $.ajax({
                    type: "POST",
                    url: `${url_path}/deletedepartments`,
                    data: {
                        department_id: department_id,
                    },
                    dataType: "json",
                    success: function (response) {
                        getDepartments();
                    }
                });
            }
        });

        // function to edit department
        $('.openEditModal').click(function (e) {
            let department_id = $(this).val();
            $.ajax({
                type: "GET",
                url: `${url_path}/getdepartmentsdetail`,
                data: {
                    department_id: department_id,
                },
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('#txt_department_name').attr('data-id', response.Department_id);
                    $('#txt_department_name').val(response.Department_name);
                    $('#editModal').removeClass('invisible');
                }
            });
        });
    }

    $("#update_department").click(function (e) { 
        e.preventDefault();
        let department_id = $('#txt_department_name').attr('data-id');
        let department_name = $('#txt_department_name').val();
        $.ajax({
            type: "POST",
            url: `${url_path}/updatedepartments`,
            data: {
                department_id: department_id,
                department_name: department_name,
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                getDepartments();
                $('#editModal').addClass('invisible');
            }
        });
    });

    $('.closeModal').on('click', function(e){
        $('#editModal').addClass('invisible');
    });
});