<?php


if (isset($_POST['username'])){
    require_once __DIR__.'/db_connect.php';
    if (((trim($_POST['username']) == '')) or (trim($_POST['password'] == '')))
    {
        $response = ['success' => false, 'message' => 'Заполните все поля!'];
        header('Content-Type: application/json');
        echo json_encode($response);
        die;
    }

    $username = trim($_POST['username']);
    $pass = hash('sha256', trim($_POST['password']));
    $sqlReq = "SELECT * FROM `users` WHERE `username` = :username";
    $stmt = $connect->prepare($sqlReq);
    $stmt->execute(['username' => $username]);
    if ($stmt -> rowCount() > 0){
        $response = ['success' => false, 'message' => 'Такое имя пользователя уже есть, попробуйте выбрать другое.'];
        header('Content-Type: application/json');
        echo json_encode($response);
        die;
    }

    else {
        $sqlReq = "INSERT INTO `users` (`username`, `password`) VALUES (:username, :pass)";
        $stmt = $connect->prepare($sqlReq);
        $stmt->execute(['username' => $username, 'pass' => $pass]);

        $response = ['success' => true, 'message' => 'Успешная регистрация!'];
        header('Content-Type: application/json');
        echo json_encode($response);

        }
    }

