<?php require APPROOT . '/views/templates/layout_admin/header.php'; ?>

<h3 class="text-gray-700 text-3xl font-medium mb-6"><?php echo $data['title']; ?></h3>

<div class="bg-white/80 backdrop-blur-sm rounded-lg shadow-md p-6 max-w-lg mx-auto">
    <form action="<?php echo URLROOT; ?>/usercontroller/edit/<?php echo $data['id']; ?>" method="POST">
        <!-- First Name & Last Name -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">ชื่อจริง</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" id="first_name" name="first_name" type="text" value="<?php echo $data['user']->first_name; ?>">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="last_name">นามสกุล</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" id="last_name" name="last_name" type="text" value="<?php echo $data['user']->last_name; ?>">
            </div>
        </div>

        <!-- Username -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
            <input class="shadow appearance-none border <?php echo (!empty($data['username_err'])) ? 'border-red-500' : ''; ?> rounded w-full py-2 px-3 text-gray-700" id="username" name="username" type="text" value="<?php echo $data['user']->username; ?>">
            <p class="text-red-500 text-xs italic"><?php echo $data['username_err'] ?? ''; ?></p>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
            <input class="shadow appearance-none border <?php echo (!empty($data['email_err'])) ? 'border-red-500' : ''; ?> rounded w-full py-2 px-3 text-gray-700" id="email" name="email" type="email" value="<?php echo $data['user']->email; ?>">
            <p class="text-red-500 text-xs italic"><?php echo $data['email_err'] ?? ''; ?></p>
        </div>
        
        <hr class="my-6">
        
        <p class="text-gray-600 text-sm mb-4"><em>กรอกรหัสผ่านใหม่เฉพาะกรณีที่ต้องการเปลี่ยนแปลงเท่านั้น</em></p>

        <!-- Password -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">รหัสผ่านใหม่</label>
            <input class="shadow appearance-none border <?php echo (!empty($data['password_err'])) ? 'border-red-500' : ''; ?> rounded w-full py-2 px-3 text-gray-700" id="password" name="password" type="password">
            <p class="text-red-500 text-xs italic"><?php echo $data['password_err'] ?? ''; ?></p>
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">ยืนยันรหัสผ่านใหม่</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" id="confirm_password" name="confirm_password" type="password">
        </div>
        
        <!-- Role -->
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="role">สิทธิ์การใช้งาน</label>
            <select name="role" id="role" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                <option value="user" <?php echo ($data['user']->role == 'user') ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo ($data['user']->role == 'admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-start">
            <button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                บันทึกการเปลี่ยนแปลง
            </button>
            <a href="<?php echo URLROOT; ?>/usercontroller" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-4">
                ยกเลิก
            </a>
        </div>
    </form>
</div>

<?php require APPROOT . '/views/templates/layout_admin/footer.php'; ?>