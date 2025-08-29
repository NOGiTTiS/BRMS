<?php
class UserController extends Controller {

    public function __construct(){
        // __construct จะโหลด Model เท่านั้น ไม่มีการตรวจสอบสิทธิ์ที่นี่
        $this->userModel = $this->model('User');
    }

    // --- Helper function สำหรับตรวจสอบ Admin ---
    private function requireAdmin(){
        if(!isLoggedIn()){
            redirect('usercontroller/login');
            return false;
        }
        if($_SESSION['user_role'] != 'admin'){
            flash('auth_error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้', 'error');
            redirect('pagecontroller/dashboard');
            return false;
        }
        return true;
    }

    // หน้าแสดงรายการผู้ใช้ทั้งหมด
    public function index(){
        if(!$this->requireAdmin()) return; // ตรวจสอบสิทธิ์

        $users = $this->userModel->getUsers();
        $data = ['title' => 'จัดการผู้ใช้งาน', 'users' => $users];
        $this->view('users/index', $data);
    }

    // หน้าฟอร์มเพิ่มผู้ใช้
    public function create(){
        if(!$this->requireAdmin()) return; // ตรวจสอบสิทธิ์

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process form
            $data = [
                'title' => 'เพิ่มผู้ใช้งาน',
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'role' => $_POST['role'],
                'username_err' => '', 'email_err' => '', 'password_err' => '', 'confirm_password_err' => ''
            ];

            // Validate Data
            if(empty($data['username'])){ $data['username_err'] = 'กรุณากรอก Username'; }
            else if($this->userModel->findUserByUsername($data['username'])){ $data['username_err'] = 'Username นี้มีผู้ใช้งานแล้ว'; }

            if(empty($data['email'])){ $data['email_err'] = 'กรุณากรอก Email'; }
            else if($this->userModel->findUserByEmail($data['email'])){ $data['email_err'] = 'Email นี้มีผู้ใช้งานแล้ว'; }

            if(empty($data['password'])){ $data['password_err'] = 'กรุณากรอกรหัสผ่าน'; }
            else if(strlen($data['password']) < 6){ $data['password_err'] = 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร'; }

            if(empty($data['confirm_password'])){ $data['confirm_password_err'] = 'กรุณายืนยันรหัสผ่าน'; }
            else if($data['password'] != $data['confirm_password']){ $data['confirm_password_err'] = 'รหัสผ่านไม่ตรงกัน'; }

            // Make sure errors are empty
            if(empty($data['username_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                if($this->userModel->addUser($data)){
                    redirect('usercontroller/index');
                } else { die('Something went wrong'); }
            } else {
                $this->view('users/create', $data);
            }

        } else {
            $data = [ 'title' => 'เพิ่มผู้ใช้งาน', /* ... ค่าว่างอื่นๆ ... */ ];
            $this->view('users/create', $data);
        }
    }

    // หน้าฟอร์มแก้ไขผู้ใช้
    public function edit($id){
        if(!$this->requireAdmin()) return; // ตรวจสอบสิทธิ์

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process form
            $data = [
                'title' => 'แก้ไขผู้ใช้งาน',
                'id' => $id,
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'role' => $_POST['role'],
                'username_err' => '', 'email_err' => '', 'password_err' => ''
            ];

            // Validate (คล้ายกับ create แต่ไม่ต้องบังคับใส่ password)
            if(empty($data['username'])){ $data['username_err'] = 'กรุณากรอก Username'; }
            if(empty($data['email'])){ $data['email_err'] = 'กรุณากรอก Email'; }

            // Password validation (only if new password is provided)
            if(!empty($data['password'])){
                 if(strlen($data['password']) < 6){ $data['password_err'] = 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร'; }
                 if($data['password'] != $data['confirm_password']){ $data['password_err'] = 'รหัสผ่านไม่ตรงกัน'; }
            }

            if(empty($data['username_err']) && empty($data['email_err']) && empty($data['password_err'])){
                if($this->userModel->updateUser($data)){
                    redirect('usercontroller/index');
                } else { die('Something went wrong'); }
            } else {
                // ต้องดึงข้อมูล user เดิมมาด้วยเพื่อแสดงผลในฟอร์ม
                $user = $this->userModel->getUserById($id);
                $data['user'] = $user;
                $this->view('users/edit', $data);
            }

        } else {
            $user = $this->userModel->getUserById($id);
            $data = [
                'title' => 'แก้ไขผู้ใช้งาน',
                'id' => $id,
                'user' => $user
            ];
            $this->view('users/edit', $data);
        }
    }

    // ลบผู้ใช้
    public function delete($id){
        if(!$this->requireAdmin()) return; // ตรวจสอบสิทธิ์
        
        // ป้องกันการลบตัวเอง
        if($id == $_SESSION['user_id']){
            // สามารถเพิ่ม Flash Message แจ้งเตือนได้ในอนาคต
            redirect('usercontroller/index');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($this->userModel->deleteUser($id)){
                redirect('usercontroller/index');
            } else { die('Something went wrong'); }
        } else {
            redirect('usercontroller/index');
        }
    }

    public function login(){
        // ตรวจสอบว่าเป็นการส่งข้อมูลแบบ POST หรือไม่
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // ประมวลผลฟอร์ม
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'password_err' => '',
            ];

            // Validate Username
            if(empty($data['username'])){
                $data['username_err'] = 'กรุณากรอกชื่อผู้ใช้งาน';
            }

            // Validate Password
            if(empty($data['password'])){
                $data['password_err'] = 'กรุณากรอกรหัสผ่าน';
            }

            // ตรวจสอบว่ามี username นี้ในระบบหรือไม่
            if($this->userModel->findUserByUsername($data['username']) === false){
                 $data['username_err'] = 'ไม่พบชื่อผู้ใช้งานนี้ในระบบ';
            }

            // ตรวจสอบว่าไม่มี error ใดๆ ก่อน tiến hành login
            if(empty($data['username_err']) && empty($data['password_err'])){
                // ผ่านการตรวจสอบ
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                if($loggedInUser){
                    // Login สำเร็จ, สร้าง Session
                    createUserSession($loggedInUser);
                    redirect('pagecontroller/dashboard'); // ไปยังหน้า dashboard
                } else {
                    $data['password_err'] = 'รหัสผ่านไม่ถูกต้อง';
                    // โหลดหน้า login พร้อม error
                    $this->view('pages/login', $data);
                }
            } else {
                // โหลดหน้า login พร้อม error
                $this->view('pages/login', $data);
            }

        } else {
            // ถ้าไม่ใช่ POST ให้กลับไปหน้า login
            redirect('pagecontroller/index');
        }
    }

    public function logout(){
        destroyUserSession();
        redirect('pagecontroller/index');
    }
}