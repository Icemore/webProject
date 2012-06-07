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


<form method='post' action='registration.php'>
<div class="main">
<div id="reg">
	<div class="field"><label for="name">Логин</label> <input type='text' name="login" value="<?php echo $login ?>"></div>
    <div class="field"><label for="full_name">Полное имя</label> <input type='text' name="full_name" value="<?php echo $full_name ?>"></div>
    <div class="field"><label for="email">E-mail</label> <input type="text" name="email" value="<?php echo $email ?>"></div>
    <div class="field"><label for="passwd">Пароль</label> <input type="password" name="passwd" value="<?php echo $passwd ?>"></div>
    <div class="field"><label for="ret_passwd">Повторите пароль</label> <input type="password" name="ret_passwd" value="<?php echo $ret_passwd ?>"> </div>
    <p><input type="submit" value='зарегистрироваться'>
	<a href="/index.php"><input type="button" value="назад"></a></p>
	</div>
</div>
</form>


<?php include('parts/footer.php'); ?>