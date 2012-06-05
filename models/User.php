<?php
include_once('include/db.php');

class User{
    var $user_id;
    var $name;
    var $full_name;
    var $email;
    var $passwd;

    function __construct($_id){
        global $db;

        $this->user_id=$_id;

        $res=$db->query("select name, full_name, passwd, email from Users where user_id=".$_id);
        //echo 'My: '.$db->errno.' '.$db->error;

        $row=$res->fetch_assoc();

        $this->name=$row['name'];
        $this->full_name=$row['full_name'];
        $this->email=$row['email'];
        $this->passwd=$row['passwd'];
    }

    static function checkLoginPass($_login, $_passwd){
        global $db;

        $login=trim($_login);
        $passwd=trim($_passwd);

        $login=strtolower($login);
        $login=mysqli_real_escape_string($db, $login);
        $passwd=md5(md5($passwd));

        $res=$db->query('select user_id from Users where name="'.$login.'" and passwd="'.$passwd.'"');

        if($res->num_rows==1) {
            $row=$res->fetch_assoc();
            return $row['user_id'];
        }
        else return 0;
    }

    /*
    *    Проверяет _заполненные_ поля на соответствие формату
    *    Возвращает список ошибок
    */
    static function checkData($login, $passwd, $ret_passwd, $full_name, $email){
        global $db;

        //------ Логин ------
        if($login!=""){
            if(mb_strlen($login, "utf8")<3 || mb_strlen($login, "utf8")>30)
                $checkErrors[]='Неверная длина логина (от 3 до 30 символов)';

            if(!preg_match('/^[a-zA-Z][0-9a-zA-Z_]*$/', $login))
                $checkErrors[]='Логин должен начинатся с буквы и состоять только из латинских букв, цифр и знака подчеркивания';


            //Если логин нормальный, проверяем не занят ли
            if(!isset($checkErrors)){
                $login=mysqli_real_escape_string($db, strtolower($login));
                $res=$db->query('select * from Users where name="'.$login.'"');

                if($res->num_rows!=0)
                    $checkErrors[]='Такое имя пользователя уже занято';
            }
        }

        //------ Пароль -------
        if($passwd!=""){
            if(mb_strlen($passwd, "utf8")<4)
                $checkErrors[]='Слишком короткий пароль (от 4х символов)';

            if($passwd!=$ret_passwd)
                $checkErrors[]='Пароли не совпадают';
        }


        //------ Полное имя -------
        if($full_name!=""){
            if(!preg_match('/^[a-zA-Zа-яА-Я0-9 ]+$/u', $full_name))
                $checkErrors[]='Полное имя содержит недопустимые символы';
        }

        //------ email ------
        if($email!=""){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                $checkErrors[]='Неверный email';
        }

        return $checkErrors;
    }

    static function addUser($_login, $_passwd, $_ret_passwd, $_full_name, $_email){
        global $db;

        $login=trim($_login);
        $passwd=trim($_passwd);
        $ret_passwd=trim($_ret_passwd);
        $full_name=trim($_full_name);
        $email=trim($_email);

        $regErrors=User::checkData($login, $passwd, $ret_passwd, $full_name, $email);

        if($login=="" || $passwd=="" || $full_name=="" || $email=="")
            $regErrors[]="Одно из обязательных полей не заполнено";



        //Если все хорошо, добавляем юзера
        if(!isset($regErrors)){

            $login=mysqli_real_escape_string($db, strtolower($login));
            $passwd=md5(md5($passwd));
            $email=mysqli_real_escape_string($db, $email);
            $full_name=mysqli_real_escape_string($db, $full_name);


            $query='insert into Users (name, passwd, full_name, email) values ("'.$login.'", "'.$passwd.'", "'.$full_name.'", "'.$email.'")';
            $res=$db->query($query);

            if(!$res){
                $regErrors[]='Произошла ошибка при добавлении пользователя в базу. Поробуйте зайти позже.';
                error_log('Failed to add user: MySQL('.$db->errno.') '.$db->error);
            }
        }

        return $regErrors;
    }

    function updateUser($passwd, $new_passwd, $ret_new_passwd, $full_name, $email){
        global $db;

        $passwd=trim($passwd);
        $new_passwd=trim($new_passwd);
        $ret_new_passwd=trim($ret_new_passwd);
        $full_name=trim($full_name);
        $email=trim($email);


        $regErrors=User::checkData("", $new_passwd, $ret_new_passwd, $full_name, $email);

        if($full_name=="" || $email=="")
            $regErrors[]="Одно из обязательных полей не заполнено";

        //Попытка изменить пароль
        if($passwd!=""){
            if($this->passwd!=md5(md5($passwd)))
                $regErrors[]="Неверный старый пароль";
        }else{
            if($new_passwd!="")
                $regErrors[]="Введите старый пароль";
        }

        if(!isset($regErrors)){
            if($new_passwd=="") $new_passwd=$this->passwd;
            else $new_passwd=md5(md5($new_passwd));
            $email=mysqli_real_escape_string($db, $email);
            $full_name=mysqli_real_escape_string($db, $full_name);

            $query='update Users set passwd="'.$new_passwd.'", full_name="'.$full_name.'", email="'.$email.'" where user_id='.$this->user_id;
            $res=$db->query($query);

            if(!$res){
                $regErrors[]='Произошла ошибка при добавлении пользователя в базу. Поробуйте зайти позже.';
                error_log('Failed to update user: MySQL('.$db->errno.') '.$db->error);
            }else{
                $this->full_name=$full_name;
                $this->email=$email;
                $this->passwd=$new_passwd;
            }
        }

        return $regErrors;
    }


}
