<?php

/*
 * Входные get параметры - block_id, adv_ids(список айдишников реклам через запятую)
 * Вернет готовый блок с рекламой
 */

include_once('include/types.php');
include_once('models/Adv.php');
include_once('models/Block.php');
global $types;

if(!isset($_GET['block_id']) || !isset($_GET['adv_ids'])) die();

$block_id=$_GET['block_id'];
$adv_ids=explode(',', $_GET['adv_ids']);


if(!is_numeric($block_id)) die();

$block=new Block($block_id);
$adv=getAdv($adv_ids);

//Проверка на нужное число объявлений
if($types[$block->type]->numAdv<0) {
    $subType=$types[$block->type]->subTypes[$block->subtype];
    $numAdv=$subType->rows * $subType->columns;
} else
    $numAdv=$types[$block->type]->numAdv;

if(count($adv)!=$numAdv) die();



//Путь к рекламному блоку
$pathToBlock='../blocks/';
$pathToBlock.=$block->type;
if($types[$block->type]->subTypes!=null)
    $pathToBlock.='/'.$block->subtype;
$pathToBlock.='.php';

if(!isset($_GET['callback'])) die;
$callback=$_GET['callback'];
if(!preg_match('/[a-z]+[a-zA-Z0-9]*/', $callback)) die();

//Заполнить и показать
ob_start();
include $pathToBlock;
$str = ob_get_clean();

echo $callback."(".json_encode($str).");";

//Функция принимает массив айдишников, возвращает массив Adv. По пути увеличивает число просмотров.
function getAdv($adv_ids){
    global $block_id;

    $res=array();
    foreach($adv_ids as $adv_id){
        if(!is_numeric($adv_id)) die();
        $adv=new Adv($adv_id);
        $adv->incrimentViews($block_id);
        $res[]=$adv;
    }

    return $res;
}