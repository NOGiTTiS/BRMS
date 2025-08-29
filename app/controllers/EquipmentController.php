<?php
class EquipmentController extends Controller {

    public function __construct(){
        if(!isLoggedIn()){
            redirect('usercontroller/login');
        }

        if($_SESSION['user_role'] != 'admin'){
            flash('auth_error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้', 'error');
            redirect('pagecontroller/dashboard');
        }

        $this->equipmentModel = $this->model('Equipment');
    }

    // หน้าแสดงรายการอุปกรณ์ทั้งหมด
    public function index(){
        $equipments = $this->equipmentModel->getEquipments();
        $data = [
            'title' => 'จัดการอุปกรณ์',
            'equipments' => $equipments
        ];
        $this->view('equipments/index', $data);
    }

    // หน้าฟอร์มเพิ่มอุปกรณ์
    public function create(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process form
            $data = [
                'title' => 'เพิ่มอุปกรณ์',
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'name_err' => ''
            ];

            if(empty($data['name'])){
                $data['name_err'] = 'กรุณากรอกชื่ออุปกรณ์';
            }

            if(empty($data['name_err'])){
                if($this->equipmentModel->addEquipment($data)){
                    redirect('equipmentcontroller/index');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('equipments/create', $data);
            }

        } else {
            $data = [
                'title' => 'เพิ่มอุปกรณ์',
                'name' => '',
                'description' => ''
            ];
            $this->view('equipments/create', $data);
        }
    }

    // หน้าฟอร์มแก้ไขอุปกรณ์
    public function edit($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process form
            $data = [
                'title' => 'แก้ไขอุปกรณ์',
                'id' => $id,
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'name_err' => ''
            ];

            if(empty($data['name'])){
                $data['name_err'] = 'กรุณากรอกชื่ออุปกรณ์';
            }

            if(empty($data['name_err'])){
                if($this->equipmentModel->updateEquipment($data)){
                    redirect('equipmentcontroller/index');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('equipments/edit', $data);
            }

        } else {
            $equipment = $this->equipmentModel->getEquipmentById($id);
            $data = [
                'title' => 'แก้ไขอุปกรณ์',
                'id' => $id,
                'equipment' => $equipment
            ];
            $this->view('equipments/edit', $data);
        }
    }

    // ลบอุปกรณ์
    public function delete($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($this->equipmentModel->deleteEquipment($id)){
                redirect('equipmentcontroller/index');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('equipmentcontroller/index');
        }
    }
}