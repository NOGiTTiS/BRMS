<?php
// test.php
session_start();
$_SESSION['test_message'] = 'Session is working!';
echo 'Session has been set. <a href="check.php">Click here to check.</a>';