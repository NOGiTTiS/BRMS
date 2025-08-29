<?php
class CalendarController extends Controller {

    public function __construct(){
        if(!isLoggedIn()){
            redirect('usercontroller/login');
        }
        $this->bookingModel = $this->model('Booking');
    }

    // แสดงหน้าปฏิทิน
    public function index(){
        // 1. โหลด Room Model ที่จำเป็น
        $roomModel = $this->model('Room');
        
        // 2. ดึงข้อมูลห้องทั้งหมดมาเก็บในตัวแปร $rooms
        $rooms = $roomModel->getRooms();

        // 3. สร้าง Array ข้อมูลที่จะส่งไปให้ View
        $data = [
            'title' => 'ปฏิทินการจอง',
            'rooms' => $rooms // ตอนนี้ตัวแปร $rooms มีอยู่จริงแล้ว
        ];

        // 4. โหลด View พร้อมส่งข้อมูลไปด้วย
        $this->view('calendar/index', $data);
    }
    
    // API สำหรับดึงข้อมูลการจอง (จะถูกเรียกโดย JavaScript)
    public function getEvents(){
        $events = $this->bookingModel->getApprovedBookingsForCalendar();
        
        // ส่งข้อมูลกลับไปในรูปแบบ JSON
        header('Content-Type: application/json');
        echo json_encode($events);
    }
}