<?php
include_once('include/auth.php');
include_once('models/Block.php');

if(!isset($_GET['block_id'])){
    header('Location: /home/blocks.php');
    die();
}
else{
    $block_id=$_GET['block_id'];

    if(!is_numeric($block_id)) die();

    $currentBlock=new Block($block_id);

    if(!isset($currentBlock->user_id) || $currentUser->user_id != $currentBlock->user_id){
        header('Location: /home.php');
        die();
    }
}

if(isset($_POST['refuse'])){
    header('Location: /home/blocks.php');
    die();
}

if(isset($_POST['confirm'])){
    $error=$currentBlock->deleteBlock();

    if(!$error){
        header('Location: /home/blocks.php');
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
<?php include("parts/navigation.php"); ?>

<div class="text">
<?php
    if(isset($error))
        echo "<p>{$error}</p>";
?>

<p style="color:chocolate">Вы действительно хотите удалить этот блок?</p>
<p>Номер: <?php echo $currentBlock->block_id ?> </p>
<p>Имя: <?php echo $currentBlock->name ?> </p>

<form method="post" action="">
    <input type="submit" name="confirm" value="Да">
    <input type="submit" name="refuse" value="Нет">
    <input type="hidden" name="block_id" value="<?php echo $currentBlock->block_id ?>">
</form>
</div>
<?php include('parts/footer.php'); ?>