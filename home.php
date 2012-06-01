<?php
#include('include/auth.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post it!</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
    <meta charset="UTF-8">
</head>
<body>

<?php echo "<h1>Hi, ".$currentUser->full_name.". You are welcome!</h1>"; ?>
<div id="but">
<p><a href="home/adv.php">My Advertisment</a></p>
<p><a href="home/blocks.php">My Blocks</a></p>
</div>
<div id="name">
<a href="home/profile.php"><?php echo ".$currentUser->login." ?></a>
<a href=login.php?logout>Log Out</a>
</div>
</body>
</html>