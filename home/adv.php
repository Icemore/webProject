<?php
include_once('include/auth.php');
include_once('models/Adv.php');

$adv=Adv::getByUser($currentUser->user_id);

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
</head>
<body>

<h2>Рекламные объявления</h2>
<a href="/home/addAdv.php">Добавить</a>
<table border="1">
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


</body>
</html>