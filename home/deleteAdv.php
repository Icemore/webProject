<?php
include_once('include/auth.php');
include_once('models/Adv.php');

if(!isset($_GET['adv_id'])){
    header('Location: /home/adv.php');
    die();
}
else{
    $adv_id=$_GET['adv_id'];

    if(!is_numeric($adv_id)) die();

    $currentAdv=new Adv($adv_id);

    if(!isset($currentAdv->user_id) || $currentUser->user_id != $currentAdv->user_id){
        header('Location: /home.php');
        die();
    }
}

if(isset($_POST['refuse'])){
    header('Location: /home/adv.php');
    die();
}

if(isset($_POST['confirm'])){
    $error=$currentAdv->deleteAdv();

    if(!$error){
        header('Location: /home/adv.php');
        die();
    }
}

?>
<?php
$title='Удалить';
$css=array('style1.css');
?>
<?php include('parts/header.php'); ?>
<?php include('parts/user_name.php'); ?>

<a href="/home.php"><img src="/img/logo.jpg"/></a><br />
<div id="navig"><a href="/home/adv.php">Моя реклама</a><br />
<a href="/home/blocks.php">Мои блоки</a></div>

<div class="text">
<?php
if(isset($error))
    echo "<p>{$error}</p>";
?>

<p style="color:chocolate">Вы действительно хотите удалить это объявление?</p>
<p>Номер: <?php echo $currentAdv->adv_id ?> </p>
<p>Имя: <?php echo $currentAdv->name ?> </p>

<form method="post" action="">
    <input type="submit" name="confirm" value="Да">
    <input type="submit" name="refuse" value="Нет">
    <input type="hidden" name="adv_id" value="<?php echo $currentAdv->adv_id ?>">
</form>
</div>
<?php include('parts/footer.php'); ?>