<?php
include_once('include/auth.php');
include_once('models/Block.php');

$blocks=Block::getByUser($currentUser->user_id);

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
</head>
<body>

<?php
    foreach($blocks as $block){
        echo "<p>".$block->name."</p>";
    }
?>

</body>
</html>