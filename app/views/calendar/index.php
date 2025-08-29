<?php require APPROOT . '/views/templates/layout_admin/header.php'; ?>

<!-- เราจะเพิ่ม CSS สำหรับปุ่ม FullCalendar ให้สวยงามขึ้นเล็กน้อย -->
<style>
    .fc-button {
        background-color: #ec4899 !important;
        border-color: #ec4899 !important;
    }
    .fc-button:hover {
        background-color: #db2777 !important;
    }
    .fc-daygrid-event {
        white-space: normal !important; /* Allow event text to wrap */
        align-items: normal !important;
    }
</style>

<div class="bg-white/80 backdrop-blur-sm rounded-lg shadow-md p-6">
    <div id='calendar'></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // มุมมองเริ่มต้น
        locale: 'th', // ตั้งค่าภาษาไทย
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay' // ปุ่มเปลี่ยนมุมมอง
        },
        events: '<?php echo URLROOT; ?>/calendarcontroller/getEvents', // URL สำหรับดึงข้อมูล Event
        eventColor: '#378006', // สีเริ่มต้น (จะถูก override ด้วยสีของห้อง)
        eventDidMount: function(info) {
            // ใช้สีจาก database ที่เราดึงมา
            if (info.event.extendedProps.color) {
                info.el.style.backgroundColor = info.event.extendedProps.color;
                info.el.style.borderColor = info.event.extendedProps.color;
            }
        }
    });
    calendar.render();
});
</script>


<?php require APPROOT . '/views/templates/layout_admin/footer.php'; ?>