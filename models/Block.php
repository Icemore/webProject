<?php

class Block
{
    var $block_id, $user_id, $name,
            $type, $subtype,
        $bgcolor, $txtcolor;

    function initFromDbRow($row){
        $this->block_id=$row['block_id'];
        $this->user_id=$row['user_id'];
        $this->name=$row['name'];
        $this->type=$row['type'];
        $this->subtype=$row['subtype'];
        $this->bgcolor=$row['bgcolor'];
        $this->txtcolor=$row['txtcolor'];
    }

    function __construct($id){
        global $db;

        $res=$db->query("select * from Blocks where block_id=".$id);

        $this->initFromDbRow($res->fetch_assoc());
    }

    static private function checkColor($color){
        if(preg_match('/^#[0-9a-f]{6}$/i', $color)) return true;
        else return false;
    }

    static function checkData($name, $type, $subtype, $bgcolor, $txtcolor){
        $checkErrors=array();

        if(strlen($name)<3 || strlen($name)>30)
            $checkErrors[]='Неверная длина имени (от 3 до 30 символов)';

        if(!is_numeric($type))
            $checkErrors[]='Тип не является числом!';
        else if($type<0 || $type>2)
            $checkErrors[]='Неверный тип';

        if(!is_numeric($subtype))
            $checkErrors[]='Подтип не явлется числом!';

        if(!Block::checkColor($bgcolor))
            $checkErrors[]='Неверный фоновый цвет';

        if(!Block::checkColor($txtcolor))
            $checkErrors[]='Неверный цвет текста';

        return $checkErrors;
    }

    static function getByUser($user_id, $first=0, $last=2000000000){
        global $db;

        $query="select block_id from Blocks where user_id=".$user_id." limit ".$first.", ".$last;

        $res=$db->query($query);

        if(!$res)
            error_log('Failed to get Blocks by User_id: ('.$db->errno.') '.$db->error);

        $blocks=array();
        while($row=$res->fetch_assoc()){
            $blocks[]=new Block($row['block_id']);
        }

        return $blocks;
    }

    static function addBlock($user_id, $name, $type, $subtype, $bgcolor, $txtcolor){
        global $db;

        $name=trim($name);
        $bgcolor=trim($bgcolor);
        $txtcolor=trim($txtcolor);

        $regErrors=Block::checkData($name, $type, $subtype, $bgcolor, $txtcolor);

        if(!$regErrors){
            $name=mysqli_real_escape_string($db, $name);
            $bgcolor=mysqli_real_escape_string($db, strtolower($bgcolor));
            $txtcolor=mysqli_real_escape_string($db, strtolower($txtcolor));

            $query='insert into Blocks (user_id, name, type, subtype, bgcolor, txtcolor) values ("'.$user_id.'", "'.$name.'", "'.$type.'", "'.$subtype.'", "'.$bgcolor.'", "'.$txtcolor.'")';

            $res=$db->query($query);

            if(!$res){
                $regErrors[]='Произошла ошибка при добавлении блока в базу. Попробуйте позднее.';

                error_log('Failed to add Block: ('.$db->errno.') '.$db->error);
            }
        }

        return $regErrors;
    }

    function updateBlock($name, $bgcolor, $txtcolor){
        global $db;

        $name=trim($name);
        $bgcolor=trim($bgcolor);
        $txtcolor=trim($txtcolor);

        $regErrors=Block::checkData($name, 0, 0, $bgcolor, $txtcolor);

        if(!$regErrors){
            $name=mysqli_real_escape_string($db, $name);
            $bgcolor=mysqli_real_escape_string($db, strtolower($bgcolor));
            $txtcolor=mysqli_real_escape_string($db, strtolower($txtcolor));

            $query='update Blocks set name="'.$name.'", bgcolor="'.$bgcolor.'", txtcolor="'.$txtcolor.'" where block_id='.$this->block_id;

            $res=$db->query($query);

            if(!$res){
                $regErrors[]='Произошла ошибка при добавлении блока в базу. Попробуйте позднее.';

                error_log('Failed to update Block: ('.$db->errno.') '.$db->error);
            }
        }

        return $regErrors;
    }

}


