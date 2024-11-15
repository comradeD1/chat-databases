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
    include __DIR__.'/boot_sess.php';
    flash();
    ?>
    <a href="auth.php?logout=1" class="button">Выйти</a>
</body>

</html>