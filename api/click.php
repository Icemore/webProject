<?php

/*
 * Переход по рекламному объявлению
 *
 * Входные параметры: adv_id, block_id
 * Редиректит куда нужно
 */


if(!isset($_GET['adv_id']) || !isset($_GET['block_id'])) die();

$adv_id=$_GET['adv_id'];
$block_id=$_GET['block_id'];

if(!is_numeric($adv_id) || !is_numeric($block_id)) die();

include_once('models/Adv.php');
include_once('models/Block.php');

$adv=new Adv($adv_id);
$block=new Block($block_id);

$adv->incrimentClicks($block_id);

header('Location: '.$adv->url);