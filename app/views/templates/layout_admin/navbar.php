<header class="flex items-center justify-between px-6 py-4 bg-white/40 backdrop-blur-sm border-b-2 border-white/20">
    <div class="flex items-center">
        <!-- Mobile open button -->
        <button id="open-sidebar-btn" class="text-gray-600 focus:outline-none md:hidden">
            <ion-icon name="menu-outline" class="w-6 h-6"></ion-icon>
        </button>

        <h1 class="relative text-2xl font-semibold text-gray-700 ml-3"><?php echo $data['title']; ?></h1>
    </div>

    <div class="flex items-center">
        <div class="text-right mr-4 hidden sm:block">
            <p class="font-semibold text-gray-700"><?php echo $_SESSION['user_first_name']; ?></p>
            <p class="text-xs text-gray-500 capitalize"><?php echo $_SESSION['user_role']; ?></p>
        </div>
        
        <a href="<?php echo URLROOT; ?>/usercontroller/logout" class="block bg-pink-500 text-white p-2 rounded-full text-sm font-medium hover:bg-pink-600" title="ออกจากระบบ">
            <ion-icon name="log-out-outline" class="w-5 h-5"></ion-icon>
        </a>
    </div>
</header>