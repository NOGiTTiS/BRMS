<?php require APPROOT . '/views/templates/layout_admin/header.php'; ?>

<h3 class="text-gray-700 text-3xl font-medium mb-6"><?php echo $data['title']; ?></h3>

<div class="bg-white/80 backdrop-blur-sm rounded-lg shadow-md p-6">
    <form action="<?php echo URLROOT; ?>/equipmentcontroller/create" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                ชื่ออุปกรณ์
            </label>
            <input class="shadow appearance-none border <?php echo (!empty($data['name_err'])) ? 'border-red-500' : ''; ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" type="text" placeholder="เช่น โปรเจคเตอร์, ไวท์บอร์ด" value="<?php echo $data['name']; ?>">
            <span class="text-red-500 text-xs italic"><?php echo $data['name_err'] ?? ''; ?></span>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                รายละเอียด
            </label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="3" placeholder="รายละเอียดเพิ่มเติมเกี่ยวกับอุปกรณ์..."><?php echo $data['description']; ?></textarea>
        </div>

        <div class="flex items-center justify-start">
            <button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                บันทึก
            </button>
            <a href="<?php echo URLROOT; ?>/equipmentcontroller" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-4">
                ยกเลิก
            </a>
        </div>
    </form>
</div>

<?php require APPROOT . '/views/templates/layout_admin/footer.php'; ?>