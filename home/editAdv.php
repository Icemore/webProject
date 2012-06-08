<?php
include_once('include/auth.php');
include_once('models/Adv.php');
include_once('include/types.php');
include_once('models/Category.php');

if(!isset($_GET['adv_id'])){
    header('Location: /home/adv.php');
    die();
}

$adv_id=$_GET['adv_id'];

if(!is_numeric($adv_id)) die();

$currentAdv=new Adv($adv_id);

if(!isset($currentAdv->user_id) || $currentUser->user_id != $currentAdv->user_id){
    header('Location: /home.php');
    die();
}

$currentType=$types[$currentAdv->type];

if(!isset($_POST['save'])){
    $name=$currentAdv->name;
    $text=$currentAdv->text;
    $caption=$currentAdv->caption;
    $url=$currentAdv->url;

    $categories=Category::getForAdv($currentAdv->adv_id);
}
else{
    $name=trim($_POST['name']);
    $text=trim($_POST['text']);
    $caption=trim($_POST['caption']);
    $url=trim($_POST['url']);
    $categories=$_POST['categories'];

    $errors=$currentAdv->updateAdv($name, $caption, $text, $url);

    if(!$errors){
        if(!Category::updateForAdv($currentAdv->adv_id, $categories))
            $errors[]='Не удалось обновить категории';
    }

    if(!$errors)
        $dataSaved=true;
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

<h2>Рекламное объявление № <?php echo $currentAdv->adv_id ?> </h2>
<p>Тип: <?php echo $currentType->name ?> </p>

<?php
    if($currentType->hasImage)
        echo '<img border="0" src="/adv_images/'.$currentAdv->adv_id.'" width="'.$currentType->imageWidth.'" height="'.$currentType->imageHeight.'" />';
?>


<form method="post" action="">
    <p>Имя <input type="text" name="name" value="<?php echo $name ?>"> </p>

    <?php
    if($currentType->hasCaption)
        echo '<p>Заголовок <input type="text" name="caption" value="'.$caption.'"></p>';
    if($currentType->hasText)
        echo '<p>Текст <input type="text" name="text" value="'.$text.'"></p>';
    ?>

    <p>url <input type="text" name="url" value="<?php echo $url; ?>"></p>
    <p>Категории (отделяйте точкой с запятой)<br /> <input type="text" name="categories" value="<?php echo $categories ?>"></p>

    <input type="submit" name="save" value="Сохранить">
</form>

<a href="/home/adv.php"><input type="button" value="Назад"></a>
</div>
<?php include('parts/footer.php'); ?>