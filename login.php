<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body>
    <h1>Вход</h1>
    <form method="post" , action="auth.php">
        <label for="username">Имя пользователя</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Войти</button>
    </form>
    <?php
    include __DIR__.'/boot_sess.php';
    flash();
    ?>
</body>

</html>