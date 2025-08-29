<?php
// check.php
session_start();
if (isset($_SESSION['test_message'])) {
    echo '<h1>SUCCESS!</h1>';
    echo '<p>' . $_SESSION['test_message'] . '</p>';
    unset($_SESSION['test_message']);
} else {
    echo '<h1>FAILURE!</h1>';
    echo '<p>Session message was lost.</p>';
}