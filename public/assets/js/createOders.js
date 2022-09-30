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
                console.log(response);
                $("#item_name").prop("disabled", false);
                $("#item_name").empty();
                $("#item_name").append(
                    `<option value="" disabled selected>--- โปรดเลือกอุปการณ์  ---</option>`
                );
                response.forEach((element) => {
                    $("#item_name").append(
                        `<option data-value='{"Equipment_id" : "${element.Equipment_id}", "Process" : "${element.Process}", "Name" : "", "Price" : ${element.Price} }' data-name='${ element.Name}' >${element.Name}</option>`
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
                    `<option value="" disabled selected>--- โปรดเลือก  ---</option>`
                );
                response.forEach((element) => {
                    $("#Situation").append(
                        `<option value="${element.Situation_id}">${element.Situation_name}</option>`
                    );
                });
            }
        });
    }

    //Initialize function start here
    getcustomers();
    getsituations();

    $("#customers").on("select2:select", function (e) {
        customers_selected = e.params.data;

        getdepartment(customers_selected.id);
    });

    $("#departments").on("select2:selecting", function (e) {
        departments_selected = e.params.args.data;
        getequipments(departments_selected.id);
    });

    $("#item_name").change(function(e){
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
});
