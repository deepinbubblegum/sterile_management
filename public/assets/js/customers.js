$(document).ready(function () {
    // funtion set table
    function setTable(data) {
        $("#customersTable").empty();
        data.forEach((element) => {
            // console.log(element);
            const rowHtml = `
            <tr>
                <td class="border-dashed border-t border-gray-200 action">
                    <span
                        class="text-gray-700 dark:text-light px-1 py-2 flex items-center">
                        <a href="/settings/customers/departments/${element.Customer_id.toLowerCase()}" value="${element.Customer_id}"
                            class="mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                            <i class="fa-regular fa-building fa-xl mx-auto"></i>
                        </a>
                        <button type="button" value="${element.Customer_id}"
                            class="openEditModal mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
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
        activeevent();
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
                // console.log(response.customers.data);
                setTable(response.customers.data);
                $("#txt_firstItem").text(response.customers.from);
                $("#txt_lastItem").text(response.customers.to);
                $("#txt_total").text(response.customers.total);
                $("#lastPage").text(response.customers.last_page);
                $("#page_input").val(response.customers.current_page);

                const btn_first_page =
                    document.querySelector(".btn_first_page");
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

        getCustomers(page, txt_search);
    });

    $("#search").keydown(function (e) {
        if (e.keyCode == 13) {
            let txt_search = $("#search").val();
            getCustomers(null, txt_search);
        }
    });

    function activeevent() {
        $(".delete_customer").click(function (e) {
            e.preventDefault();
            if (confirm("Are you sure you want to delete this customer?")) {
                $.ajax({
                    type: "POST",
                    url: "/settings/customers/deletecustomers",
                    data: {
                        customer_id: $(this).val(),
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 1) {
                            getCustomers();
                        }
                    },
                });
            }
            getCustomers();
        });

        $('.openEditModal').on('click', function(e){
            customer_id = $(this).val();
            // console.log(customer_id);
            $.ajax({
                type: "GET",
                url: "/settings/customers/getcustomersdetail",
                data: {
                    customer_id: customer_id,
                },
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    $('#txt_customer_name').val(response.Customer_name);
                    $('#txt_address').val(response.Address);
                    $('#txt_customer_name').attr('data-id', customer_id);
                    $('#editModal').removeClass('invisible');
                }
            });
        });
        $('.closeModal').on('click', function(e){
            $('#editModal').addClass('invisible');
        });
    }

    // function to update customers
    $("#update_customer").click(function (e) { 
        e.preventDefault();
        customer_id = $("#txt_customer_name").attr('data-id');
        customer_name = $('#txt_customer_name').val();
        customer_address = $('#txt_address').val();

        $.ajax({
            type: "POST",
            url: "/settings/customers/updatecustomers",
            data: {
                customer_id: customer_id,
                customer_name: customer_name,
                customer_address: customer_address,
            },
            dataType: "json",
            success: function (response) {
                getCustomers();
                $('#editModal').addClass('invisible');
            }
        });
    });

    $('.openAddModal').on('click', function(e){
        $('#interestModal').removeClass('invisible');
    });
    $('.closeModal').on('click', function(e){
        $('#interestModal').addClass('invisible');
    });

    // event click add customer
    $("#add_customer").click(function (e) {
        e.preventDefault();
        const customer_name = $("#customer_name").val();
        const address = $("#address").val();
        $("#customer_name").val('');
        $("#address").val('');
        $.ajax({
            type: "POST",
            url: "/settings/customers/createcustomers",
            data: {
                customer_name : customer_name,
                address : address,
            },
            dataType: "json",
            success: function (response) {
                // console.log(response);
                $('#interestModal').addClass('invisible');
                getCustomers();
            }
        });
    });

    $("#page_input").keydown(function (e) { 
        if (e.keyCode == 13) {
            let txt_search = $("#search").val();
            let page = $("#page_input").val();
            getCustomers(page, txt_search);
        }
    });

});
