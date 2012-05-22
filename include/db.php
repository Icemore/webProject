<?php
$db = new mysqli('localhost', 'advUser', 'asd123', 'advDB');

if($db->connect_errno){
    echo 'Подключение к базе данных не может быть установленно. Попробуйте зайти позже';

    error_log('Failed to connect to MySQL: ('.$db->connect_errno.') '.$db->connect_error);
    die();
}