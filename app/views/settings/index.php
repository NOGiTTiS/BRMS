<?php require APPROOT . '/views/templates/layout_admin/header.php'; ?>

<h3 class="text-gray-700 text-3xl font-medium mb-6"><?php echo $data['title']; ?></h3>

<div class="bg-white/80 backdrop-blur-sm rounded-lg shadow-md p-6 max-w-lg mx-auto">
    <form action="<?php echo URLROOT; ?>/settingcontroller/index" method="POST">
        
        <!-- Default Booking Status -->
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="default_status">
                สถานะการจองเริ่มต้น (เมื่อผู้ใช้สร้างการจองใหม่)
            </label>
            <select name="default_status" id="default_status" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                <?php $current_status = $data['settings']['default_booking_status'] ?? 'pending'; ?>
                <option value="pending" <?php echo ($current_status == 'pending') ? 'selected' : ''; ?>>
                    รออนุมัติ (Pending)
                </option>
                <option value="approved" <?php echo ($current_status == 'approved') ? 'selected' : ''; ?>>
                    อนุมัติอัตโนมัติ (Approved)
                </option>
            </select>
            <p class="text-xs text-gray-600 mt-2">
                หากเลือก "อนุมัติอัตโนมัติ" การจองใหม่ทั้งหมดจะไม่ต้องรอการอนุมัติจาก Admin
            </p>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-start">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                บันทึก
            </button>
        </div>

    </form>
</div>

<?php require APPROOT . '/views/templates/layout_admin/footer.php'; ?>