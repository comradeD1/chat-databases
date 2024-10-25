<?php


if (isset($_POST['username'])){
    require_once __DIR__.'\config.php';
    include __DIR__.'\boot_sess.php';
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Ошибка подключения: " . mysqli_error($connect));
    $connection -> set_charset('utf8');
    if (((trim($_POST['username']) == '')) or (trim($_POST['password'] == '')))
    {
            // flash('Заполните поля!');
            die('Заполните поля!');
    }

    $username = mysqli_real_escape_string($connection, trim($_POST['username']));
    $pass = hash('sha256', trim($_POST['password']));
    $sqlReq = "SELECT * FROM `users` WHERE `username` = '$username'";
    $checkUser = mysqli_query($connection, $sqlReq) or die("Ошибка подключения: " . mysqli_error($connection));
    if (mysqli_num_rows($checkUser) > 0) {
        header('Location: \index.php');
        flash('Такой пользователь уже есть.');
        // echo "Такой пользователь уже есть.";
    } else {
        $sqlReq = "INSERT INTO `users` (`username`, `password`) VALUES ('$username', '$pass')";
        $insert = mysqli_query($connection, $sqlReq) or die("Ошибка подключения: " . mysqli_error($connection));
        if (!$insert)
        {
            $_SESSION["messageSQL"] = mysqli_error($connection);
        }
        else
        {
            echo "Учётная запись создана.";
            // header('Location: \login.php')
        }
    }

}