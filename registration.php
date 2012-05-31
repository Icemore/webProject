<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
    <meta charset="UTF-8">
</head>
<body>
<h1>Registration</h1>

<form method='post' action='registration.php'>
    <div id="reg">
	<p>Username <input type='text' name="login" value="<?php echo $login ?>"></p>
    <p>Full name <input type='text' name="full_name" value="<?php echo $full_name ?>"></p>
    <p>E-mail <input type="text" name="email" value="<?php echo $email ?>"></p>
    <p>Password <input type="password" name="passwd" value="<?php echo $passwd ?>"></p>
    <p>Confirm the password <input type="password" name="ret_passwd" value="<?php echo $ret_passwd ?>"> </p>
    <p><input type="submit" value='sign up'></p>
	</div>
</form>
<?php

//Если была попытка регистрации
if(isset($_POST['login'])){
    $login=trim($_POST['login']);
    $passwd=trim($_POST['passwd']);
    $ret_passwd=trim($_POST['ret_passwd']);
    $full_name=trim($_POST['full_name']);
    $email=trim($_POST['email']);

    include_once('include/db.php');
    include_once('models/User.php');

    $regErrors=User::addUser($login, $passwd, $ret_passwd, $full_name, $email);

    if(!$regErrors)
        header('Location: successful.php');
}
?>
<?php
    if(isset($regErrors)){
        echo '<p>При регистрации произошли ошибки:</p> <ul>';
        foreach($regErrors as $error)
            echo '<li>'.$error.'</li>';
        echo '</ul>';
    }
?>
</body>
</html>