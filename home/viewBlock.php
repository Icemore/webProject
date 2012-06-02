<?php
include_once('include/auth.php');
include_once('include/types.php');
include_once('models/Block.php');
include_once('models/Category.php');

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

$currentType=$types[$currentBlock->type]->name;
if($currentBlock->subtype!="")
    $currentSubtype=$types[$currentBlock->type]->subTypes[$currentBlock->subtype]->name;
else
    $currentSubtype="";

$categories=Category::getForBlock($currentBlock->block_id);

$stat = $currentBlock->getStatistics();

?>
<?php
$title='';
$css=array('');
?>
<?php include('parts/header.php'); ?>

<h2>Рекламный блок № <?php echo $currentBlock->block_id ?> </h2>
<p>Тип: <?php echo $currentType ?> </p>

<?php
if($currentSubtype!="")
    echo "<p>Подтип: {$currentSubtype}</p>";
?>


    <p>Имя: <?php echo $currentBlock->name ?> </p>
    <p>Цвет фона: <?php echo $currentBlock->bgcolor ?></p>
    <p>Цвет текста: <?php echo $currentBlock->txtcolor ?> </p>
    <p>Категории: <?php echo $categories ?></p>

    <p><a href="/home/blocks.php">Назад</a></p>

    <p>Всего просмотров: <?php echo $stat['summary']['views'] ?></p>
    <p>Всего переходов: <?php echo $stat['summary']['clicks'] ?></p>

    <?php
    if($stat['byUrl']!=null){
        echo "<p>Переходы на сайты:</p>";

            foreach($stat['byUrl'] as $row){
                echo "<p>{$row['url']}: {$row['clicks']}</p>";
            }
    }
    ?>

<?php include('parts/footer.php'); ?>