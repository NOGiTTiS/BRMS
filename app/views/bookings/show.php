<?php require APPROOT . '/views/templates/layout_admin/header.php'; ?>

<h3 class="text-gray-700 text-3xl font-medium mb-6"><?php echo $data['title']; ?></h3>

<div class="bg-white/80 backdrop-blur-sm rounded-lg shadow-md p-6 max-w-3xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="md:col-span-2 space-y-4">
            <div>
                <h4 class="text-sm font-semibold text-gray-500">หัวข้อการประชุม</h4>
                <p class="text-lg text-gray-800 font-medium"><?php echo $data['booking']->subject; ?></p>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-500">ห้องประชุม</h4>
                <p class="text-lg text-gray-800"><?php echo $data['booking']->room_name; ?></p>
            </div>
             <div>
                <h4 class="text-sm font-semibold text-gray-500">ฝ่าย/งาน</h4>
                <p class="text-lg text-gray-800"><?php echo !empty($data['booking']->department) ? $data['booking']->department : '-'; ?></p>
            </div>
            
            <div>
                <h4 class="text-sm font-semibold text-gray-500">เวลา</h4>
                <p class="text-lg text-gray-800">
                    <?php echo date('d M Y, H:i', strtotime($data['booking']->start_time)); ?>
                    ถึง
                    <?php echo date('H:i', strtotime($data['booking']->end_time)); ?>
                </p>
            </div>
            
            <div>
                <h4 class="text-sm font-semibold text-gray-500">อุปกรณ์ที่ขอ</h4>
                <?php if(!empty($data['booking']->equipments)): ?>
                    <ul class="list-disc list-inside text-gray-800">
                        <?php foreach($data['booking']->equipments as $equipment): ?>
                            <li><?php echo $equipment->name; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-gray-800">- ไม่มี -</p>
                <?php endif; ?>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-gray-500">รูปแบบการจัดห้อง</h4>
                <?php if(!empty($data['booking']->room_layout_image)): ?>
                    <div class="mt-2">
                        <img 
                            src="<?php echo URLROOT; ?>/uploads/layouts/<?php echo $data['booking']->room_layout_image; ?>" 
                            alt="Room Layout" 
                            class="max-w-xs w-full h-auto rounded-lg shadow-md object-cover"
                        >
                    </div>
                <?php else: ?>
                    <p class="text-gray-800">- ไม่ได้แนบไฟล์ -</p>
                <?php endif; ?>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-gray-500">หมายเหตุ</h4>
                <p class="text-gray-800"><?php echo !empty($data['booking']->note) ? $data['booking']->note : '-'; ?></p>
            </div>

        </div>

        <!-- Right Column -->
        <div class="space-y-4 bg-gray-50 p-4 rounded-lg">
             <div>
                <h4 class="text-sm font-semibold text-gray-500">สถานะ</h4>
                <?php 
                    $status_class = '';
                    if($data['booking']->status == 'pending') $status_class = 'bg-yellow-100 text-yellow-800';
                    if($data['booking']->status == 'approved') $status_class = 'bg-green-100 text-green-800';
                    if($data['booking']->status == 'rejected') $status_class = 'bg-red-100 text-red-800';
                ?>
                <p class="px-2 inline-flex text-base leading-5 font-semibold rounded-full <?php echo $status_class; ?>">
                    <?php echo translateStatus($data['booking']->status); // <-- แก้ไขตรงนี้ ?>
                </p>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-500">ผู้จอง</h4>
                <p class="text-gray-800"><?php echo $data['booking']->first_name . ' ' . $data['booking']->last_name; ?></p>
            </div>
             <div>
                <h4 class="text-sm font-semibold text-gray-500">จำนวนผู้เข้าร่วม</h4>
                <p class="text-gray-800"><?php echo $data['booking']->attendees; ?> คน</p>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-500">เบอร์โทรติดต่อ</h4>
                <p class="text-gray-800"><?php echo $data['booking']->phone; ?></p>
            </div>
        </div>
    </div>
    
    <hr class="my-6">
    
    <div class="flex items-center justify-between">
        <a href="<?php echo URLROOT; ?>/bookingcontroller" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            &larr; กลับไปหน้ารายการ
        </a>
        
        <!-- Admin Action Buttons -->
        <?php if($_SESSION['user_role'] == 'admin' && $data['booking']->status == 'pending'): ?>
        <div class="flex items-center space-x-2">
            <form action="<?php echo URLROOT; ?>/bookingcontroller/reject/<?php echo $data['booking']->bookingId; ?>" method="post">
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    ปฏิเสธ
                </button>
            </form>
            <form action="<?php echo URLROOT; ?>/bookingcontroller/approve/<?php echo $data['booking']->bookingId; ?>" method="post">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    อนุมัติ
                </button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/views/templates/layout_admin/footer.php'; ?>