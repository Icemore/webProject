<?php
include_once('include/auth.php');
include_once('models/Adv.php');

$adv=Adv::getByUser($currentUser->user_id);
?>
<?php
$title='Моя реклама';
$css=array('style1.css');
?>
<?php include('parts/header.php'); ?>
<?php include('parts/user_name.php'); ?>

<a href="/home.php"><img src="/img/logo.jpg"/></a><br />
<?php include("parts/navigation.php"); ?>

<a href="/home/addAdv.php">Добавить рекламу</a>
<table width="40%" border="3" cellspacing="5" bordercolor="maroon">
<thead style="color:BlanchedAlmond">
<caption> Реклама пользователя <?php echo $currentUser->name ?> </caption>
 <tr width="100">
  <th>Номер</th>
  <th>Имя</th>
  <th>Действия</th>
 </tr>
</thead>
    <?php
    foreach($adv as $oneAdv){
        echo '<tr>';
        echo "<td><a href=\"/home/viewAdv.php?adv_id={$oneAdv->adv_id}\">{$oneAdv->adv_id}</a></td>";
        echo "<td><a href=\"/home/viewAdv.php?adv_id={$oneAdv->adv_id}\">{$oneAdv->name}</a></td>";

        echo "<td>";
        echo "<a href=\"/home/editAdv.php?adv_id={$oneAdv->adv_id}\">Редактировать</a> ";
        echo "<a href=\"/home/deleteAdv.php?adv_id={$oneAdv->adv_id}\">Удалить</a>";
        echo "</td>";

        echo "</tr>";
    }
    ?>

</table>


<?php include('parts/footer.php'); ?>