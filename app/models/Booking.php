<?php
class Booking {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // ดึงข้อมูลการจองทั้งหมดพร้อม JOIN ข้อมูลที่จำเป็น
    public function getBookings(){
        $this->db->query('
            SELECT 
                bookings.id,
                bookings.subject,
                bookings.start_time,
                bookings.status,
                rooms.name as room_name,
                users.first_name as user_first_name
            FROM bookings
            JOIN rooms ON bookings.room_id = rooms.id
            JOIN users ON bookings.user_id = users.id
            ORDER BY bookings.id DESC
        ');
        return $this->db->resultSet();
    }
    
    // ดึงข้อมูลการจอง 1 รายการแบบละเอียด
    public function getBookingById($id){
        // แก้ไข SQL Query ให้ระบุคอลัมน์อย่างชัดเจนเพื่อป้องกันชื่อซ้ำกัน
        $this->db->query('
            SELECT 
                b.*, -- เลือกทุกคอลัมน์จากตาราง bookings
                b.id as bookingId, 
                r.name as room_name,
                u.first_name,
                u.last_name
            FROM 
                bookings as b
            JOIN 
                rooms as r ON b.room_id = r.id
            JOIN 
                users as u ON b.user_id = u.id
            WHERE 
                b.id = :id
        ');
        $this->db->bind(':id', $id);
        $booking = $this->db->single();
        
        // ส่วนดึงข้อมูลอุปกรณ์ยังคงเหมือนเดิม
        if($booking){
            $this->db->query('SELECT equipments.name 
                             FROM booking_equipments
                             JOIN equipments ON booking_equipments.equipment_id = equipments.id
                             WHERE booking_equipments.booking_id = :booking_id');
            $this->db->bind(':booking_id', $id);
            $equipments = $this->db->resultSet();
            
            $booking->equipments = $equipments;
        }
        
        return $booking;
    }
    // ตรวจสอบว่าห้องว่างในช่วงเวลาที่กำหนดหรือไม่
    public function isRoomAvailable($room_id, $start_time, $end_time, $exclude_booking_id = 0){
        $this->db->query('
            SELECT id FROM bookings
            WHERE room_id = :room_id 
            AND id != :exclude_booking_id
            AND (
                (:start_time < end_time) AND (:end_time > start_time)
            )
        ');
        $this->db->bind(':room_id', $room_id);
        $this->db->bind(':start_time', $start_time);
        $this->db->bind(':end_time', $end_time);
        $this->db->bind(':exclude_booking_id', $exclude_booking_id);

        $this->db->single();
        return ($this->db->rowCount() == 0); // ถ้าไม่เจอแถวเลย (0) แปลว่าห้องว่าง
    }

    // เพิ่มการจองใหม่ (ใช้ Transaction)
    public function addBooking($data){
        // เริ่ม Transaction ผ่านเมธอดใหม่
        $this->db->beginTransaction();

        try {
            // 1. Insert into bookings table
            $this->db->query('INSERT INTO bookings (user_id, room_id, subject, department, phone, attendees, start_time, end_time, note, room_layout_image) 
                             VALUES (:user_id, :room_id, :subject, :department, :phone, :attendees, :start_time, :end_time, :note, :room_layout_image)');
            
            // Bind values
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':room_id', $data['room_id']);
            $this->db->bind(':subject', $data['subject']);
            $this->db->bind(':department', $data['department']);
            $this->db->bind(':phone', $data['phone']);
            $this->db->bind(':attendees', $data['attendees']);
            $this->db->bind(':start_time', $data['start_time']);
            $this->db->bind(':end_time', $data['end_time']);
            $this->db->bind(':note', $data['note']);
            $this->db->bind(':room_layout_image', $data['room_layout_image']);
            $this->db->bind(':status', $data['status']); // <-- เพิ่ม bind status
            $this->db->execute();
            
            // 2. Get the last inserted ID for the booking ผ่านเมธอดใหม่
            $booking_id = $this->db->lastInsertId();

            // 3. Insert into booking_equipments table
            if(!empty($data['equipments'])){
                foreach($data['equipments'] as $equipment_id){
                    $this->db->query('INSERT INTO booking_equipments (booking_id, equipment_id) VALUES (:booking_id, :equipment_id)');
                    $this->db->bind(':booking_id', $booking_id);
                    $this->db->bind(':equipment_id', $equipment_id);
                    $this->db->execute();
                }
            }

            // ถ้าทุกอย่างสำเร็จ, Commit Transaction ผ่านเมธอดใหม่
            $this->db->endTransaction();
            return true;

        } catch (Exception $e) {
            // ถ้ามีข้อผิดพลาดเกิดขึ้น, Rollback Transaction ผ่านเมธอดใหม่
            $this->db->cancelTransaction();
            return false;
        }
    }

    // ดึงข้อมูลการจองที่อนุมัติแล้วสำหรับปฏิทิน
    public function getApprovedBookingsForCalendar(){
        $this->db->query('
            SELECT 
                bookings.subject as title,
                bookings.start_time as start,
                bookings.end_time as end,
                rooms.color as color
            FROM bookings
            JOIN rooms ON bookings.room_id = rooms.id
            WHERE bookings.status = "approved"
        ');
        return $this->db->resultSet();
    }
    
    // อัปเดตสถานะการจอง (อนุมัติ/ปฏิเสธ)
    public function updateBookingStatus($id, $status, $admin_id){
        $this->db->query('UPDATE bookings SET status = :status, admin_id = :admin_id WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        $this->db->bind(':admin_id', $admin_id);
        
        return $this->db->execute();
    }

    // นับจำนวนการจองที่มี start_time เป็นวันปัจจุบัน
    public function countTodaysBookings(){
        $this->db->query('SELECT COUNT(id) as count FROM bookings WHERE DATE(start_time) = CURDATE()');
        $row = $this->db->single();
        return $row->count;
    }

    // นับจำนวนการจองที่รออนุมัติ
    public function countPendingBookings(){
        $this->db->query('SELECT COUNT(id) as count FROM bookings WHERE status = "pending"');
        $row = $this->db->single();
        return $row->count;
    }

    // ดึงข้อมูลสถิติการจองรายเดือนของปีปัจจุบัน
    public function getMonthlyBookingStats(){
        $this->db->query("
            SELECT 
                MONTH(start_time) as month, 
                COUNT(id) as count
            FROM bookings
            WHERE YEAR(start_time) = YEAR(CURDATE())
            GROUP BY MONTH(start_time)
            ORDER BY MONTH(start_time) ASC
        ");

        $results = $this->db->resultSet();
        
        // --- เตรียมข้อมูลสำหรับ Chart.js ---
        // สร้าง Array 12 เดือนที่เต็มไปด้วย 0
        $monthlyData = array_fill(1, 12, 0);

        // นำข้อมูลที่ได้จาก DB ไปใส่ใน Array
        foreach($results as $row){
            $monthlyData[$row->month] = (int)$row->count;
        }

        // แปลง key ของเดือน (1-12) ให้เป็นชื่อเดือนภาษาไทยแบบย่อ
        $monthLabels = [
            'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 
            'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'
        ];
        
        $chartData = [
            'labels' => $monthLabels,
            'data' => array_values($monthlyData) // เอาเฉพาะค่า value (จำนวนการจอง)
        ];
        
        return $chartData;
    }
}