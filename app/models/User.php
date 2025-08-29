<?php
class User {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // ฟังก์ชันค้นหาผู้ใช้ด้วย username
    public function findUserByUsername($username){
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        // ตรวจสอบว่ามีแถวข้อมูลหรือไม่
        if($this->db->rowCount() > 0){
            return $row; // คืนค่าข้อมูลผู้ใช้ถ้าเจอ
        } else {
            return false; // คืนค่า false ถ้าไม่เจอ
        }
    }

    // ฟังก์ชัน Login
    public function login($username, $password){
        $user = $this->findUserByUsername($username);

        if($user === false){
            return false; // ไม่พบผู้ใช้งาน
        }

        $hashed_password = $user->password;
        // ตรวจสอบรหัสผ่านที่กรอกมากับรหัสผ่านที่เข้ารหัสในฐานข้อมูล
        if(password_verify($password, $hashed_password)){
            return $user; // รหัสผ่านถูกต้อง, คืนค่าข้อมูลผู้ใช้
        } else {
            return false; // รหัสผ่านไม่ถูกต้อง
        }
    }

    // ค้นหาผู้ใช้ด้วย Email
    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        return ($this->db->rowCount() > 0) ? $row : false;
    }

    // ดึงข้อมูลผู้ใช้ทั้งหมด
    public function getUsers(){
        $this->db->query('SELECT id, username, first_name, last_name, email, role FROM users ORDER BY created_at ASC');
        return $this->db->resultSet();
    }

    // ดึงข้อมูลผู้ใช้ด้วย ID
    public function getUserById($id){
        $this->db->query('SELECT id, username, first_name, last_name, email, role FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // เพิ่มผู้ใช้ใหม่
    public function addUser($data){
        // เข้ารหัสผ่านก่อนบันทึก
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $this->db->query('INSERT INTO users (username, password, first_name, last_name, email, role) VALUES (:username, :password, :first_name, :last_name, :email, :role)');
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':role', $data['role']);

        return $this->db->execute();
    }

    // อัปเดตข้อมูลผู้ใช้
    public function updateUser($data){
        // ตรวจสอบว่ามีการส่งรหัสผ่านใหม่มาหรือไม่
        if(!empty($data['password'])){
            // ถ้ามี ให้เข้ารหัสผ่านใหม่และอัปเดต
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->db->query('UPDATE users SET username = :username, password = :password, first_name = :first_name, last_name = :last_name, email = :email, role = :role WHERE id = :id');
            $this->db->bind(':password', $data['password']);
        } else {
            // ถ้าไม่มี ไม่ต้องอัปเดตรหัสผ่าน
            $this->db->query('UPDATE users SET username = :username, first_name = :first_name, last_name = :last_name, email = :email, role = :role WHERE id = :id');
        }

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':role', $data['role']);

        return $this->db->execute();
    }

    // ลบผู้ใช้
    public function deleteUser($id){
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // นับจำนวนผู้ใช้ทั้งหมด
    public function countAllUsers(){
        $this->db->query('SELECT COUNT(id) as count FROM users');
        $row = $this->db->single();
        return $row->count;
    }
}