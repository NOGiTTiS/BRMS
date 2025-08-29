<?php
class Room {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // ดึงข้อมูลห้องประชุมทั้งหมด
    public function getRooms(){
        $this->db->query('SELECT * FROM rooms ORDER BY id ASC');
        return $this->db->resultSet();
    }

    // ดึงข้อมูลห้องประชุมด้วย ID
    public function getRoomById($id){
        $this->db->query('SELECT * FROM rooms WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // เพิ่มข้อมูลห้องประชุม
    public function addRoom($data){
        $this->db->query('INSERT INTO rooms (name, capacity, description, color) VALUES (:name, :capacity, :description, :color)');
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':capacity', $data['capacity']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':color', $data['color']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // อัปเดตข้อมูลห้องประชุม
    public function updateRoom($data){
        $this->db->query('UPDATE rooms SET name = :name, capacity = :capacity, description = :description, color = :color WHERE id = :id');
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':capacity', $data['capacity']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':color', $data['color']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // ลบข้อมูลห้องประชุม
    public function deleteRoom($id){
        $this->db->query('DELETE FROM rooms WHERE id = :id');
        $this->db->bind(':id', $id);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // นับจำนวนห้องทั้งหมด
    public function countAllRooms(){
        $this->db->query('SELECT COUNT(id) as count FROM rooms');
        $row = $this->db->single();
        return $row->count;
    }
}