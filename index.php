<?php
    session_start();
    if(isset($_SESSION['AUTH_OK']))
        header('Location: /home.php');
?>


<html>
<head>
    <title>Главная страница</title>
    <meta charset="UTF-8">
</head>
<body>

    <h1>Добро пожаловать!</h1>
    <p><a href="login.php">Вход</a></p>
    <p><a href="registration.php">Регистрация</a></p>
</body>
</html>