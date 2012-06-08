<?php
include_once('include/db.php');

/*
 * Не совсем модель, скорее набор функций для работы с категориями
 */

class Category
{

    static function parse($str){
        global $db;

        $arr=explode(';', $str);

        $res=array();
        foreach($arr as &$elem){
            $elem=strtolower(trim($elem));
            if($elem)
                $res[]=mysqli_real_escape_string($db, $elem);
        }

        return $res;
    }

    static function updateCategories($cats){
        global $db;

        $query='insert ignore into Categories (name) values ';

        foreach($cats as &$cat) $cat='("'.$cat.'")';

        $query=$query.implode(', ', $cats);

        $res=$db->query($query);

        if(!$res){
            error_log('Failed to update Categories ('.$db->errno.') '.$db->error);
        }

        return $res;
    }

    static function getCatsId($cats){
        global $db;

        $query='select cat_id from Categories where ';

        foreach($cats as &$cat)
            $cat='name="'.$cat.'"';

        $query=$query.implode(' or ', $cats);

        $res=$db->query($query);


        if(!$res)
            error_log('Failed to get Categories ID ('.$db->errno.') '.$db->error);

        $catsId=array();
        while($row=$res->fetch_assoc()){
            $catsId[]=$row['cat_id'];
        }

        return $catsId;
    }

    static function updateAndGetIds($str){
        $cats=Category::parse($str);

        if(!$cats) return "empty";
        if(!Category::updateCategories($cats)) return false;

        return Category::getCatsId($cats);
    }

    static function updateForBlock($block_id, $str){
        global $db;

        //Удалить все старые
        $db->query("delete from Block_Category where block_id=".$block_id);

        $catsId=Category::updateAndGetIds($str);
        if(!$catsId) return false;
        if($catsId=="empty") return true;

        //Добавить все новые
        $query='insert into Block_Category (block_id, cat_id) values ';

        $rows=array();
        foreach($catsId as $catId)
            $rows[]='('.$block_id.', '.$catId.')';

        $query=$query.implode(', ', $rows);

        $res=$db->query($query);

        if(!$res){
            error_log('Failed to update Block_Category ('.$db->errno.') '.$db->error);
            return false;
        }

        return true;
    }

    static function getForBlock($block_id){
        global $db;

        $query='select cat.name from Categories as cat, Block_Category as block_cat where block_cat.block_id='.$block_id.' and cat.cat_id=block_cat.cat_id';

        $res=$db->query($query);

        $cats=array();
        while($row=$res->fetch_assoc())
            $cats[]=$row['name'];

        return implode('; ', $cats);
    }

    static function updateForAdv($adv_id, $str){
        global $db;

        //Удалить все старые
        $db->query("delete from Adv_Category where adv_id=".$adv_id);

        $catsId=Category::updateAndGetIds($str);
        if(!$catsId) return false;
        if($catsId=="empty") return true;

        //Добавить все новые
        $query='insert into Adv_Category (adv_id, cat_id) values ';

        $rows=array();
        foreach($catsId as $catId)
            $rows[]='('.$adv_id.', '.$catId.')';

        $query=$query.implode(', ', $rows);

        $res=$db->query($query);

        if(!$res){
            error_log('Failed to update Adv_Category ('.$db->errno.') '.$db->error);
            return false;
        }

        return true;
    }

    static function getForAdv($adv_id){
        global $db;

        $query='select cat.name from Categories as cat, Adv_Category as adv_cat where adv_cat.adv_id='.$adv_id.' and cat.cat_id=adv_cat.cat_id';

        $res=$db->query($query);

        $cats=array();
        while($row=$res->fetch_assoc())
            $cats[]=$row['name'];

        return implode('; ', $cats);
    }

}
