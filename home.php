<?php
include('include/auth.php');

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
</head>
<body>

<?php echo "<h3>Hi ".$currentUser->full_name."</h3>"; ?>
<p>Home, sweet home.</p>
<a href=login.php?logout>Выйти</a>

</body>
</html>