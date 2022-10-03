$(document).ready(function () {
    // set table
    function setTable(data) {
        $("#orderTable").empty();
        data.forEach((element) => {
            console.log(element);
            const rowHtml = `
            <tr>
                <td class="border-dashed border-t border-gray-200 px-3">
                    <label
                        class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                        <input type="checkbox"
                            class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline bg-white dark:bg-dark dark:text-light">
                    </label>
                </td>
                <td class="border-dashed border-t border-gray-200 action">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        <button target="_blank"
                            class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-regular fa-pen-to-square fa-xl mx-auto"></i>
                        </button>
                        <button target="_blank"
                            class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-solid fa-print fa-xl mx-auto"></i>
                        </button>
                        <button target="_blank"
                            class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-solid fa-trash fa-xl mx-auto"></i>
                        </button>
                        <button target="_blank"
                            class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-warning inline-flex items-center hover:bg-warning-dark focus:outline-none focus:ring focus:ring-warning focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-solid fa-xmark fa-2xl mx-auto"></i>
                        </button>
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 Order_id">
                    <span
                        class="text-nowrap text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Order_id}
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 customerName">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                    </span>
                </td>
                <td
                    class="border-dashed border-t border-gray-200 departmentsName">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                    </span>
                </td>
                <td class="border-dashed border-t border-gray-200 notes">
                    <span
                        class="cut-text w-32 text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Notes != null ? element.Notes : '-'}
                    </span>
                </td>
                <td class="border-dashed border-t border-gray-200 created_by">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.userCreate}
                    </span>
                </td>
                <td class="border-dashed border-t border-gray-200 created_at">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Create_at}
                    </span>
                </td>
                <td class="border-dashed border-t border-gray-200 Approve_by">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.userApprove != null ? element.userApprove : '-'}
                    </span>
                </td>
                <td class="border-dashed border-t border-gray-200 Approve_by">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        ${element.Approve_at != null ? element.Approve_at : '-'}
                    </span>
                </td>
            </tr>
            `;
            $("#orderTable").append(rowHtml);
        });
    }

    // function get list of order
    function getListOrder(page = 1) {
        $.ajax({
            type: "GET",
            url: "/orders/getlistorder",
            data: {
                page: page,
            },
            dataType: "json",
            success: function (response) {
                // console.log(response.orders.data);
                setTable(response.orders.data);
                $("#txt_firstItem").text(response.orders.from);
                $("#txt_lastItem").text(response.orders.to);
                $("#txt_total").text(response.orders.total);
                $("#lastPage").text(response.orders.last_page);
                $("#page_input").val(response.orders.current_page);

                const btn_first_page =
                    document.querySelector(".btn_first_page");
                btn_first_page.setAttribute(
                    "url_data",
                    response.orders.first_page_url
                );

                const btn_prev_page = document.querySelector(".btn_prev_page");
                btn_prev_page.setAttribute(
                    "url_data",
                    response.orders.prev_page_url
                );

                const btn_next_page = document.querySelector(".btn_next_page");
                btn_next_page.setAttribute(
                    "url_data",
                    response.orders.next_page_url
                );

                const btn_last_page = document.querySelector(".btn_last_page");
                btn_last_page.setAttribute(
                    "url_data",
                    response.orders.last_page_url
                );
            },
        });
    }

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

        // let txt_search = $("#txt_search").val();

        getListOrder(page);
    });

    // init function
    getListOrder();
});
