<?php
include_once('include/auth.php');
include_once('models/Block.php');
include_once('include/types.php');
include_once('models/Category.php');
global $currentUser, $types, $typesCnt;

// ====== Проверить что блок указан и у нас есть на него права ======
if(!isset($_GET['block_id'])){
    header('Location: /home/blocks.php');
    die();
}

$block_id=$_GET['block_id'];
if(!is_numeric($block_id)) die();

$currentBlock=new Block($block_id);

if(!isset($currentBlock->user_id) || $currentUser->user_id != $currentBlock->user_id){
    header('Location: /home.php');
    die();
}
// ===== Все ок, можно работать ======

$currentType=$types[$currentBlock->type]->name;
if($currentBlock->subtype!="")
    $currentSubtype=$types[$currentBlock->type]->subTypes[$currentBlock->subtype]->name;
else
    $currentSubtype="";


if(!isset($_POST['save'])){
    $name=$currentBlock->name;
    $bgcolor=$currentBlock->bgcolor;
    $txtcolor=$currentBlock->txtcolor;

    $categories=Category::getForBlock($currentBlock->block_id);
}
else{
    $name=trim($_POST['name']);
    $bgcolor=trim($_POST['bgcolor']);
    $txtcolor=trim($_POST['txtcolor']);
    $categories=$_POST['categories'];

    $errors=$currentBlock->updateBlock($name, $bgcolor, $txtcolor);

    if(!$errors){
        if(!Category::updateForBlock($currentBlock->block_id, $categories))
            $errors[]='Не удалось обновить категории';
    }

    if(!$errors) $dataSaved=true;
}


?>
<?php
$title='Редактировать';
$css=array('style1.css');
?>
<?php include('parts/header.php'); ?>
<?php include('parts/user_name.php'); ?>

<a href="/home.php"><img src="/img/logo.jpg"/></a><br />
<?php include("parts/navigation.php"); ?>

<div class="text">
<?php
    if($dataSaved)
        echo "<p>Изменения сохранены</p>";
    if($errors){
        echo "<p>При сохранении возникли ошибки:</p> <ul>";
        foreach($errors as $error)
            echo "<li>{$error}</li>";
        echo "</ul>";
    }
?>

<h2>Рекламный блок № <?php echo $currentBlock->block_id ?> </h2>
<p>Тип: <?php echo $currentType ?> </p>

<?php
    if($currentSubtype!="")
        echo "<p>Подтип: {$currentSubtype}</p>";
?>

<form method="post" action="">
    <p>Имя <input type="text" name="name" value="<?php echo $name ?>"> </p>
    <p>Цвет фона <input type="text" name="bgcolor" value="<?php echo $bgcolor ?>"> </p>
    <p>Цвет текста <input type="text" name="txtcolor" value="<?php echo $txtcolor ?>"> </p>
    <p>Категории (отделяйте точкой с запятой) <br /> <input type="text" name="categories" value="<?php echo $categories ?>"></p>
    <input type="submit" name="save" value="Сохранить">
</form>

<a href="/home/blocks.php"><input type="button" value="Назад"></a>
</div>
<?php include('parts/footer.php'); ?>