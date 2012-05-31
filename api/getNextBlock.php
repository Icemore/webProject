<?php

/*
 * Входные get параметры - block_id, sess_id
 * Вернет готовый блок с рекламой
 */

if(!isset($_GET['block_id']) || !isset($_GET['sess_id'])) die();

$block_id=$_GET['block_id'];
$sess_id=$_GET['sess_id'];

if(!is_numeric($block_id)) die();
if(!preg_match("/^[0-9a-zA-Z]+$/", $sess_id)) die();

include_once('include/db.php');
include_once('include/types.php');
include_once('models/Adv.php');
include_once('models/Block.php');
include_once('models/Viewer.php');
global $types;

$block=new Block($block_id);
$viewer=new Viewer($sess_id, $block);

$advIds=Adv::getIdsForBlock($block);
$advCnt=Adv::getCountForBlock($block);


$pathToBlock='../blocks/';

$pathToBlock.=$block->type;
if($types[$block->type]->subTypes!=null)
    $pathToBlock.='/'.$block->subtype;
$pathToBlock.='.php';


echo eval(file_get_contents($pathToBlock));

function getAdv($num){
    global $viewer, $advIds, $advCnt, $block_id;
    $res=array();


    for($i=0; $i<$num; $i++){
        $adv=new Adv($advIds[$viewer->getNextAdvIndex($advCnt)]);
        $adv->incrimentViews($block_id);
        $res[]=$adv;
    }

    return $res;
}