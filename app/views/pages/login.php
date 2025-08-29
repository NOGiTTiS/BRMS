<?php require APPROOT . '/views/templates/header.php'; ?>

<main class="min-h-screen flex items-center justify-center p-4">
    <!-- Login Card -->
    <div class="w-full max-w-md bg-white/40 backdrop-blur-lg rounded-xl shadow-2xl p-8 space-y-6">
        
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-800">ระบบจองห้องประชุม</h1>
            <p class="text-gray-600 mt-1">BRMS - Booking Room Management System</p>
        </div>

        <!-- Login Form -->
        <form action="<?php echo URLROOT; ?>/usercontroller/login" method="POST" class="space-y-4">
            
            <!-- Username Field -->
            <div>
                <label for="username" class="text-sm font-medium text-gray-700">ชื่อผู้ใช้งาน</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white/50 border <?php echo (!empty($data['username_err'])) ? 'border-red-500' : 'border-gray-300'; ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 transition"
                    placeholder="กรอกชื่อผู้ใช้งาน"
                    value="<?php echo $data['username'] ?? ''; ?>"
                >
                <span class="text-red-500 text-xs"><?php echo $data['username_err'] ?? ''; ?></span>
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="text-sm font-medium text-gray-700">รหัสผ่าน</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full px-4 py-2 mt-1 text-gray-700 bg-white/50 border <?php echo (!empty($data['password_err'])) ? 'border-red-500' : 'border-gray-300'; ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 transition"
                    placeholder="กรอกรหัสผ่าน"
                >
                <span class="text-red-500 text-xs"><?php echo $data['password_err'] ?? ''; ?></span>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full px-4 py-3 font-bold text-white bg-pink-500 rounded-lg hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-700 transition-transform transform hover:scale-105">
                    เข้าสู่ระบบ
                </button>
            </div>

        </form>

        <!-- Footer Text in Card -->
        <p class="text-center text-xs text-gray-600">
            &copy; <?php echo date('Y'); ?> BRMS Project. All rights reserved.
        </p>
    </div>
</main>

<?php require APPROOT . '/views/templates/footer.php'; ?>