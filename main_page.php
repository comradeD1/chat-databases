<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>


<body>
    <h1>Главная</h1>
    <?php
    require_once __DIR__.'/config.php';
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
    <div>
        <form method="get" action="main_page.php">
            <label for="search">Найти пользователя по тегу: </label>
            <input type="text" id="search" name="search" placeholder="Тег" minlength="4" maxlength="64" size="30">
            <button type="submit">Найти</button>
        </form>
    </div>

    <?php
    include __DIR__.'/boot_sess.php';
    if (isset($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $searchTerm = mysqli_real_escape_string($connection, trim($_GET['search']));
        $sqlReq = "SELECT * from `users` where `username` = '$searchTerm'";
        $findUser = mysqli_query($connection, $sqlReq) or die("Ошибка подключения: " . mysqli_error($connection));
        if (mysqli_num_rows($findUser) > 0){
            $row = mysqli_fetch_array($findUser, MYSQLI_ASSOC);
            echo '<a href="main_page.php?sel=' . $row["id"] . '">' . $row["username"] . '</a>';

            
        }
    }
    
    if (isset($_GET['sel'])) {
        $sessionKey=mysqli_real_escape_string($connection, $_COOKIE['session_key']);
        $myId = mysqli_real_escape_string($connection, $_COOKIE['user_id']);
        $peerId = mysqli_real_escape_string($connection, $_GET['sel']);
        $getPeerReq = "SELECT username FROM users where id ='$peerId'";
        $peerFetch = mysqli_query($connection, $getPeerReq) or die("Ошибка подключения: " . mysqli_error($connection));
        $peerUsername = mysqli_fetch_array($peerFetch, MYSQLI_ASSOC)['username'];
        // $messgesSql = "SELECT messages.* FROM messages JOIN users_sessions ON (messages.sender_id = users_sessions.user_id OR messages.receiver_id = users_sessions.user_id) WHERE users_sessions.session_key = '$sessionKey' AND ('$peerId' IN (messages.sender_id, messages.receiver_id))";
        $messgesSql = "SELECT * FROM messages where (sender_id = '$myId' AND receiver_id = '$peerId') OR (sender_id = '$peerId' AND receiver_id = '$myId')";
        $messgesFetch = mysqli_query($connection, $messgesSql) or die("Ошибка подключения: " . mysqli_error($connection));
        echo '<h3>' . $peerUsername . '</h3>';
        if (mysqli_num_rows($messgesFetch) > 0) {
            while ($row = mysqli_fetch_array($messgesFetch, MYSQLI_ASSOC)) {
                $styleClass = ($row['sender_id'] == $myId) ? 'my-message' : 'their_message';
                echo ('
                <div class="' . $styleClass . '">' . $row['content'] . '</div><br>
                ');
            };

        } else {
            echo 'Сообщений пока нет...';
        };
        echo '
        <form method="post" action="main_page.php">
        <textarea id="new_message" name="new_message" placeholder="Написать сообщение..."></textarea>
        <button type="submit">Отправить</button>
        </form>'; 
    }
        
    ?>
</body>

</html>