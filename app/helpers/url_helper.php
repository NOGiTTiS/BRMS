<?php
// ฟังก์ชันสำหรับ Redirect ไปยังหน้าต่างๆ
function redirect($page){
    header('location: ' . URLROOT . '/' . $page);
    exit(); // ควร exit() ทุกครั้งหลัง redirect เพื่อหยุดการทำงานของสคริปต์ทันที
}