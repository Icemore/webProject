<?php

class Adv
{
    var $adv_id, $user_id,
        $name, $type, $caption, $text, $url;

    function initFromDbRow($row){
        $this->adv_id=$row['adv_id'];
        $this->user_id=$row['user_id'];
        $this->name=$row['name'];
        $this->type=$row['type'];
        $this->caption=$row['caption'];
        $this->text=$row['text'];
        $this->url=$row['url'];
    }

    function __construct($id){
        global $db;

        $res=$db->query('select * from Adv where adv_id='.$id);

        $this->initFromDbRow($res->fetch_assoc());
    }


    static function getByUser($user_id, $first=0, $last=2000000000){
        global $db;

        $query="select adv_id from Adv where user_id=".$user_id." limit ".$first.", ".$last;

        $res=$db->query($query);

        if(!$db->errno)
            error_log('Failed to get Adv by User_id: ('.$db->errno.') '.$db->error);

        $adv=array();
        while($row=$res->fetch_assoc()){
            $adv[]=new Adv($row['adv_id']);
        }

        return $adv;
    }

    static function checkData($name, $type, $caption, $text, $url){
        $checkErrors=array();

        if(strlen($name)<3 || strlen($name)>30)
            $checkErrors[]='Неверная длина имени (от 3 до 30 символов)';

        if(!is_numeric($type))
            $checkErrors[]='Тип не является числом!';

        /* TODO: ограничения на caption и text
         * длина caption и text зависит от типа!
         */


        if(!filter_var($url, FILTER_VALIDATE_URL))
            $checkErrors[]='Неверный url';

        return $checkErrors;
    }

    static function addAdv($user_id, $name, $type, $caption, $text, $url){
        global $db;

        $name=trim($name);
        $caption=trim($caption);
        $text=trim($text);
        $url=trim($url);

        $regErrors=Adv::checkData($name, $type, $caption, $text, $url);

        if(!$regErrors){
            $name=mysqli_real_escape_string($db, $name);
            $caption=mysqli_real_escape_string($db, $caption);
            $text=mysqli_real_escape_string($db, $text);
            $url=mysqli_real_escape_string($db, $url);

            $query='insert into Adv (user_id, name, type, caption, text, url) values ("'.$user_id.'", "'.$name.'", "'.$type.'", "'.$caption.'", "'.$text.'", "'.$url.'")';

            $res=$db->query($query);

            if(!$res){
                $regErrors[]='Произошла ошибка при добавлении объявления в базу. Попробуйте позднее.';

                error_log('Failed to add Adv: ('.$db->errno.') '.$db->error);
            }
        }

        return $regErrors;
    }

    function updateAdv($name, $caption, $text, $url){
        global $db;

        $name=trim($name);
        $caption=trim($caption);
        $text=trim($text);
        $url=trim($url);

        $regErrors=Adv::checkData($name, 0, $caption, $text, $url);

        if(!$regErrors){
            $name=mysqli_real_escape_string($db, $name);
            $caption=mysqli_real_escape_string($db, $caption);
            $text=mysqli_real_escape_string($db, $text);
            $url=mysqli_real_escape_string($db, $url);

            $query='update Adv set name="'.$name.'", caption="'.$caption.'", text="'.$text.'", url="'.$url.'" where adv_id='.$this->adv_id;

            $res=$db->query($query);

            if(!$res){
                $regErrors[]='Произошла ошибка при добавлении объявления в базу. Попробуйте позднее.';

                error_log('Failed to update Adv: ('.$db->errno.') '.$db->error);
            }
        }

        return $regErrors;
    }

}
