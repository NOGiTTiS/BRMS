<?php require APPROOT . '/views/templates/layout_admin/header.php'; ?>

<div class="flex justify-between items-center mb-6">
    <h3 class="text-gray-700 text-3xl font-medium"><?php echo $data['title']; ?></h3>
    <a href="<?php echo URLROOT; ?>/bookingcontroller/create" class="bg-pink-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-pink-600 transition duration-300">
        + จองห้องประชุม
    </a>
</div>

<div class="bg-white/80 backdrop-blur-sm rounded-lg shadow-md p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">หัวข้อ</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ห้อง</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ผู้จอง</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">เวลาเริ่ม</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">สถานะ</th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">จัดการ</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php foreach($data['bookings'] as $booking) : ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200"><?php echo $booking->subject; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200"><?php echo $booking->room_name; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200"><?php echo $booking->user_first_name; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200"><?php echo date('d/m/Y H:i', strtotime($booking->start_time)); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                        <?php 
                            $status_class = '';
                            if($booking->status == 'pending') $status_class = 'bg-yellow-100 text-yellow-800';
                            if($booking->status == 'approved') $status_class = 'bg-green-100 text-green-800';
                            if($booking->status == 'rejected') $status_class = 'bg-red-100 text-red-800';
                        ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $status_class; ?>">
                            <?php echo translateStatus($booking->status); // <-- แก้ไขตรงนี้ ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-sm font-medium">
                        <a href="<?php echo URLROOT; ?>/bookingcontroller/show/<?php echo $booking->id; ?>" class="text-blue-600 hover:text-blue-900">ดูรายละเอียด</a>
                        <?php if($_SESSION['user_role'] == 'admin' && $booking->status == 'pending'): ?>
                            <form action="<?php echo URLROOT; ?>/bookingcontroller/approve/<?php echo $booking->id; ?>" method="post" class="inline-block ml-2">
                                <button type="submit" class="text-green-600 hover:text-green-900">อนุมัติ</button>
                            </form>
                            <form action="<?php echo URLROOT; ?>/bookingcontroller/reject/<?php echo $booking->id; ?>" method="post" class="inline-block ml-2">
                                <button type="submit" class="text-red-600 hover:text-red-900">ปฏิเสธ</button>
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