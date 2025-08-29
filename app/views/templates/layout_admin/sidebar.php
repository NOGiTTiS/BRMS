<!-- Static sidebar for desktop -->
<div id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 px-4 py-8 overflow-y-auto bg-gradient-to-br from-pink-200 via-purple-200 to-indigo-300 backdrop-blur-lg shadow-lg transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-200 ease-in-out">
    <div class="flex items-center justify-between">
        <a href="<?php echo URLROOT; ?>/pagecontroller/dashboard" class="text-2xl font-bold text-pink-600">
            BRMS
        </a>
        <!-- Mobile close button -->
        <button id="close-sidebar-btn" class="text-gray-600 md:hidden hover:text-gray-800">
            <ion-icon name="close-outline" class="w-6 h-6"></ion-icon>
        </button>
    </div>

    <nav class="mt-8">
        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">เมนูหลัก</h3>
        <div class="mt-2 -mx-3">
            <a href="<?php echo URLROOT; ?>/pagecontroller/dashboard" class="flex justify-between items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-pink-200/50">
                <span class="flex items-center">
                    <ion-icon name="grid-outline" class="w-5 h-5"></ion-icon>
                    <span class="mx-3 font-medium">ภาพรวม (Dashboard)</span>
                </span>
            </a>
            <a href="<?php echo URLROOT; ?>/calendarcontroller/index" class="flex justify-between items-center px-3 py-2 mt-2 text-gray-700 rounded-lg hover:bg-pink-200/50">
                 <span class="flex items-center">
                    <ion-icon name="today-outline" class="w-5 h-5"></ion-icon>
                    <span class="mx-3 font-medium">ปฏิทิน</span>
                </span>
            </a>
            <a href="<?php echo URLROOT; ?>/bookingcontroller/index" class="flex justify-between items-center px-3 py-2 mt-2 text-gray-700 rounded-lg hover:bg-pink-200/50">
                 <span class="flex items-center">
                    <ion-icon name="calendar-outline" class="w-5 h-5"></ion-icon>
                    <span class="mx-3 font-medium">การจองทั้งหมด</span>
                </span>
            </a>
             <a href="<?php echo URLROOT; ?>/bookingcontroller/create" class="flex justify-between items-center px-3 py-2 mt-2 text-gray-700 rounded-lg hover:bg-pink-200/50">
                 <span class="flex items-center">
                    <ion-icon name="add-circle-outline" class="w-5 h-5"></ion-icon>
                    <span class="mx-3 font-medium">จองห้องประชุม</span>
                </span>
            </a>
        </div>

        <?php // --- เริ่มเงื่อนไขตรวจสอบ Admin --- ?>
        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') : ?>

        <h3 class="mt-8 text-xs font-semibold text-gray-500 uppercase tracking-wide">จัดการข้อมูล</h3>
        <div class="mt-2 -mx-3">
            <a href="<?php echo URLROOT; ?>/roomcontroller/index" class="flex justify-between items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-pink-200/50">
                <span class="flex items-center">
                    <ion-icon name="business-outline" class="w-5 h-5"></ion-icon>
                    <span class="mx-3 font-medium">จัดการห้องประชุม</span>
                </span>
            </a>
            <a href="<?php echo URLROOT; ?>/equipmentcontroller/index" class="flex justify-between items-center px-3 py-2 mt-2 text-gray-700 rounded-lg hover:bg-pink-200/50">
                 <span class="flex items-center">
                    <ion-icon name="hardware-chip-outline" class="w-5 h-5"></ion-icon>
                    <span class="mx-3 font-medium">จัดการอุปกรณ์</span>
                </span>
            </a>
             <a href="<?php echo URLROOT; ?>/usercontroller/index" class="flex justify-between items-center px-3 py-2 mt-2 text-gray-700 rounded-lg hover:bg-pink-200/50">
                 <span class="flex items-center">
                    <ion-icon name="people-outline" class="w-5 h-5"></ion-icon>
                    <span class="mx-3 font-medium">จัดการผู้ใช้งาน</span>
                </span>
            </a>
            <a href="<?php echo URLROOT; ?>/settingcontroller/index" class="flex justify-between items-center px-3 py-2 mt-2 text-gray-700 rounded-lg hover:bg-pink-200/50">
                 <span class="flex items-center">
                    <ion-icon name="settings-outline" class="w-5 h-5"></ion-icon>
                    <span class="mx-3 font-medium">ตั้งค่าระบบ</span>
                </span>
            </a>
        </div>

        <?php endif; ?>
    </nav>
</div>