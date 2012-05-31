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
<p><a href="home/adv.php"><input type="button" value="My Advertisments"></a></p>
<p><a href="home/blocks.php"><input type="button" value="My Blocks"></a></p>
<p><a href="home/profile.php"><input type="button" value="Change my information"></a></p>
<p><a href=login.php?logout><input type="button" value="Log Out"></a></p>
</div>
</body>
</html>