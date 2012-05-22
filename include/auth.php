<?php
session_start();

if(!isset($_SESSION['AUTH_OK'])){
    header("Location: /login.php?notify");
}