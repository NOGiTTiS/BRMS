<?php
class Setting {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // ดึงข้อมูลการตั้งค่าทั้งหมด
    public function getSettings(){
        $this->db->query('SELECT * FROM settings');
        $results = $this->db->resultSet();
        
        // แปลงผลลัพธ์จาก Array of objects เป็น Key-Value pair เพื่อให้ใช้ง่าย
        $settings = [];
        foreach($results as $row){
            $settings[$row->setting_name] = $row->setting_value;
        }
        return $settings;
    }

    // ดึงค่า setting แค่ตัวเดียว
    public function getSetting($name){
        $this->db->query('SELECT setting_value FROM settings WHERE setting_name = :name');
        $this->db->bind(':name', $name);
        $row = $this->db->single();
        return $row ? $row->setting_value : null;
    }

    // อัปเดตการตั้งค่า
    public function updateSetting($name, $value){
        // ใช้ INSERT ... ON DUPLICATE KEY UPDATE เพื่อให้สามารถสร้าง setting ใหม่ได้ถ้ายังไม่มี
        $this->db->query('INSERT INTO settings (setting_name, setting_value) VALUES (:name, :value) ON DUPLICATE KEY UPDATE setting_value = :value');
        $this->db->bind(':name', $name);
        $this->db->bind(':value', $value);

        return $this->db->execute();
    }
}