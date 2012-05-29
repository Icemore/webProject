<?php

/*
 * Не совсем модель, скорее набор функций для работы с категориями
 */

class Category
{

    static function parse($str){
        $arr=explode(';', $str);

        foreach($arr as &$elem){
            $elem=strtolower(trim($elem));
        }

        return $arr;
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

    static function addForBlock($block_id, $str){
        global $db;

        $cats=Category::parse($str);

        if(!$cats || !Category::updateCategories($cats))
            return false;

        $catsId=Category::getCatsId($cats);

        $query='insert ignore into Block_Category (block_id, cat_id) values ';

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

    static function addForAdv($adv_id, $str){
        global $db;

        $cats=Category::parse($str);

        if(!$cats || !Category::updateCategories($cats))
            return false;

        $catsId=Category::getCatsId($cats);

        $query='insert ignore into Adv_Category (adv_id, cat_id) values ';

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

}
