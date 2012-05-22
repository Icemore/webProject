<?php

//Если была попытка регистрации
if(isset($_POST['login'])){
    $in_login=trim($_POST['login']);
    $login=$in_login;

    //------ Логин ------

    if(strlen($login)<3 || strlen($login)>30)
        $regErrors[]='Неверная длина логина (от 3 до 30 символов)';

    if(!preg_match('/^[a-zA-Z][0-9a-zA-Z_]*$/', $login))
        $regErrors[]='Логин должен начинатся с буквы и состоять только из латинских букв, цифр и знака подчеркивания';

    $login=strtolower($login);
    include_once('include/db.php');

    $login=mysqli_real_escape_string($db, $login);

    //Если логин нормальный, проверяем не занят ли
    if(!isset($regErrors)){
        $res=$db->query('select * from Users where name="'.$login.'"');

        if($res->num_rows!=0)
            $regErrors[]='Такое имя пользователя уже занято';
    }


    //------ Пароль -------

    $in_passwd=trim($_POST['passwd']);
    $passwd=$in_passwd;
    if(strlen($passwd)<4)
        $regErrors[]='Слишком короткий пароль';

    $ret_passwd=$_POST['ret_passwd'];
    if($passwd!=$ret_passwd)
        $regErrors[]='Пароли не совпадают';

    $passwd=md5(md5($passwd));


    //------ Полное имя -------

    $in_full_name=trim($_POST['full_name']);
    $full_name=$in_full_name;
    if(!preg_match('/^[a-zA-Zа-яА-Я0-9 ]+$/u', $full_name))
        $regErrors[]='Полное имя содержит недопустимые символы';

    $full_name=mysqli_real_escape_string($db, $full_name);


    //------ email ------
    $in_email=trim($_POST['email']);
    $email=$in_email;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        $regErrors[]='Неверный email';

    $email=mysqli_real_escape_string($db, $email);


    //Если все хорошо, добавляем юзера
    if(!isset($regErrors)){
        $query='insert into Users (name, passwd, full_name, email) values ("'.$login.'", "'.$passwd.'", "'.$full_name.'", "'.$email.'")';
        $res=$db->query($query);

        if(!$res){
            $regErrors[]='Произошла ошибка при добавлении пользователя в базу. Поробуйте зайти позже.';
            error_log('Failed to add user: MySQL('.$db->errno.') '.$db->error);
        }
        else
            header('Location: successful.php');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
    <meta charset="UTF-8">
</head>
<body>

<?php
    if(isset($regErrors)){
        echo '<p>При регистрации произошли ошибки:</p> <ul>';
        foreach($regErrors as $error)
            echo '<li>'.$error.'</li>';
        echo '</ul>';
    }
?>

<form method='post' action='registration.php'>
    <p>Имя пользователя <input type='text' name="login" value="<?php echo $in_login ?>"></p>
    <p>Полное имя <input type='text' name="full_name" value="<?php echo $in_full_name ?>"></p>
    <p>E-mail <input type="text" name="email" value="<?php echo $in_email ?>"></p>
    <p>Пароль <input type="password" name="passwd" value="<?php echo $in_passwd ?>"></p>
    <p>Подтвердите пароль <input type="password" name="ret_passwd" value="<?php echo $ret_passwd ?>"> </p>
    <p><input type="submit" value='Зарегистрировать'></p>
</form>

</body>
</html>