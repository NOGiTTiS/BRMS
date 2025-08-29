<?php require APPROOT . '/views/templates/layout_admin/header.php'; ?>

<!-- Page-specific content starts here -->

<h3 class="text-gray-700 text-3xl font-medium">ภาพรวมระบบ</h3>

<div class="mt-4">
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Card 1: การจองวันนี้ -->
        <div class="flex items-center p-4 bg-white/80 backdrop-blur-sm rounded-lg shadow-md">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                <ion-icon name="calendar-outline" class="w-6 h-6"></ion-icon>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    การจองวันนี้
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    <?php echo $data['stats']['todays_bookings']; ?> รายการ
                </p>
            </div>
        </div>
        <!-- Card 2: รออนุมัติ -->
        <div class="flex items-center p-4 bg-white/80 backdrop-blur-sm rounded-lg shadow-md">
            <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">
                <ion-icon name="time-outline" class="w-6 h-6"></ion-icon>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    รออนุมัติ
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    <?php echo $data['stats']['pending_bookings']; ?> รายการ
                </p>
            </div>
        </div>
        <!-- Card 3: ห้องประชุมทั้งหมด -->
        <div class="flex items-center p-4 bg-white/80 backdrop-blur-sm rounded-lg shadow-md">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                <ion-icon name="business-outline" class="w-6 h-6"></ion-icon>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    ห้องประชุมทั้งหมด
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    <?php echo $data['stats']['total_rooms']; ?> ห้อง
                </p>
            </div>
        </div>
        <!-- Card 4: ผู้ใช้ในระบบ -->
        <div class="flex items-center p-4 bg-white/80 backdrop-blur-sm rounded-lg shadow-md">
            <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full">
                 <ion-icon name="people-outline" class="w-6 h-6"></ion-icon>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    ผู้ใช้ในระบบ
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    <?php echo $data['stats']['total_users']; ?> คน
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Chart Placeholder -->
<div class="mt-8 p-6 bg-white/80 backdrop-blur-sm rounded-lg shadow-md">
    <h4 class="text-gray-700 text-xl font-semibold mb-4">สถิติการจองรายเดือน</h4>
    <canvas id="bookingChart"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // รับข้อมูลจาก PHP มาเป็น JavaScript Object
        const chartData = <?php echo json_encode($data['chartData']); ?>;

        const ctx = document.getElementById('bookingChart').getContext('2d');
        const bookingChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels, // <-- ใช้ labels จาก PHP
                datasets: [{
                    label: 'จำนวนการจอง',
                    data: chartData.data, // <-- ใช้ data จาก PHP
                    backgroundColor: 'rgba(236, 72, 153, 0.2)',
                    borderColor: 'rgba(236, 72, 153, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // ทำให้แกน Y เป็นเลขจำนวนเต็มเท่านั้น
                            stepSize: 1 
                        }
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    });
</script>

<!-- Page-specific content ends here -->

<?php require APPROOT . '/views/templates/layout_admin/footer.php'; ?>