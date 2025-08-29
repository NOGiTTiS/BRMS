<?php require APPROOT . '/views/templates/layout_admin/header.php'; ?>

<h3 class="text-gray-700 text-3xl font-medium mb-6"><?php echo $data['title']; ?></h3>

<div class="bg-white/80 backdrop-blur-sm rounded-lg shadow-md p-6 max-w-2xl mx-auto">
    <form action="<?php echo URLROOT; ?>/bookingcontroller/create" method="POST" enctype="multipart/form-data">
        
        <?php $selected_equipments = $data['equipments'] ?? []; ?>

        <!-- Room Selection -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="room_id">ห้องประชุม *</label>
            <select name="room_id" id="room_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                <option value="">-- กรุณาเลือกห้อง --</option>
                <?php foreach($data['rooms'] as $room): ?>
                    <option value="<?php echo $room->id; ?>" <?php echo (($data['room_id'] ?? '') == $room->id) ? 'selected' : ''; ?>>
                        <?php echo $room->name; ?> (<?php echo $room->capacity; ?> คน)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Subject -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="subject">หัวข้อการใช้งาน *</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" id="subject" name="subject" type="text" value="<?php echo $data['subject'] ?? ''; ?>">
        </div>

        <!-- Department -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="department">ฝ่าย/งาน</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" id="department" name="department" type="text" value="<?php echo $data['department'] ?? ''; ?>">
        </div>

        <!-- Phone & Attendees -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">เบอร์โทรศัพท์ *</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" id="phone" name="phone" type="text" value="<?php echo $data['phone'] ?? ''; ?>">
            </div>
             <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="attendees">จำนวนผู้เข้าใช้ *</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" id="attendees" name="attendees" type="number" value="<?php echo $data['attendees'] ?? '1'; ?>">
            </div>
        </div>

        <!-- Start & End Time -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="start_time">วันที่เริ่ม *</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" id="start_time" name="start_time" type="datetime-local" value="<?php echo $data['start_time'] ?? ''; ?>">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="end_time">วันที่สิ้นสุด *</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" id="end_time" name="end_time" type="datetime-local" value="<?php echo $data['end_time'] ?? ''; ?>">
            </div>
        </div>

        <!-- Equipments -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">อุปกรณ์</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                <?php foreach($data['all_equipments'] as $equipment): ?>
                    <label class="flex items-center space-x-2 p-2 bg-gray-50 rounded-md">
                        <input type="checkbox" name="equipments[]" value="<?php echo $equipment->id; ?>" class="rounded text-pink-500 focus:ring-pink-400">
                        <span><?php echo $equipment->name; ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Room Layout Image (ฟิลด์ใหม่) -->
        <div class="mb-4">
             <label class="block text-gray-700 text-sm font-bold mb-2" for="room_layout_image">รูปแบบการจัดห้อง (ไฟล์รูปภาพ)</label>
             <input type="file" name="room_layout_image" id="room_layout_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
        </div>

        <!-- Note -->
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="note">หมายเหตุ</label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" id="note" name="note" rows="3"><?php echo $data['note'] ?? ''; ?></textarea>
        </div>
        
        <p class="text-red-500 text-sm mb-4">** หากเป็นการจองในช่วงวันหยุด กรุณาประสานเจ้าหน้าที่ ที่สามารถมาปฏิบัติงานได้ ด้วยตนเอง **</p>

        <!-- Buttons -->
        <div class="flex items-center justify-start">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                จอง
            </button>
            <a href="<?php echo URLROOT; ?>/bookingcontroller" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-4">
                ยกเลิก
            </a>
        </div>
    </form>
</div>

<?php require APPROOT . '/views/templates/layout_admin/footer.php'; ?>