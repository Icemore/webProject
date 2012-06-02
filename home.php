<?php
include('include/auth.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Post it!</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

<?php echo "<h1>Здравствуйте, ".$currentUser->full_name.". Добро пожаловать!</h1>"; ?>
<div id="but">
<p><a href="home/adv.php">Моя реклама</a></p>
<p><a href="home/blocks.php">Мои блоки</a></p>
</div>
<div id="name">
<a href="home/profile.php"><?php echo ".$currentUser->login." ?></a>
<a href=login.php?logout>Выход</a>
</div>
</body>
</html>