<?php
// ไฟล์นี้ใช้สำหรับสร้าง Password Hash ชั่วคราวเท่านั้น
// เมื่อได้ Hash แล้ว สามารถลบไฟล์นี้ทิ้งได้เลย

$passwordToHash = 'admin';

// ใช้ฟังก์ชัน password_hash ของ PHP เพื่อสร้าง Hash
// PASSWORD_DEFAULT คืออัลกอริทึมที่แนะนำและปลอดภัยที่สุดในปัจจุบัน (Bcrypt)
$hashedPassword = password_hash($passwordToHash, PASSWORD_BCRYPT);

// แสดงผล Hash ที่ได้
echo 'รหัสผ่านธรรมดา: ' . htmlspecialchars($passwordToHash) . '<br><br>';
echo 'Password Hash ที่สร้างใหม่คือ: <br>';
echo '<strong style="font-size: 1.2rem; color: green;">' . htmlspecialchars($hashedPassword) . '</strong><br><br>';
echo 'กรุณาคัดลอก (Copy) ข้อความสีเขียวนี้ไปใช้ในขั้นตอนต่อไป';
