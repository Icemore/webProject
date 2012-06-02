<?php
    session_start();
    if(isset($_SESSION['AUTH_OK'])){
        header('Location: /home.php');
        die();
    }
?>
<?php
    $title='Post it!';
    $css=array('style.css');
?>
<?php include('parts/header.php'); ?>

    <h1>Здравствуйте! Наша компания "Post It!" приветствует Вас!<br></h1>
    <div id="but">
	<p><a href="login.php"><input type="button" value="Log In"></a></p>
    <p><a href="registration.php"><input type="button" value="Sign up"></a></p>
	</div>

<?php include('parts/footer.php'); ?>