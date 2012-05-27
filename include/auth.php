<?php
session_start();

if(!isset($_SESSION['AUTH_OK'])){
    header("Location: /login.php?notify");
}
else{
    include_once('db.php');
    include_once('models/User.php');

    $currentUser=new User($_SESSION['user_id']);
}