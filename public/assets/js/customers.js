$(document).ready(function () {
    // funtion set table
    function setTable(data) {
        $("#customersTable").empty();
        data.forEach((element) => {
            console.log(element);
            const rowHtml = `
            <tr>
                <td class="border-dashed border-t border-gray-200 action">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        <button disabled type="button" value="${element.Customer_id}"
                            class="edit_customer mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-regular fa-pen-to-square fa-xl mx-auto"></i>
                        </button>
                        <button type="button" value="${element.Customer_id}"
                            class="delete_customer mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-danger inline-flex items-center hover:bg-danger-dark focus:outline-none focus:ring focus:ring-danger focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-solid fa-trash fa-xl mx-auto"></i>
                        </button>
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
                        ${element.Address ? element.Address : "-"}
                    </span>
                </td>
            </tr>
            `;
            $("#customersTable").append(rowHtml);
        });
    }

    // function to get all customers
    function getCustomers(page = 1, txt_search = "") {
        $.ajax({
            type: "GET",
            url: "/settings/customers/getlistcustomers",
            data: {
                page: page,
                txt_search: txt_search,
            },
            dataType: "json",
            success: function (response) {
                console.log(response.customers.data);
                setTable(response.customers.data);
                $("#txt_firstItem").text(response.customers.from);
                $("#txt_lastItem").text(response.customers.to);
                $("#txt_total").text(response.customers.total);
                $("#lastPage").text(response.customers.last_page);
                $("#page_input").val(response.customers.current_page);

                const btn_first_page = document.querySelector(".btn_first_page");
                btn_first_page.setAttribute(
                    "url_data",
                    response.customers.first_page_url
                );

                const btn_prev_page = document.querySelector(".btn_prev_page");
                btn_prev_page.setAttribute(
                    "url_data",
                    response.customers.prev_page_url
                );

                const btn_next_page = document.querySelector(".btn_next_page");
                btn_next_page.setAttribute(
                    "url_data",
                    response.customers.next_page_url
                );

                const btn_last_page = document.querySelector(".btn_last_page");
                btn_last_page.setAttribute(
                    "url_data",
                    response.customers.last_page_url
                );
            },
        });
    }

    // initial call to get all customers
    getCustomers();
});
