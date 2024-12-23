<?php
require_once __DIR__.'/config.php';
include __DIR__.'/boot_sess.php';
require_once __DIR__.'/db_connect.php';

if (isset($_GET['logout'])) {

    $stmt = $connect->prepare("DELETE FROM users_sessions WHERE session_key = :session_key");
    $stmt->execute(['session_key' => $_COOKIE['session_key']]);
    setcookie("session_key", "", time() - 3600, '/');
    header('Location: .\login.php');


} else if (isset($_POST['username'])) {
    $username = trim($_POST['username']);
    $pass = hash('sha256', trim($_POST['password']));
    $stmt = $connect->prepare("SELECT * FROM `users` where `username` = :username AND `password` = :pass LIMIT 1");
    $stmt->execute(['username' => $username, 'pass' => $pass]);
    if ($stmt->rowCount() > 0) {
        $sessionKey = hash('sha512', trim($_POST['username']).$_SERVER['REMOTE_ADDR'].time());
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $userId = $row['id'];
        }

        $sqlReq = "INSERT INTO `users_sessions` (`user_id`,`session_key`) VALUES (:userID, :sessionKey)";
        $stmt = $connect->prepare($sqlReq);
        $stmt->execute(['userID' => $userId, 'sessionKey' => $sessionKey]);
        setcookie('session_key', $sessionKey, time()+3600);
        $response = ['success' => true, 'message' => 'Вы вошли.'];
        header('Content-Type: application/json');
        echo json_encode($response);
        die;

    } else {
        $response = ['success' => false, 'message' => 'Проверьте верность введеных данных и повторите попытку.'];
        header('Content-Type: application/json');
        echo json_encode($response);
        die;
    }
}

?>