<?php
require_once __DIR__.'/config.php';
include __DIR__.'/boot_sess.php';
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Ошибка подключения: " . mysqli_error($connect));
if (isset($_GET['logout'])) {
    $sqlReq = "DELETE FROM `users_sessions` WHERE `session_key` = '$_COOKIE[session_key]'";
    $abortSession = mysqli_query($connection, $sqlReq) or die("Ошибка подключения: " . mysqli_error($connection));
    setcookie("session_key", "", time() - 3600, '/');
    header('Location: .\login.php');

} else if (isset($_POST['username'])) {
    $username = mysqli_real_escape_string($connection, trim($_POST['username']));
    $pass = hash('sha256', trim($_POST['password']));
    $sqlReq = "SELECT * FROM `users` where `username` = '$username' AND `password` = '$pass' LIMIT 1";
    $checkUser = mysqli_query($connection, $sqlReq) or die("Ошибка подключения: " . mysqli_error($connection));
    if (mysqli_num_rows($checkUser) > 0) {
        $sessionKey = hash('sha512', trim($_POST['username']).$_SERVER['REMOTE_ADDR'].time());
        if ($row = mysqli_fetch_array($checkUser, MYSQLI_ASSOC)) {
            $userID = $row['id'];
        }

        $sqlReq = "INSERT INTO `users_sessions` (`user_id`,`session_key`) VALUES ('$userID', '$sessionKey')";
        mysqli_query($connection, $sqlReq) or die("Ошибка подключения: " . mysqli_error($connection));
        setcookie('session_key', $sessionKey, time()+3600);
        header('Location: .\main_page.php');
    } else {
        header('Location: .\login.php');
        flash('Логин и пароль неверны.');
    }
}
    // while ($row = mysqli_fetch_array($checkUser, MYSQLI_ASSOC)) {
    //             $id
    
    //     }
    // }

?>