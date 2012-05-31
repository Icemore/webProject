<?php
include_once('include/db.php');
include_once('models/Block.php');
include_once('models/Adv.php');

class Viewer
{
    var $sess_id, $block_id, $cur_pos, $rand_seed, $array_size;

    function __construct($sess_id, &$block){
        global $db;

        $res=$db->query('select * from Viewers where sess_id="'.$sess_id.'" and block_id="'.$block->block_id.'"');

        if($res->num_rows==0){
            $this->initNew($sess_id, $block);
        }else{
            $row=$res->fetch_assoc();

            $this->sess_id=$row['sess_id'];
            $this->block_id=$row['block_id'];
            $this->cur_pos=$row['cur_pos'];
            $this->rand_seed=$row['rand_seed'];
            $this->array_size=$row['array_size'];
        }
    }

    function initNew($sess_id, &$block){
        global $db;

        $this->sess_id=$sess_id;
        $this->block_id=$block->block_id;

        $advCnt= Adv::getCountForBlock($block);

        $this->genNewArray($advCnt);

        $res=$db->query('insert into Viewers (sess_id, block_id, cur_pos, rand_seed, array_size) values ("'.$this->sess_id.'", "'.$this->block_id.'", "'.$this->cur_pos.'", "'.$this->rand_seed.'", "'.$this->array_size.'")');

        if(!$res){
            error_log('Failed to insert Viewer ('.$db->errno.'): '.$db->error);
        }
    }

    private function getShuffledArray(){
        $arr=range(0, $this->array_size-1);
        srand($this->rand_seed);
        shuffle($arr);

        return $arr;
    }

    private function genNewArray($advCnt){
        $this->rand_seed=rand();
        $this->array_size=2*$advCnt;
        $this->cur_pos=0;
    }

    function updateViewer(){
        global $db;

        $query='update Viewers set cur_pos="'.$this->cur_pos.'", rand_seed="'.$this->rand_seed.'", array_size="'.$this->array_size.'"';
        $res=$db->query($query);

        if(!$res){
            error_log('Failed to update Viewer ('.$db->errno.'): '.$db->error);
        }
    }

    function getNextAdvIndex($advCnt){
        $arr=$this->getShuffledArray();


        $pos=$this->cur_pos;
        while($pos<$this->array_size && $arr[$pos]>=$advCnt) $pos++;

        if($pos==$this->array_size){
            $this->genNewArray($advCnt);
            return $this->getNextAdvIndex($advCnt);
        }
        else{
            $this->cur_pos=$pos+1;
            $this->updateViewer();

            return $arr[$pos];
        }
    }

}
