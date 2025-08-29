<?php
// ชื่อคลาสนี้จะต้องมีชื่อตรงกับชื่อไฟล์ คือ PageController
class PageController extends Controller {
    public function __construct(){
        // ในอนาคตเราอาจจะโหลด Model ที่นี่
    }

    // เมธอดเริ่มต้นที่จะทำงานเมื่อไม่มีการระบุเมธอดใน URL
    public function index(){
        // เตรียมข้อมูลที่จะส่งไปให้ View
        $data = [
            'title' => 'BRMS - Login',
            'description' => 'ระบบจองห้องประชุมออนไลน์'
        ];

        // เรียกใช้งาน View และส่งข้อมูลไปแสดงผล
        // ส่วนของ View ยังคงใช้โฟลเดอร์ pages เหมือนเดิมได้ ไม่ต้องเปลี่ยนแปลง
        $this->view('pages/login', $data);
    }

    public function dashboard(){
        if(!isLoggedIn()){
            redirect('usercontroller/login');
        }

        // --- โหลด Model ที่จำเป็น ---
        $bookingModel = $this->model('Booking');
        $roomModel = $this->model('Room');
        $userModel = $this->model('User');

        // --- ดึงข้อมูลสรุป ---
        $stats = [
            'todays_bookings' => $bookingModel->countTodaysBookings(),
            'pending_bookings' => $bookingModel->countPendingBookings(),
            'total_rooms' => $roomModel->countAllRooms(),
            'total_users' => $userModel->countAllUsers()
        ];

        // --- ดึงข้อมูลสำหรับกราฟ (เพิ่มเข้ามาใหม่) ---
        $chartData = $bookingModel->getMonthlyBookingStats();
        
        $data = [
            'title' => 'ภาพรวม (Dashboard)',
            'description' => 'ยินดีต้อนรับสู่ระบบจองห้องประชุม',
            'stats' => $stats, // ส่งข้อมูลสถิติไปให้ View
            'chartData' => $chartData // <-- ส่งข้อมูลกราฟไปให้ View
        ];

        $this->view('pages/dashboard', $data);
    }

    // ตัวอย่างเมธอดอื่นๆ ในอนาคต
    public function about(){
        $data = ['title' => 'About Us'];
        $this->view('pages/about', $data);
    }
}