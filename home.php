<?php
include('include/auth.php');
?>
<?php
$title='Post it!';
$css=array('style.css');
?>
<?php include('parts/header.php'); ?>

<?php echo "<h1>Здравствуйте, ".$currentUser->full_name.". Добро пожаловать!</h1>"; ?>

<div id="but">
<p><a href="home/adv.php">Моя реклама</a></p>
<p><a href="home/blocks.php">Мои блоки</a></p>
</div>

<?php include('parts/user_name.php'); ?>

<?php include('parts/footer.php'); ?>