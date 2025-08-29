<?php require APPROOT . '/views/templates/layout_admin/header.php'; ?>

<div class="flex justify-between items-center mb-6">
    <h3 class="text-gray-700 text-3xl font-medium"><?php echo $data['title']; ?></h3>
    <a href="<?php echo URLROOT; ?>/equipmentcontroller/create" class="bg-pink-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-pink-600 transition duration-300">
        + เพิ่มอุปกรณ์ใหม่
    </a>
</div>

<div class="bg-white/80 backdrop-blur-sm rounded-lg shadow-md p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ชื่ออุปกรณ์</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">รายละเอียด</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">การจัดการ</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php foreach($data['equipments'] as $equipment) : ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                        <span class="font-medium text-gray-800"><?php echo $equipment->name; ?></span>
                    </td>
                    <td class="px-6 py-4 border-b border-gray-200">
                        <?php echo $equipment->description; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-sm font-medium">
                        <a href="<?php echo URLROOT; ?>/equipmentcontroller/edit/<?php echo $equipment->id; ?>" class="text-indigo-600 hover:text-indigo-900">แก้ไข</a>
                        <form action="<?php echo URLROOT; ?>/equipmentcontroller/delete/<?php echo $equipment->id; ?>" method="post" class="inline-block ml-4" onsubmit="return confirm('คุณแน่ใจว่าต้องการลบอุปกรณ์นี้?');">
                            <button type="submit" class="text-red-600 hover:text-red-900">ลบ</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/views/templates/layout_admin/footer.php'; ?>