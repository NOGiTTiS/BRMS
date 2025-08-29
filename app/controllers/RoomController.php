<?php
class RoomController extends Controller {

    public function __construct(){
        // 1. ตรวจสอบว่า Login หรือยัง
        if(!isLoggedIn()){
            redirect('usercontroller/login');
        }

        // 2. ตรวจสอบว่าเป็น Admin หรือไม่
        if($_SESSION['user_role'] != 'admin'){
            flash('auth_error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้', 'error');
            redirect('pagecontroller/dashboard'); // เด้งกลับไปหน้า Dashboard
        }

        // 3. โหลด Model (จะทำงานก็ต่อเมื่อผ่านการตรวจสอบทั้งหมดแล้ว)
        $this->roomModel = $this->model('Room');
    }
    // แสดงหน้าหลักของจัดการห้องประชุม (แสดงทุกห้อง)
    public function index(){
        $rooms = $this->roomModel->getRooms();
        $data = [
            'title' => 'จัดการห้องประชุม',
            'rooms' => $rooms
        ];
        $this->view('rooms/index', $data);
    }

    // แสดงฟอร์มสำหรับเพิ่มห้องประชุม
    public function create(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process form
            $data = [
                'title' => 'เพิ่มห้องประชุม',
                'name' => trim($_POST['name']),
                'capacity' => trim($_POST['capacity']),
                'description' => trim($_POST['description']),
                'color' => trim($_POST['color']),
                'name_err' => '',
                'capacity_err' => ''
            ];

            // Validate name
            if(empty($data['name'])){
                $data['name_err'] = 'กรุณากรอกชื่อห้องประชุม';
            }
            // Validate capacity
            if(empty($data['capacity'])){
                $data['capacity_err'] = 'กรุณากรอกจำนวนความจุ';
            }

            // Make sure no errors
            if(empty($data['name_err']) && empty($data['capacity_err'])){
                if($this->roomModel->addRoom($data)){
                    redirect('roomcontroller/index');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('rooms/create', $data);
            }

        } else {
            // แสดงฟอร์มเปล่า
            $data = [
                'title' => 'เพิ่มห้องประชุม',
                'name' => '',
                'capacity' => '',
                'description' => '',
                'color' => '#f472b6' // Default pink color
            ];
            $this->view('rooms/create', $data);
        }
    }

    // แสดงฟอร์มสำหรับแก้ไขห้องประชุม
    public function edit($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process form
            $data = [
                'title' => 'แก้ไขห้องประชุม',
                'id' => $id,
                'name' => trim($_POST['name']),
                'capacity' => trim($_POST['capacity']),
                'description' => trim($_POST['description']),
                'color' => trim($_POST['color']),
                'name_err' => '',
                'capacity_err' => ''
            ];

            if(empty($data['name'])){ $data['name_err'] = 'กรุณากรอกชื่อห้องประชุม'; }
            if(empty($data['capacity'])){ $data['capacity_err'] = 'กรุณากรอกจำนวนความจุ'; }

            if(empty($data['name_err']) && empty($data['capacity_err'])){
                if($this->roomModel->updateRoom($data)){
                    redirect('roomcontroller/index');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('rooms/edit', $data);
            }

        } else {
            // ดึงข้อมูลห้องเดิมมาแสดง
            $room = $this->roomModel->getRoomById($id);
            $data = [
                'title' => 'แก้ไขห้องประชุม',
                'id' => $id,
                'room' => $room
            ];
            $this->view('rooms/edit', $data);
        }
    }

    // ลบห้องประชุม
    public function delete($id){
        // ต้องเป็นการส่งแบบ POST เท่านั้นเพื่อความปลอดภัย
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($this->roomModel->deleteRoom($id)){
                redirect('roomcontroller/index');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('roomcontroller/index');
        }
    }
}