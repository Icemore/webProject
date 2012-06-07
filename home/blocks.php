<?php
include_once('include/auth.php');
include_once('models/Block.php');

$blocks=Block::getByUser($currentUser->user_id);

?>
<?php
$title='Мои блоки';
$css=array('style1.css');
?>
<?php include('parts/header.php'); ?>
<?php include('parts/user_name.php'); ?>

<a href="/home.php"><img src="/img/logo.jpg"/></a><br />
<?php include("parts/navigation.php"); ?>

    <a href="/home/addBlock.php">Добавить блок</a>
    <table width="40%" border="3" cellspacing="5" bordercolor="maroon">
	<thead style="color:BlanchedAlmond">
		<caption> Блоки пользователя <?php echo $currentUser->name ?> </caption>
		<tr width="100">
			<th>Номер</th>
			<th>Имя</th>
			<th>Действия</th>
		</tr>
	</thead>
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