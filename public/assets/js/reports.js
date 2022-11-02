$(document).ready(function () {
    $('#departments_list').select2();
    const url_path = window.location.pathname;
    $('.excel_xlsx_order').click(function (e) { 
        e.preventDefault();
        date_order_start = $('.date_order_start').val();
        date_order_end = $('.date_order_end').val();
        Customer_id = $('#customers_list').val();
        department_id = $('#departments_list').val();

        if ($('#only_Approve').is(':checked')) {
            only_Approve = 1;
        } else {
            only_Approve = 0;
        }

        if (date_order_start == '' || date_order_end == '') {
            alert('Please select date range');
            return false;
        }
        date_order_start_earray = date_order_start.split("/");
        date_order_end_earray = date_order_end.split("/");
        date_order_start = date_order_start_earray[2] + '-' + date_order_start_earray[1] + '-' + date_order_start_earray[0];
        date_order_end = date_order_end_earray[2] + '-' + date_order_end_earray[1] + '-' + date_order_end_earray[0];
        console.log(date_order_start);
        console.log(date_order_end);
        // window.open(url_path + '/export/excel/'+ Customer_id +'/order/' + department_id + '/between/' + date_order_start + '/and/' + date_order_end, '_blank');
        window.open(`${url_path}/export/excel/${Customer_id}/order/${only_Approve}/${department_id}/between/${date_order_start}/and/${date_order_end}`, '_blank');
    });

    function setCustomerslist(data){
        $('#customers_list').empty();
        data.forEach((element) => {
            const html = `<option value="${element.Customer_id}">${element.Customer_name}</option>`;
           $('#customers_list').append(html);
        });
        $('#customers_list').change();
    }

    function getCustomer() {
        $.ajax({
            type: "GET",
            url: "/reports/getlistcustomers",
            dataType: "json",
            success: function (response) {
                setCustomerslist(response);
            }
        });
    }
    
    // init load
    getCustomer();


    function setDepartmentslist(data){
        $('#departments_list').empty();
        const html = `<option value="ALL">เลือกทั้งหมด</option>`;
        $('#departments_list').append(html);
        data.forEach((element) => {
            const html = `<option value="${element.Department_id}">${element.Department_name}</option>`;
           $('#departments_list').append(html);
        });
        $('#departments_list').change();
    }

    $('#customers_list').change(function (e) { 
        e.preventDefault();
        Customer_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "/reports/getlistdepartments",
            data: {
                Customer_id: Customer_id
            },
            dataType: "json",
            success: function (response) {
                setDepartmentslist(response);
            }
        });
    });

});