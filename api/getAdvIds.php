<?php

/*
 * Принимает block_id
 * Возвращает массив айдишников подходящих реклам и число их в блоке
 */

include_once('models/Adv.php');
include_once('models/Block.php');
include_once('include/types.php');
global $types;

if(!isset($_GET['block_id'])) die();

$block_id=$_GET['block_id'];
if(!is_numeric($block_id)) die();

$block=new Block($block_id);

$advIds=Adv::getIdsForBlock($block);


if($types[$block->type]->numAdv<0) {
    $subType=$types[$block->type]->subTypes[$block->subtype];
    $numAdv=$subType->rows * $subType->columns;
} else
    $numAdv=$types[$block->type]->numAdv;


$res = array('numAdv' => $numAdv, 'advIds'=> $advIds);

var_dump($res);
