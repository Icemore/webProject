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

    if(!$regErrors){
        header('Location: successful.php');
		die();
    }
}
?>
<?php
$title='Регистрация';
$css=array('style.css');
?>
<?php include('parts/header.php'); ?>

<?php
    if(isset($regErrors)){
        echo '<p>При регистрации произошли ошибки:</p> <ul>';
        foreach($regErrors as $error)
            echo '<li>'.$error.'</li>';
        echo '</ul>';
    }
?>

<h1>Регистрация</h1>

<div id="reg">
<form method='post' action='registration.php'>
	<p>Логин <input type='text' name="login" maxlength="15" value="<?php echo $login ?>"></p>
    <p>Полное имя <input type='text' name="full_name" value="<?php echo $full_name ?>"></p>
    <p>E-mail <input type="text" name="email" value="<?php echo $email ?>"></p>
    <p>Пароль <input type="password" name="passwd" value="<?php echo $passwd ?>"></p>
    <p>Повторите пароль <input type="password" name="ret_passwd" value="<?php echo $ret_passwd ?>"> </p>
    <p><input type="submit" value='sign up'></p>
</form>
</div>

<?php include('parts/footer.php'); ?>