$(document).ready(function () {
    const url_path = window.location.pathname;

    // funtion set table
    function setTable(data) {
        $("#equipmentsTable").empty();
        data.forEach((element) => {
            console.log(element);
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
});