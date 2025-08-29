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
        $data = [
            'title' => 'ปฏิทินการจอง'
        ];
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