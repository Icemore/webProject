<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $title ?></title>
    <?php
        foreach($css as $file)
            if($file) echo '<link rel="stylesheet" type="text/css" href="/css/'.$file.'" />';
    ?>
</head>
<body>