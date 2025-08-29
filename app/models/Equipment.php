<?php
class Equipment {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // ดึงข้อมูลอุปกรณ์ทั้งหมด
    public function getEquipments(){
        $this->db->query('SELECT * FROM equipments ORDER BY created_at ASC'); // <-- แก้ไข
        return $this->db->resultSet(); // <-- แก้ไข
    }

    // ดึงข้อมูลอุปกรณ์ด้วย ID
    public function getEquipmentById($id){
        $this->db->query('SELECT * FROM equipments WHERE id = :id'); // <-- แก้ไข
        $this->db->bind(':id', $id); // <-- แก้ไข
        return $this->db->single(); // <-- แก้ไข
    }

    // เพิ่มข้อมูลอุปกรณ์
    public function addEquipment($data){
        $this->db->query('INSERT INTO equipments (name, description) VALUES (:name, :description)'); // <-- แก้ไข
        $this->db->bind(':name', $data['name']); // <-- แก้ไข
        $this->db->bind(':description', $data['description']); // <-- แก้ไข

        if($this->db->execute()){ // <-- แก้ไข
            return true;
        } else {
            return false;
        }
    }

    // อัปเดตข้อมูลอุปกรณ์
    public function updateEquipment($data){
        $this->db->query('UPDATE equipments SET name = :name, description = :description WHERE id = :id'); // <-- แก้ไข
        $this->db->bind(':id', $data['id']); // <-- แก้ไข
        $this->db->bind(':name', $data['name']); // <-- แก้ไข
        $this->db->bind(':description', $data['description']); // <-- แก้ไข

        if($this->db->execute()){ // <-- แก้ไข
            return true;
        } else {
            return false;
        }
    }

    // ลบข้อมูลอุปกรณ์
    public function deleteEquipment($id){
        $this->db->query('DELETE FROM equipments WHERE id = :id'); // <-- แก้ไข
        $this->db->bind(':id', $id); // <-- แก้ไข

        if($this->db->execute()){ // <-- แก้ไข
            return true;
        } else {
            return false;
        }
    }
}