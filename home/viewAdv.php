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
$categories=Category::getForAdv($currentAdv->adv_id);

$stat=$currentAdv->getStatistics();

?>
<?php
$title='';
$css=array('');
?>
<?php include('parts/header.php'); ?>

<h2>Рекламное объявление № <?php echo $currentAdv->adv_id ?> </h2>
    <p>Тип: <?php echo $currentType->name ?> </p>

    <?php
    if($currentType->hasImage)
        echo '<img border="0" src="/adv_images/'.$currentAdv->adv_id.'" width="'.$currentType->imageWidth.'" height="'.$currentType->imageHeight.'" />';
    ?>

    <p>Имя: <?php echo $currentAdv->name ?> </p>

    <?php
    if($currentType->hasCaption)
        echo '<p>Заголовок: '.$currentAdv->caption.'</p>';
    if($currentType->hasText)
        echo '<p>Текст: '.$currentAdv->text.'</p>';
    ?>

    <p>url: <?php echo $currentAdv->url; ?></p>
    <p>Категории: <?php echo $categories ?></p>


    <p><a href="/home/adv.php">Назад</a></p>

    <p>Всего просмотров: <?php echo $stat['summary']['views'] ?></p>
    <p>Всего переходов: <?php echo $stat['summary']['clicks'] ?></p>

<?php include('parts/footer.php'); ?>