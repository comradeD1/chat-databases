<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body>
    <h1>Регистрация</h1>
    <form method="post" , action="reg.php">
        <label for="username">Логин</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
    <?php
    include __DIR__.'\boot_sess.php';
    flash();
    ?>
</body>

</html>