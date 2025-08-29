<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// --- ฟังก์ชันจัดการ Session ผู้ใช้ (เหมือนเดิม) ---
function createUserSession($user){ $_SESSION['user_id'] = $user->id; $_SESSION['user_first_name'] = $user->first_name; $_SESSION['user_role'] = $user->role; }
function destroyUserSession(){ session_unset(); session_destroy(); }
function isLoggedIn(){ return isset($_SESSION['user_id']); }
function translateStatus($status) { switch ($status) { case 'approved': return 'อนุมัติ'; case 'pending': return 'รออนุมัติ'; case 'rejected': return 'ปฏิเสธ'; default: return ucfirst($status); } }

// --- กลไก Flash Message & SweetAlert ---
function flash($name = 'flash_message', $message = '', $type = 'success'){
    if(!empty($name)){
        if(!empty($message) && empty($_SESSION[$name])){ // สร้าง session แค่ครั้งเดียว
            $_SESSION[$name] = ['message' => $message, 'type' => $type];
        }
    }
}

function displaySweetAlert($name = 'flash_message'){
    if(isset($_SESSION[$name])){
        $flash = $_SESSION[$name];
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '" . htmlspecialchars($flash['type']) . "',
                    title: '" . htmlspecialchars($flash['message']) . "',
                    showConfirmButton: false,
                    timer: 2800,
                    timerProgressBar: true
                });
            });
        </script>";
        unset($_SESSION[$name]);
    }
}