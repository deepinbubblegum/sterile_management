$(document).ready(function () {
    $(".select2").select2({});

    //Functions
    // function getcustomers() {
    function getcustomers() {
        $.ajax({
            type: "GET",
            url: "/oders/create/getcustomers",
            dataType: "json",
            success: function (response) {
                if (response.length === 1) {
                    response.forEach((element) => {
                        $("#customers").append(
                            `<option selected value="${element.Customer_id}">${element.Customer_name}</option>`
                        );
                        getdepartment(element.Customer_id);
                    });
                } else if (response.length > 1) {
                    response.forEach((element) => {
                        $("#customers").append(
                            `<option value="${element.Customer_id}">${element.Customer_name}</option>`
                        );
                    });
                }
            },
        });
    }

    // function getdepartment()
    function getdepartment(Customer_id) {
        $.ajax({
            type: "GET",
            url: "/oders/create/getdepartments",
            data: {
                Customer_id: Customer_id,
            },
            dataType: "json",
            success: function (response) {
                // console.log(response.length);
                // response.length;
                if (response.length > 0) {
                    $("#departments").prop("disabled", false);
                    $("#departments").empty();
                    $("#departments").append(
                        `<option value="" disabled selected> --- แผนก หรือ หน่วยงาน --- </option>`
                    );
                    response.forEach((element) => {
                        $("#departments").append(
                            `<option value="${element.Department_id}">${element.Department_name}</option>`
                        );
                    });
                } else {
                    $("#departments").prop("disabled", true);
                    $("#departments").empty();
                    $("#departments").append(
                        `<option value="" disabled selected>--- ไม่พบข้อมูล แผนก ภายใต้ สถานพยาบาล หรือ ศูนย์การแพทย์ นี้  ---</option>`
                    );
                }
            },
        });
    }

    // function getequipments()
    function getequipments(Department_id) {
        $.ajax({
            type: "GET",
            url: "/oders/create/getequipments",
            data: {
                Department_id: Department_id,
            },
            dataType: "json",
            success: function (response) {
                // console.log(response);
                $("#item_name").prop("disabled", false);
                $("#item_name").empty();
                $("#item_name").append(
                    `<option value="" disabled selected>--- โปรดเลือกอุปการณ์  ---</option>`
                );
                response.forEach((element) => {
                    $("#item_name").append(
                        `<option data-value='{"Equipment_id" : "${element.Equipment_id}", "Process" : "${element.Process}", "Name" : "", "Situation_id": "", "Situation_name" : "", "qty" : "", "Price" : ${element.Price} }' data-name='${element.Name}' >${element.Name}</option>`
                    );
                });
            },
        });
    }

    function getsituations(params) {
        $.ajax({
            type: "GET",
            url: "/oders/create/getsituations",
            dataType: "json",
            success: function (response) {
                // console.log(response);

                $("#Situation").empty();
                $("#Situation").append(
                    `<option value="false" disabled selected>--- โปรดเลือก  ---</option>`
                );
                response.forEach((element) => {
                    $("#Situation").append(
                        `<option value="${element.Situation_id}">${element.Situation_name}</option>`
                    );
                });
            },
        });
    }

    // function CreateOders()
    function CreateOders(notes_messages, items) {
        $.ajax({
            type: "POST",
            url: "/oders/create/createoders",
            data: {
                notes_messages: notes_messages,
                items: items,
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
            }
        });
    }

    // function addtoTable()
    function addtoTable(val) {
        html_txt = `<tr class="row_data bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td scope="row"
                            class="py-4 px-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <input type="text" name="Equipment_id"
                            class="${val.Equipment_id} bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="" data-value="${val.Equipment_id}" disabled>
                        </td>
                        <td class="py-4 px-1">
                        <input type="text" name="Process" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="${val.Process}" disabled>
                        </td>
                        <td class="py-4 px-1">
                        <input type="text" name="Situation_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="${val.Situation_name}" data-value="${val.Situation_id}" disabled>
                        </td>
                        <td class="py-4 px-1">
                        <input type="number" name="qty"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="จำนวน" value="${val.qty}" disabled>
                        </td>
                        <td class="py-4 px-1">
                        <input type="number"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="${val.Price * val.qty}" disabled>
                        </td>
                        <td class="py-4 px-1 text-center">
                            <button type="button"
                                class="delete-row mr-1 w-10 h-10 px-2 py-2 text-base text-white rounded-md bg-warning inline-flex items-center hover:bg-warning-dark focus:outline-none focus:ring focus:ring-warning focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <i class="fa-solid fa-xmark fa-2xl mx-auto"></i>
                            </button>
                        </td>
                    </tr>`;
        $("table tbody").prepend(html_txt);
        $("." + val.Equipment_id).val(val.Name);
    }

    //Initialize function start here
    getcustomers();
    getsituations();

    $("#customers").on("select2:select", function (e) {
        customers_selected = e.params.data;

        getdepartment(customers_selected.id);

        $("#item_name").prop("disabled", true);
        $("#item_name").empty();
        $("#item_name").append(
            `<option value="" disabled selected>--- โปรดเลือกอุปการณ์  ---</option>`
        );
    });

    $("#departments").on("select2:selecting", function (e) {
        departments_selected = e.params.args.data;
        getequipments(departments_selected.id);
    });

    $("#item_name").change(function (e) {
        e.preventDefault();
        item_name_selected = $("#item_name option:selected").text();
        item_value_selected = $(this).find(":selected").data("value");
        item_value_selected.Name = item_name_selected;
        // console.log(item_value_selected);
        $("#request_reason").val(item_value_selected.Process);
        $("#Situation").prop("disabled", false);
        $("#qty").prop("disabled", false);
        // getdate situtation
        qty = $("#qty").val();
        Price = item_value_selected.Price * qty;
        $("#total_price").val(Price);

        $("#add_item").prop("disabled", false);
    });

    $("#qty").change(function (e) {
        e.preventDefault();
        item_name_selected = $("#item_name option:selected").text();
        item_value_selected = $("#item_name").find(":selected").data("value");
        item_value_selected.Name = item_name_selected;
        qty = $("#qty").val();
        Price = item_value_selected.Price * qty;
        $("#total_price").val(Price);
    });

    $("#add_item").click(function (e) {
        e.preventDefault();
        $("#div_tablefrom").prop("hidden", false);
        $("#div_btn_save").prop("hidden", false);

        item_name_selected = $("#item_name option:selected").text();
        item_value_selected = $("#item_name").find(":selected").data("value");

        situation_value_selected = $("#Situation").find(":selected").val();
        if (situation_value_selected == "false") {
            alert("โปรดเลือก Situation");
            return false;
        }
        situation_text_selected = $("#Situation").find(":selected").text();
        qty = $("#qty").val();

        item_value_selected.Name = item_name_selected;
        item_value_selected.Situation_id = situation_value_selected;
        item_value_selected.Situation_name = situation_text_selected;
        item_value_selected.qty = qty;
        // console.log(item_value_selected);
        addtoTable(item_value_selected);

        $(".delete-row").click(function (e) {
            e.preventDefault();
            // console.log("delete");
            $(this).parents("tr").remove();
        });
    });

    $("#div_btn_save").click(function (e) {
        e.preventDefault();
        notes_messages = $("#notes_messages").val();
        var tbl = $('#tbody_data tr:has(td)').map(function(index, cell) {
            var $td = $('td', this);
                return {
                    // id: ++index,
                    equipment_id: $td.eq(0).find('input').data('value'),
                    situation: $td.eq(2).find('input').data('value'),
                    qty: $td.eq(3).find('input').val()
                }
        }).get();
        console.log(tbl);
        CreateOders(notes_messages, tbl);
    });
});
