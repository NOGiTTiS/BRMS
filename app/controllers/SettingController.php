<?php
class SettingController extends Controller {

    public function __construct(){
        // ตรวจสอบว่าเป็น Admin หรือไม่
        if(!isLoggedIn() || $_SESSION['user_role'] != 'admin'){
            flash('flash_message', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้', 'error');
            redirect('pagecontroller/dashboard');
        }
        $this->settingModel = $this->model('Setting');
    }

    // แสดงและประมวลผลหน้าตั้งค่า
    public function index(){
        // ตรวจสอบก่อนว่าเป็นการส่งฟอร์มหรือไม่
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // ประมวลผลฟอร์มที่ส่งมา
            $default_status = trim($_POST['default_status']);
            
            // พยายามอัปเดตค่า Setting
            if($this->settingModel->updateSetting('default_booking_status', $default_status)){
                flash('flash_message', 'บันทึกการตั้งค่าเรียบร้อยแล้ว', 'success');
            } else {
                flash('flash_message', 'เกิดข้อผิดพลาดในการบันทึก', 'error');
            }
            // *** จุดสำคัญ: ไม่ Redirect แต่จะไปต่อเพื่อโหลดหน้า View ซ้ำ ***
        }

        // --- ส่วนแสดงผล (ทำงานทุกครั้ง ไม่ว่าจะเป็น GET หรือ POST) ---
        
        // ดึงข้อมูลการตั้งค่าล่าสุดจากฐานข้อมูล (เพื่อให้แสดงผลที่อัปเดตแล้ว)
        $settings = $this->settingModel->getSettings();
        
        $data = [
            'title' => 'ตั้งค่าระบบ',
            'settings' => $settings
        ];
        
        // โหลดหน้า View (SweetAlert จะแสดงผลในหน้านี้)
        $this->view('settings/index', $data);
    }
}