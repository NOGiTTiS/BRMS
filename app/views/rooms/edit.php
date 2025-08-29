<?php require APPROOT . '/views/templates/layout_admin/header.php'; ?>

<h3 class="text-gray-700 text-3xl font-medium mb-6"><?php echo $data['title']; ?></h3>

<div class="bg-white/80 backdrop-blur-sm rounded-lg shadow-md p-6">
    <form action="<?php echo URLROOT; ?>/roomcontroller/edit/<?php echo $data['id']; ?>" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                ชื่อห้องประชุม
            </label>
            <input class="shadow appearance-none border <?php echo (!empty($data['name_err'])) ? 'border-red-500' : ''; ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" type="text" value="<?php echo $data['room']->name; ?>">
            <span class="text-red-500 text-xs italic"><?php echo $data['name_err'] ?? ''; ?></span>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="capacity">
                ความจุ (คน)
            </label>
            <input class="shadow appearance-none border <?php echo (!empty($data['capacity_err'])) ? 'border-red-500' : ''; ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="capacity" name="capacity" type="number" value="<?php echo $data['room']->capacity; ?>">
            <span class="text-red-500 text-xs italic"><?php echo $data['capacity_err'] ?? ''; ?></span>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                รายละเอียด
            </label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="3"><?php echo $data['room']->description; ?></textarea>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="color">
                สีสำหรับปฏิทิน
            </label>
            <input class="shadow appearance-none border rounded w-20 h-10 p-1" id="color" name="color" type="color" value="<?php echo $data['room']->color; ?>">
        </div>

        <div class="flex items-center justify-start">
            <button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                บันทึกการเปลี่ยนแปลง
            </button>
            <a href="<?php echo URLROOT; ?>/roomcontroller" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-4">
                ยกเลิก
            </a>
        </div>
    </form>
</div>

<?php require APPROOT . '/views/templates/layout_admin/footer.php'; ?>