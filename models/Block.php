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

}


