<?php

function flash($message = null) {
    session_start();
    if ($message) {
        $_SESSION['flash_message'] = $message;
    } elseif (isset($_SESSION['flash_message'])) {
        echo $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
    }
}
?>