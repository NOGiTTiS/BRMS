<?php
// โหลดไฟล์ Config ก่อนเสมอ
require_once 'config/config.php';

// โหลดไฟล์ Helpers **ก่อน** Core Libraries
// เพราะ Core (เช่น Controller) อาจต้องใช้ฟังก์ชันใน Helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php'; // ไฟล์นี้จะเริ่ม session_start() ด้วย

// โหลด Core Libraries
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Database.php';