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

<?php
    foreach($adv as $one_adv){
        echo '<p>'.$one_adv->name.'</p>';
    }
?>


</body>
</html>