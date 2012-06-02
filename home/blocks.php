<?php
include_once('include/auth.php');
include_once('models/Block.php');

$blocks=Block::getByUser($currentUser->user_id);

?>
<?php
$title='';
$css=array('');
?>
<?php include('parts/header.php'); ?>

<h2>Рекламные блоки</h2>
    <a href="/home/addBlock.php">Добавить</a>
    <table border="1">
        <?php
            foreach($blocks as $block){
                echo '<tr>';
                echo "<td><a href=\"/home/viewBlock.php?block_id={$block->block_id}\">{$block->block_id}</a></td>";
                echo "<td><a href=\"/home/viewBlock.php?block_id={$block->block_id}\">{$block->name}</a></td>";

                echo "<td>";
                echo "<a href=\"/home/editBlock.php?block_id={$block->block_id}\">Редактировать</a> ";
                echo "<a href=\"/home/deleteBlock.php?block_id={$block->block_id}\">Удалить</a>";
                echo "</td>";

                echo "</tr>";
            }
     ?>

    </table>

<?php include('parts/footer.php'); ?>