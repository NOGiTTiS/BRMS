<?php require APPROOT . '/views/templates/layout_admin/header.php'; ?>

<style>
    /* --- CSS เดิม (ปรับปรุงเล็กน้อย) --- */
    .fc-button {
        background-color: #ec4899 !important;
        border-color: #ec4899 !important;
        color: white !important;
    }
    .fc-button:hover {
        background-color: #db2777 !important;
    }
    
    /* --- CSS ใหม่สำหรับ Event (แทนที่ของเก่าทั้งหมด) --- */

    /* 1. กำหนดให้ข้อความไม่ขึ้นบรรทัดใหม่และแสดง ... */
    .fc-daygrid-event {
        white-space: nowrap !important;
    }

    /* 2. จัดการกับเวลา */
    .fc-event-time {
        font-weight: 600 !important; /* ทำให้เวลาเป็นตัวหนา */
        padding-right: 5px !important; /* *** สร้างระยะห่างด้านขวาของเวลา *** */
    }

    /* 3. จัดการกับหัวข้อ */
    .fc-event-title {
        display: inline !important; /* ทำให้หัวข้อแสดงต่อจากเวลาในบรรทัดเดียวกัน */
        padding-left: 2px !important; /* เพิ่มช่องว่างเล็กน้อยทางซ้ายของหัวข้อ */
    }
    
    
    
    /* --- CSS ใหม่สำหรับคำอธิบายสี --- */
    .legend-item {
        display: inline-flex;
        align-items: center;
        margin-right: 15px;
        margin-bottom: 10px;
        font-size: 14px;
    }
    .legend-color-box {
        width: 15px;
        height: 15px;
        margin-right: 8px;
        border-radius: 4px;
        border: 1px solid rgba(0,0,0,0.1);
    }
</style>

<div class="bg-white/80 backdrop-blur-sm rounded-lg shadow-md p-6">
    <div id='calendar'></div>
</div>

<!-- เพิ่มส่วนคำอธิบายสี -->
<div class="bg-white/80 backdrop-blur-sm rounded-lg shadow-md p-4 mt-6">
    <h4 class="text-gray-700 font-semibold mb-3">คำอธิบายสี:</h4>
    <div>
        <?php foreach ($data['rooms'] as $room): ?>
            <div class="legend-item">
                <div class="legend-color-box" style="background-color:                                                                       <?php echo $room->color; ?>;"></div>
                <span><?php echo htmlspecialchars($room->name); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<!-- แก้ไข JavaScript ทั้งหมด -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'th',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '<?php echo URLROOT; ?>/calendarcontroller/getEvents',
        displayEventTime: true,
        eventTimeFormat: { // บังคับรูปแบบการแสดงเวลา
            hour: '2-digit',
            minute: '2-digit',
            hour12: false // ใช้รูปแบบ 24 ชั่วโมง
        },

        // --- ส่วนที่อัปเกรด ---

        // 1. ทำให้ Event คลิกได้
        eventClick: function(info) {
            // ป้องกันการทำงานของลิงก์ปกติ
            info.jsEvent.preventDefault();
            // ไปยังหน้ารายละเอียดการจอง
            window.location.href = '<?php echo URLROOT; ?>/bookingcontroller/show/' + info.event.id;
        },

        // 2. ปรับปรุงการแสดงผลข้อความ
        eventDisplay: 'block', // ทำให้สีพื้นหลังเต็มบล็อก

        // 3. แสดง Tooltip เมื่อเอาเมาส์ไปชี้
        eventMouseEnter: function(info) {
            // สร้าง Tooltip ง่ายๆ ด้วย title attribute
            info.el.title = `ห้อง: ${info.event.extendedProps.roomname}\nเรื่อง: ${info.event.title}`;
        }
    });
    calendar.render();
});
</script>

<?php require APPROOT . '/views/templates/layout_admin/footer.php'; ?>