<?php
class BookingController extends Controller {

    public function __construct(){
        if(!isLoggedIn()){ redirect('usercontroller/login'); }
        $this->bookingModel = $this->model('Booking');
        $this->roomModel = $this->model('Room');
        $this->equipmentModel = $this->model('Equipment');
        $this->settingModel = $this->model('Setting'); // <-- เพิ่มบรรทัดนี้
    }

    public function index(){
        $bookings = $this->bookingModel->getBookings();
        $data = ['title' => 'การจองทั้งหมด', 'bookings' => $bookings];
        $this->view('bookings/index', $data);
    }

    public function create(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            // --- จัดการไฟล์อัปโหลด ---
            $image_name = '';
            if(isset($_FILES['room_layout_image']) && $_FILES['room_layout_image']['error'] == 0){
                $target_dir = "uploads/layouts/";
                $image_name = uniqid() . '-' . basename($_FILES["room_layout_image"]["name"]);
                $target_file = $target_dir . $image_name;
                if(!move_uploaded_file($_FILES["room_layout_image"]["tmp_name"], $target_file)){ $image_name = ''; }
            }
            
            // --- รวบรวมข้อมูลจากฟอร์ม ---
            $data = [
                'user_id' => $_SESSION['user_id'],
                'room_id' => trim($_POST['room_id']),
                'subject' => trim($_POST['subject']),
                'department' => trim($_POST['department']),
                'phone' => trim($_POST['phone']),
                'attendees' => trim($_POST['attendees']),
                'start_time' => trim($_POST['start_time']),
                'end_time' => trim($_POST['end_time']),
                'note' => trim($_POST['note']),
                'equipments' => $_POST['equipments'] ?? [],
                'room_layout_image' => $image_name,
                'status' => $default_status // <-- เพิ่มสถานะเริ่มต้นเข้าไปใน data
            ];

            // --- ตรรกะการตรวจสอบแบบ Post/Redirect/Get ---
            
            // 1. ตรวจสอบฟิลด์ว่าง
            if(empty($data['subject']) || empty($data['room_id']) || empty($data['start_time']) || empty($data['end_time']) || empty($data['phone']) || empty($data['attendees'])){
                flash('flash_message', 'กรุณากรอกข้อมูลที่จำเป็น (*) ให้ครบถ้วน', 'error');
                $_SESSION['old_form_data'] = $_POST;
                redirect('bookingcontroller/create');
                return;
            }

            // 2. ตรวจสอบเวลา
            if(strtotime($data['end_time']) <= strtotime($data['start_time'])){
                flash('flash_message', 'เวลาสิ้นสุดต้องมากกว่าเวลาเริ่มต้น', 'error');
                $_SESSION['old_form_data'] = $_POST;
                redirect('bookingcontroller/create');
                return;
            }

            // 3. ตรวจสอบห้องว่าง
            if(!$this->bookingModel->isRoomAvailable($data['room_id'], $data['start_time'], $data['end_time'])){
                flash('flash_message', 'ห้องประชุมไม่ว่างในช่วงเวลานี้', 'error');
                $_SESSION['old_form_data'] = $_POST;
                redirect('bookingcontroller/create');
                return;
            }

            // --- ถ้าผ่านทุกอย่าง ให้บันทึกข้อมูล ---
            if($this->bookingModel->addBooking($data)){
                flash('flash_message', 'ส่งคำขอจองเรียบร้อยแล้ว', 'success');
                redirect('bookingcontroller/index');
            } else {
                flash('flash_message', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                $_SESSION['old_form_data'] = $_POST;
                redirect('bookingcontroller/create');
            }

        } else {
            // --- ส่วนแสดงฟอร์ม (GET Request) ---
            $data = [
                'title' => 'จองห้องประชุม',
                'rooms' => $this->roomModel->getRooms(),
                'all_equipments' => $this->equipmentModel->getEquipments(),
            ];
            // ล้างข้อมูลเก่าทิ้งหลังจากใช้งานแล้ว
            unset($_SESSION['old_form_data']); 
            
            $this->view('bookings/create', $data);
        }
    }
    
    public function show($id){
        $booking = $this->bookingModel->getBookingById($id);
        $data = ['title' => 'รายละเอียดการจอง', 'booking' => $booking];
        $this->view('bookings/show', $data);
    }
    
    public function approve($id){
        if($_SESSION['user_role'] != 'admin'){ redirect('bookingcontroller'); }
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($this->bookingModel->updateBookingStatus($id, 'approved', $_SESSION['user_id'])){
                flash('booking_status_success', 'อนุมัติการจองเรียบร้อยแล้ว', 'success');
            }
            redirect('bookingcontroller');
        }
    }
    
    public function reject($id){
        if($_SESSION['user_role'] != 'admin'){ redirect('bookingcontroller'); }
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($this->bookingModel->updateBookingStatus($id, 'rejected', $_SESSION['user_id'])){
                flash('booking_status_success', 'ปฏิเสธการจองเรียบร้อยแล้ว', 'warning');
            }
            redirect('bookingcontroller');
        }
    }
}