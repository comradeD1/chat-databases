<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body>
    <h1>Главная</h1>
    <?php
    require_once __DIR__.'/config.php';
    // include __DIR__.'/boot_sess.php';
    // flash();
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Ошибка подключения: " . mysqli_error($connect));

    if (!isset($_COOKIE['session_key'])) {
        header('Location: .\login.php');
        
    } else if (!empty($_COOKIE['session_key'])) {
        $sessionKey=mysqli_real_escape_string($connection, $_COOKIE['session_key']);
        $sqlReq = "SELECT users.* FROM `users_sessions` JOIN `users` ON users_sessions.user_id = users.id WHERE users_sessions.session_key = '$sessionKey'";
        $userData = mysqli_query($connection, $sqlReq) or die("Ошибка подключения: " . mysqli_error($connection));
        if ($userRow = mysqli_fetch_assoc($userData)) {
                echo("Привет, {$userRow['username']}!");
        }
    }
    ?>
    <a href="auth.php?logout=1" class="button">Выйти</a>
</body>

</html>