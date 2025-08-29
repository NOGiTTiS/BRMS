<?php require APPROOT . '/views/templates/layout_admin/header.php'; ?>

<div class="flex justify-between items-center mb-6">
    <h3 class="text-gray-700 text-3xl font-medium"><?php echo $data['title']; ?></h3>
    <a href="<?php echo URLROOT; ?>/usercontroller/create" class="bg-pink-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-pink-600 transition duration-300">
        + เพิ่มผู้ใช้ใหม่
    </a>
</div>

<div class="bg-white/80 backdrop-blur-sm rounded-lg shadow-md p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ชื่อ - สกุล</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Username</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">สิทธิ์</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">การจัดการ</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php foreach($data['users'] as $user) : ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200"><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200"><?php echo $user->username; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200"><?php echo $user->email; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo ($user->role == 'admin') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                            <?php echo $user->role; ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-sm font-medium">
                        <a href="<?php echo URLROOT; ?>/usercontroller/edit/<?php echo $user->id; ?>" class="text-indigo-600 hover:text-indigo-900">แก้ไข</a>
                        <?php if($user->id != $_SESSION['user_id']) : // ซ่อนปุ่มลบ ถ้าเป็น user ตัวเอง ?>
                        <form action="<?php echo URLROOT; ?>/usercontroller/delete/<?php echo $user->id; ?>" method="post" class="inline-block ml-4" onsubmit="return confirm('คุณแน่ใจว่าต้องการลบผู้ใช้นี้?');">
                            <button type="submit" class="text-red-600 hover:text-red-900">ลบ</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APPROOT . '/views/templates/layout_admin/footer.php'; ?>