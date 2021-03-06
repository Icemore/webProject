<?php
session_start();

if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
    exit(0);
}

//Если уже залогинены идем домой
if(isset($_SESSION['AUTH_OK'])){
    header("Location: home.php");
    exit(0);
}


//Если это попытка логина проверяем пароль
if(isset($_POST['login']) && isset($_POST['passwd'])){
    include_once('include/db.php');
    include_once('models/User.php');

    $ok=User::checkLoginPass($_POST['login'], $_POST['passwd']);

    if($ok){
        $_SESSION['AUTH_OK']=true;
        $_SESSION['user_id']=$ok;

        header("Location: home.php");
    }
    else
        $loginFailed=true;
}
?>
<?php
$title='Вход';
$css=array('style.css');
?>
<?php include('parts/header.php'); ?>

<?php if(isset($_GET['notify'])) echo '<p>Для того чтобы продолжить вы должны войти</p>'; ?>
<?php if(isset($loginFailed)) echo '<p>Неверное имя пользователя или пароль</p>'; ?>

<h1>Вход</h1>

<div id="log">
<form method='post' action='login.php'>
	<p>Логин: <input type='text' name='login' size='15'></p>
    <p>Пароль: <input type='password' name='passwd' size='15'></p>
    <p> <input type='submit' value='войти'> 
	<a href="/index.php"><input type="button" value="назад"></a></p>
</form>
</div>

<?php include('parts/footer.php'); ?>