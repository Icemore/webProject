<?php
include_once('include/auth.php');
global $currentUser;

if(!isset($_POST['save'])){
    $full_name=$currentUser->full_name;
    $email=$currentUser->email;
    $passwd="";
    $new_passwd="";
    $ret_new_passwd="";

    $dataSaved=false;
}
else{
    $full_name=trim($_POST['full_name']);
    $email=trim($_POST['email']);
    $passwd=trim($_POST['passwd']);
    $new_passwd=trim($_POST['new_passwd']);
    $ret_new_passwd=trim($_POST['ret_new_passwd']);

    $regErrors=$currentUser->updateUser($passwd, $new_passwd, $ret_new_passwd, $full_name, $email);

    if(!$regErrors)
        $dataSaved=true;
    else
        $dataSaved=false;
}

?>
<?php
$title='Профиль';
$css=array('style.css');
?>
<?php include('parts/header.php'); ?>

<?php
    if($dataSaved)
        echo "<p>Данные сохранены.</p>";

    if(isset($regErrors)){
        echo "<p>При сохранении возникли ошибки:</p> <ul>";

        foreach($regErrors as $error)
            echo "<li>{$error}</li>";

        echo "</ul>";
    }
?>


<h1>Логин: <?php echo $currentUser->name ?></h1>

<form method="post" action="">
<div id="reg">
    <p>Полное имя <input type="text" name="full_name" value="<?php echo $full_name ?>"></p>
    <p>E-mail <input type="text" name="email" maxlength="30" value="<?php echo $email ?>"></p>
    <p>Старый пароль <input type="password" name="passwd" value="<?php echo $passwd ?>"></p>
    <p>Новый пароль <input type="password" name="new_passwd" value="<?php echo $new_passwd ?>"></p>
    <p>Повторите новый пароль <input  type="password" name="ret_new_passwd" value="<?php echo $ret_new_passwd ?>"></p>

    <p><input type="submit" name="save" value="сохранить">
	<a href="../home.php"><input type="button" value="на главную"></a></p>
	</div>
</form>

<?php include('parts/footer.php'); ?>