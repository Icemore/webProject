<?php

$uploadPath=$_SERVER['DOCUMENT_ROOT'].'adv_images/';

function get_image_info($file = NULL)
{
    if(!is_file($file)) return false;

    if(!$data = getimagesize($file) or !$filesize = filesize($file)) return false;

    $extensions = array(1 => 'gif', 2 => 'jpg',
        3 => 'png', 4 => 'swf',
        5 => 'psd', 6 => 'bmp',
        7 => 'tiff', 8 => 'tiff',
        9 => 'jpc', 10 => 'jp2',
        11 => 'jpx', 12 => 'jb2',
        13 => 'swc', 14 => 'iff',
        15 => 'wbmp', 16 => 'xbmp');

    $result = array('width' => $data[0],
        'height' => $data[1],
        'extension' => $extensions[$data[2]],
        'size' => $filesize,
        'mime' => $data['mime']);

    return $result;
}

function checkImage($file){
    $valid_extensions = array('gif', 'jpg', 'png');

    if(!$image_info = get_image_info($file) or !in_array($image_info['extension'], $valid_extensions))
        return false;
    else
        return $image_info;
}