                <!-- End Content Here -->
            </div>
        </main>
    </div>
</div>

<script>
    // JavaScript for Mobile Sidebar Toggle
    const sidebar = document.getElementById('sidebar');
    const openBtn = document.getElementById('open-sidebar-btn');
    const closeBtn = document.getElementById('close-sidebar-btn');

    // เพิ่มการตรวจสอบเผื่อบางหน้าไม่มีปุ่มนี้
    if(openBtn && closeBtn){
        openBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
        });

        closeBtn.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });
    }
</script>

<?php 
// เรียกใช้ฟังก์ชันแสดง SweetAlert ที่นี่
// นี่คือจุดที่สำคัญที่สุดที่ขาดไป
displaySweetAlert('flash_message'); 
?>

</body>
</html>