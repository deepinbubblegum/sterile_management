$(document).ready(function () {
    const url_path = window.location.pathname;

    // funtion set table
    function setTable(data) {
        $("#equipmentsTable").empty();
        data.forEach((element) => {
            console.log(element);
            const rowHtml = `
            <tr>
                <td
                    class="border-dashed border-t border-gray-200 Order_id">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-6 py-2 flex items-center">
                        ${element.Name}
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
                        ${element.Customer_name}
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 Order_id">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Department_name}
                    </span>
                </td>
                <td class="border-dashed border-t border-gray-200 action">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        <button type="button" data-equip="${element.Equipment_id}" data-dept="${element.Department_id}"
                            class="delete_equipments mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-solid fa-trash fa-xl mx-auto"></i>
                        </button>
                    </span>
                </td>
            </tr>
            `;
            $("#equipmentsTable").append(rowHtml);
        });
    }

    // function to get all deptequip
    function getDeptequip(page = 1, txt_search = "") {
        $.ajax({
            type: "GET",
            url: `${url_path}/getlistdeptequip`,
            data: {
                page: page,
                txt_search: txt_search,
            },
            dataType: "json",
            success: function (response) {
                // console.log(response.deptequip.data);
                setTable(response.deptequip.data);
                $("#txt_firstItem").text(response.deptequip.from);
                $("#txt_lastItem").text(response.deptequip.to);
                $("#txt_total").text(response.deptequip.total);
                $("#lastPage").text(response.deptequip.last_page);
                $("#page_input").val(response.deptequip.current_page);

                const btn_first_page =
                    document.querySelector(".btn_first_page");
                btn_first_page.setAttribute(
                    "url_data",
                    response.deptequip.first_page_url
                );

                const btn_prev_page = document.querySelector(".btn_prev_page");
                btn_prev_page.setAttribute(
                    "url_data",
                    response.deptequip.prev_page_url
                );

                const btn_next_page = document.querySelector(".btn_next_page");
                btn_next_page.setAttribute(
                    "url_data",
                    response.deptequip.next_page_url
                );

                const btn_last_page = document.querySelector(".btn_last_page");
                btn_last_page.setAttribute(
                    "url_data",
                    response.deptequip.last_page_url
                );
            },
        });
    }

    // initial call to get all deptequip
    getDeptequip();

    $('#page_input').keydown(function (e) {
        if (e.keyCode == 13) {
            let page = $('#page_input').val();
            let txt_search = $("#search").val();
            getDeptequip(page, txt_search);
        }
    });

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

        getDeptequip(page, txt_search);
    });

    $("#search").keydown(function (e) {
        let txt_search = $("#search").val();
        getDeptequip(null, txt_search);
    });
});