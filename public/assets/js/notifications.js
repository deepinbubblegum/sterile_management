$(document).ready(function () {
    // set display notifications
    function setNotificationsToDisplay(notifications) {
        // length = notifications.length;
        // console.log(`length: ${length}`);


        $('#sidebar_notifications').empty();
        notifications_readed = 0;
        notifications.forEach(function (notification) {
            // console.log(notification);
            notifications_readed = notification.notifications_readed == 0 ? notifications_readed + 1 : notifications_readed;
            const notificationHtml = `
            <div
                class="openAddModal px-4 cursor-pointer transition-colors dark:text-gray-400 dark:hover:text-light hover:text-gray-700" data-value="${notification.notifications_id}">
                <p>
                    มีการแก้ไขข้อมูล ออเดอร์หมายเลข 
                    <span class="text-md font-semibold">${notification.Order_id} </span> <br>
                    ในแผนก <span class="text-md font-semibold"> ${notification.Department_name} </span> <br>
                    โดย <span class="text-md font-semibold">${notification.Name}</span> <br>
                    วันที่เวลา <span class="text-md font-semibold">${notification.Create_at}</span> 
                </p>
                <hr class="mx-auto w-full h-1 bg-gray-100 rounded border-0 md:my-4 dark:bg-gray-700">
            </div>
            `;
            $('#sidebar_notifications').append(notificationHtml);
        });
        if (notifications_readed > 0) {
            $('#div_noti').removeClass('invisible');
            $('#num_noti').text(notifications_readed);
        }else{
            $('#div_noti').addClass('invisible');
        }
        initevent();
    }

    function loadNotifications(){
        $.ajax({
            type: "GET",
            url: "/notifications",
            dataType: "json",
            success: function (response) {
                // console.log(response);
                setNotificationsToDisplay(response);
            }
        });
    };

    // init notifications load
    loadNotifications();
    setInterval(() => {
        loadNotifications();
    }, 15000);

    function NotificationsEditOrderUI(NotificationsDetail){
        $('.detail_edit_show').empty();
        NotificationsDetail.forEach(function (notification) {
            const notificationUIHtml = `
                <p class="p-1">
                    ${notification.Action == 'Add' ? 'เพิ่ม' : 'แก้ไข'} อุปกรณ์ <span class="text-base font-semibold">${notification.Name}</span> 
                    Situation <span class="text-base font-semibold">${notification.situation_from} ${notification.situation_to != null ? 'แก้ไขเป็น ' + notification.situation_to : ''}</span>
                    จำนวน <span class="text-base font-semibold">${notification.Quantity_from} ชิ้น ${notification.Quantity_to != null ? 'แก้ไขเป็น ' + notification.Quantity_to + ' ชิ้น': ''}</span><br>         
                </p>
            `;

            $('.detail_edit_show').append(notificationUIHtml);
        });
    };

    function loadNotificationsEditOrder(noti_id){
        $.ajax({
            type: "GET",
            url: "/notificationsdetails",
            data: {
                noti_id: noti_id
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                NotificationsEditOrderUI(response);
                $('#notificationModal').removeClass('invisible');
                $.ajax({
                    type: "POST",
                    url: "/notificationreaded",
                    data: {
                        noti_id: noti_id
                    },
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                    }
                });
            }
        });
    };

    function initevent(){
        $('.openAddModal').on('click', function(e){
            e.preventDefault();
            var noti_id = $(this).data('value');
            // console.log(noti_id);
            loadNotificationsEditOrder(noti_id);
        });
        $('.closeModal').on('click', function(e){
            e.preventDefault();
            $('#notificationModal').addClass('invisible');
            loadNotifications();
        }); 
    }
});