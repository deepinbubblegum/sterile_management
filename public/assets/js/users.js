$(document).ready(function () {
    // set up the table
    function setTable(data){
        $("#usersTable").empty();
        data.forEach((element) => {
            // console.log(element);
            const rowHtml = `
            <tr>
                <td class="border-dashed border-t border-gray-200 action">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        <button type="button" value="${element.User_id}"
                            class="edit_users mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-regular fa-pen-to-square fa-xl mx-auto"></i>
                        </button>
                        <button type="button" data-value="${element.Activate == '1' ? '0': '1'}" value="${element.User_id}"
                            class="toggle_activate_equipments mr-1 w-10 h-10 px-2 py-2 text-base text-white ${element.Activate == '1' ? 'bg-success hover:bg-success-dark focus:ring-success' : 'bg-warning hover:bg-warning-dark focus:ring-warning'} rounded-md inline-flex items-center focus:outline-none focus:ring  focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            ${element.Activate == '1' ? '<i class="fa-solid fa-check fa-xl mx-auto"></i>' : '<i class="fa-solid fa-x fa-xl mx-auto"></i>'}
                        </button>
                        <button type="button" value="${element.User_id}"
                            class="delete_users mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-solid fa-trash fa-xl mx-auto"></i>
                        </button>
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 Order_id">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Username}
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 customerName">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Name}
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 customerName">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Group_name}
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 departmentsName">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Activate == '1' ? 'เปิดใช้' : 'ปิด'}
                    </span>
                </td>
            </tr>
            `;
            $("#usersTable").append(rowHtml);
        });
        funinit();
    }

    // get all users
    function getAllUsers(page = 1, txt_search = ""){
        $.ajax({
            type: "GET",
            url: "/settings/users/getallusers",
            data: {
                page: page,
                txt_search: txt_search
            },
            dataType: "json",
            success: function (response) {
                setTable(response.users.data);
                $("#txt_firstItem").text(response.users.from);
                $("#txt_lastItem").text(response.users.to);
                $("#txt_total").text(response.users.total);
                $("#lastPage").text(response.users.last_page);
                $("#page_input").val(response.users.current_page);

                const btn_first_page =
                    document.querySelector(".btn_first_page");
                btn_first_page.setAttribute(
                    "url_data",
                    response.users.first_page_url
                );

                const btn_prev_page = document.querySelector(".btn_prev_page");
                btn_prev_page.setAttribute(
                    "url_data",
                    response.users.prev_page_url
                );

                const btn_next_page = document.querySelector(".btn_next_page");
                btn_next_page.setAttribute(
                    "url_data",
                    response.users.next_page_url
                );

                const btn_last_page = document.querySelector(".btn_last_page");
                btn_last_page.setAttribute(
                    "url_data",
                    response.users.last_page_url
                );
            },
        });
    }

    getAllUsers();
    getGroup();

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

        getAllUsers(page, txt_search);
    });

    $("#search").keydown(function (e) {
        if (e.keyCode == 13) {
            let txt_search = $("#search").val();
            getAllUsers(null, txt_search);
        }
    });

    function funinit(){
        $(".delete_users").click(function (e) { 
            e.preventDefault();
            // console.log($(this).val());
            let id = $(this).val();
            if (confirm("ยืนยันการลบข้อมูล")) {
                $.ajax({
                    type: "post",
                    url: "/settings/users/deleteusers",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function (response) {
                        let page = $('#page_input').val();
                        let txt_search = $("#search").val();
                        getAllUsers(page, txt_search);
                    },
                });
            }
        });


        $('.toggle_activate_equipments').click(function (e) { 
            e.preventDefault();
            let id = $(this).val();
            let activate = $(this).attr('data-value');
            // console.log(id);
            $.ajax({
                type: "POST",
                url: "/settings/users/toggleactivateusers",
                data: {
                    id: id,
                    activate: activate
                },
                dataType: "json",
                success: function (response) {
                    let page = $('#page_input').val();
                    let txt_search = $("#search").val();
                    getAllUsers(page, txt_search);
                }
            });
        });

        // edit users
        $('.edit_users').on('click', function(e){
            e.preventDefault();
            let id = $(this).val();
            $.ajax({
                type: "GET",
                url: "/settings/users/getusersdetail",
                data: {
                    id: id
                },
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('#edit_users').val(id);
                    $('#edit_username').val(response.Username);
                    $('#edit_password').val('');
                    $('#edit_email').val(response.Email);
                    // $('#group option:selected').val('');
                    $("#edit_group select").val(response.Group_id).change();
                    $('#edit_confirm_password').val('');
                    $('#edit_name_lname').val(response.Name);

                    $('#editModal').removeClass('invisible');
                }
            });

        });
    
        $('.closeModal').on('click', function(e){
            $('#editModal').addClass('invisible');
        });
    }

    // edit users
    $('#edit_users').on('click', function(e){
        e.preventDefault();
        console.log('edit');
        let id = $(this).val();
        let username = $('#edit_username').val();
        let password = $('#edit_password').val();
        let email = $('#edit_email').val();
        let group_id = $('#edit_group option:selected').val();
        let confirm_password = $('#edit_confirm_password').val();
        let name = $('#edit_name_lname').val();

        if (username == '') {
            alert('กรุณากรอก username');
            return false;
        }

        if (password == '') {
            alert('กรุณากรอก password');
            return false;
        }

        if (confirm_password == '') {
            alert('กรุณากรอก confirm password');
            return false;
        }

        if (password != confirm_password) {
            alert('password ไม่ตรงกัน');
            return false;
        }

        if (name == '') {
            alert('กรุณากรอก ชื่อ-สกุล');
            return false;
        }

        if (group_id == '') {
            alert('กรุณาเลือกกลุ่ม');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/settings/users/editusers",
            data: {
                user_id: id,
                username: username,
                password: password,
                email: email,
                group_id: group_id,
                name: name
            },
            dataType: "json",
            success: function (response) {
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getAllUsers(page, txt_search);
                $('#editModal').addClass('invisible');
            }
        });

    });

    function getGroup(){
        $.ajax({
            type: "GET",
            url: "/settings/getgroup",
            dataType: "json",
            success: function (response) {
                // console.log(response);
                let html = '';
                response.forEach(element => {
                    html += `<option value="${element.Group_id}">${element.Group_name}</option>`;
                });
                $('#group').html(html);
                $('#edit_group').html(html);
            }
        });
    }

    $('.openAddModal').on('click', function(e){
        $('#interestModal').removeClass('invisible');
    });
    $('.closeModal').on('click', function(e){
        $('#interestModal').addClass('invisible');
    });

    $('#add_user').click(function (e) { 
        e.preventDefault();
        let username = $('#username').val();
        let password = $('#password').val();
        let email = $('#email').val();
        let group = $('#group option:selected').val();
        let confirm_password = $('#confirm_password').val();
        let name = $('#name_lname').val();

        if (username == '') {
            alert('กรุณากรอก username');
            return false;
        }

        if (password == '') {
            alert('กรุณากรอก password');
            return false;
        }

        if (confirm_password == '') {
            alert('กรุณากรอก confirm password');
            return false;
        }

        if (password != confirm_password) {
            alert('password ไม่ตรงกัน');
            return false;
        }

        if (name == '') {
            alert('กรุณากรอก ชื่อ-สกุล');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/settings/users/createusers",
            data: {
                username: username,
                password: password,
                name: name,
                email: email,
                group: group
            },
            dataType: "json",
            success: function (response) {
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getAllUsers(page, txt_search);
                $('#interestModal').addClass('invisible');
                $('#username').val('');
                $('#password').val('');
                $('#email').val('');
                $('#confirm_password').val('');
                $('#name_lname').val('');
            }
        });
    });
});