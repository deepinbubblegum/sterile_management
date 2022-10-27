$(document).ready(function () {
    // set table
    function setTable(data) {
        $('#GroupTable').empty();
        data.forEach((element) => {
            const rowHtml = `
                <tr>
                    <td class="border-dashed border-t border-gray-200 action">
                        <span
                            class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                            <button type="button" value="${element.Group_id}"
                                class="openSettings mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-solid fa-screwdriver-wrench fa-xl mx-auto"></i>
                            </button>
                            <button type="button" value="${element.Group_id}"
                                class="openEditModal mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-regular fa-pen-to-square fa-xl mx-auto"></i>
                            </button>
                            <button type="button" value="${element.Group_id}"
                                class="delete_equipments mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-solid fa-trash fa-xl mx-auto"></i>
                            </button>
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
            $("#GroupTable").append(rowHtml);
        });
        initElement();
    }

    // get list of groups
    function getGroups(page = 1, txt_search = "") {
        $.ajax({
            type: "GET",
            url: "/settings/groups/getlistgroups",
            data: {
                page: page,
                txt_search: txt_search,
            },
            dataType: "json",
            success: function (response) {
                // console.log(response.groups.data);
                setTable(response.groups.data);
                $("#txt_firstItem").text(response.groups.from);
                $("#txt_lastItem").text(response.groups.to);
                $("#txt_total").text(response.groups.total);
                $("#lastPage").text(response.groups.last_page);
                $("#page_input").val(response.groups.current_page);

                const btn_first_page =
                    document.querySelector(".btn_first_page");
                btn_first_page.setAttribute(
                    "url_data",
                    response.groups.first_page_url
                );

                const btn_prev_page = document.querySelector(".btn_prev_page");
                btn_prev_page.setAttribute(
                    "url_data",
                    response.groups.prev_page_url
                );

                const btn_next_page = document.querySelector(".btn_next_page");
                btn_next_page.setAttribute(
                    "url_data",
                    response.groups.next_page_url
                );

                const btn_last_page = document.querySelector(".btn_last_page");
                btn_last_page.setAttribute(
                    "url_data",
                    response.groups.last_page_url
                );

            }
        });
    }

    // initialize function
    getGroups();

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

        getGroups(page, txt_search);
    });

    $("#search").keydown(function (e) {
        let txt_search = $("#search").val();
        getGroups(null, txt_search);
    });

    // open modal add
    $('.openAddModal').on('click', function(e){
        $('#interestModal').removeClass('invisible');
    });
    $('.closeModal').on('click', function(e){
        $('#interestModal').addClass('invisible');
        $('#settingsModal').addClass('invisible');
        $('#editModal').addClass('invisible');
    });

    // open modal settings
    function settingsModal(data){
        $('#SettingPermissions').empty();
        data.forEach((element) => {
            // console.log(element);
            const eleHtml = `
                <label for="${element.Permission_ID}" class="inline-flex relative items-center cursor-pointer">
                    <input name="permissions" type="checkbox" value="" data-permission_id="${element.Permission_ID}" data-group_id="${element.Group_ID}" id="${element.Permission_ID}" class="sr-only peer" ${element.Active != 0 ? 'checked' : ''}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">${element.Permission_Allow}</span>
                </label>
            `;
            $('#SettingPermissions').append(eleHtml);
        });
    }

    // open modal settings
    function initElement(){
        $('.openSettings').on('click', function(e){
            const id = $(this).val();
            // console.log(id);
            $.ajax({
                type: "GET",
                url: "/settings/groups/getpermissionsgroup",
                data: {
                    group_id: id,
                },
                dataType: "json",
                success: function (response) {
                    settingsModal(response);
                    $('#settingsModal').removeClass('invisible');
                }
            });
        });

        $('.openEditModal').on('click', function(e){
            const id = $(this).val();
            $.ajax({
                type: "GET",
                url: "/settings/groups/getgroupsdetail",
                data: {
                    group_id: id,
                },
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('#edit_name').val(response.Group_name);
                    $('#edit_name').attr('data-value', response.Group_id);
                    $('#editModal').removeClass('invisible');
                }
            });
        });
        
        $('.delete_equipments').click(function (e) { 
            e.preventDefault();
            const id = $(this).val();
            if (confirm('Are you sure you want to delete this group?')) {
                $.ajax({
                    type: "POST",
                    url: "/settings/groups/deletegroups",
                    data: {
                        group_id: id,
                    },
                    dataType: "json",
                    success: function (response) {
                        let page = $('#page_input').val();
                        let txt_search = $("#search").val();
                        getGroups(page, txt_search);
                    }
                });
            }
        });
    }

    // add group
    $('#add_group').click(function (e) { 
        e.preventDefault();
        const group_name = $('#group_name').val();
        if (group_name == '') {
            alert('Please enter group name');
            return;
        }
        $.ajax({
            type: "POST",
            url: "/settings/groups/creategroups",
            data: {
                group_name: group_name,
            },
            dataType: "json",
            success: function (response) {
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getGroups(page, txt_search);
                $('#interestModal').addClass('invisible');
            }
        });
    });

    // edit group
    $('#edit_group').click(function (e) {
        e.preventDefault();
        const group_name = $('#edit_name').val();
        const group_id = $('#edit_name').attr('data-value');
        if (group_name == '') {
            alert('Please enter group name');
            return;
        }
        $.ajax({
            type: "POST",
            url: "/settings/groups/updategroups",
            data: {
                group_name: group_name,
                group_id: group_id,
            },
            dataType: "json",
            success: function (response) {
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getGroups(page, txt_search);
                $('#editModal').addClass('invisible');
            }
        });
    });

    function eleActive(){
        $("#SettingPermissions input:checkbox").map(function () {
            return $(this).data('id')
        }).get();
    }

    $('#setting_permissions').click(function (e) { 
        e.preventDefault();
        const permissions = $("#SettingPermissions input:checkbox").map(function () {
            return {
                permission_id: $(this).data('permission_id'),
                group_id: $(this).data('group_id'),
                active: $(this).is(":checked") ? 1 : 0
            }
        }).get();

        $.ajax({
            type: "POST",
            url: "/settings/groups/updatepermissionsgroup",
            data: {
                permissions: permissions,
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                let page = $('#page_input').val();
                let txt_search = $("#search").val();
                getGroups(page, txt_search);
                $('#settingsModal').addClass('invisible');
            }
        });
    });
});