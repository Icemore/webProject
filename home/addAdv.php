<?php
include_once('include/auth.php');
include_once('models/Adv.php');
include_once('models/Category.php');
include_once('include/types.php');
include_once('include/uploadFile.php');

if(isset($_POST['type'])){
    $typeId=$_POST['type'];

    if(!is_numeric($typeId) || $typeId<0 || $typeId>=$typesCnt)
        die();

    $currentType=$types[$typeId];
}

if($_POST['action']=='addAdv'){
    $name=trim($_POST['name']);
    $caption=trim($_POST['caption']);
    $text=trim($_POST['text']);
    $url=trim($_POST['url']);
    $categories=$_POST['categories'];

    $regErrors=array();
    if($currentType->hasImage){
        if($_FILES['adv_img']['size'] > 500*1024)
            $regErrors[]='Превышен максимальный размер файла (500Кб)';

        if(!is_uploaded_file($_FILES['adv_img']['tmp_name']))
            $regErrors[]='Не удалось загрузить файл';
        else
        if(!$imgInfo=checkImage($_FILES['adv_img']['tmp_name']))
            $regErrors[]='Неверный формат файла';
        else
        if($imgInfo['width']!=$currentType->imageWidth || $imgInfo['height']!=$currentType->imageHeight)
            $regErrors[]='Неверные размеры изображения';
    }

    if(!$regErrors){
        $regErrors=Adv::addAdv($currentUser->user_id, $name, $currentType->id, $caption, $text, $url);

        if(!$regErrors){
            global $uploadPath;
            $adv_id=mysqli_insert_id($db);

            error_log($uploadPath);

            move_uploaded_file($_FILES['adv_img']['tmp_name'], $uploadPath.$adv_id.'.'.$imgInfo['extension']);

            if(!Category::updateForAdv($adv_id, $categories))
                $regErrors[]='Не удалось добавить категории. Объявление создано';

            if(!$regErrors){
                header('Location: /home/adv.php');
            }
        }
    }
}

?>
<?php
$title='Добавить рекламу';
$css=array('style1.css');
?>
<?php include('parts/header.php'); ?>
<?php include('parts/user_name.php'); ?>

<a href="/home.php"><img src="/img/logo.jpg"/></a>

<h1>Выберите тип рекламы:</h1>

<?php
if(isset($regErrors)){
    echo '<h3>При добавлении объявления произошли ошибки:</h3> <ul>';

    foreach($regErrors as $error)
        echo '<li>'.$error.'</li>';

    echo '</ul>';
}
?>


    <form method="post" action="">
        <?php
        foreach($types as $type)
            echo '<p><input name="type" type="radio" value="'.$type->id.'" '.($type->id==$currentType->id ? 'checked' : '').'>'
                .$type->name
                .'</p>';
        ?>

        <input type="submit" value="Выбрать">
        <input name="action" type="hidden" value="select_type">
    </form>


    <?php //Прошу прощения за это, но как сделать по-другому я не знаю
    if(isset($currentType)){
        echo '<form method="post" enctype="multipart/form-data" action="">';
		echo '<div class="main">';
        echo '<div class="field"><label for="name">Имя</label><input type="text" name="name" value="'.$name.'" /></div>';
        if($currentType->hasCaption)
            echo '<div class="field"><label for="caption">Заголовок</label><input type="text" name="caption" value="'.$caption.'"></div>';
		if($currentType->hasText)
            echo '<div class="field"><label for="text">Текст объявления</label><input type="text" name="text" value="'.$text.'"></div>';

        if($currentType->hasImage){
            echo '<input type="hidden" name="MAX_FILE_SIZE" value="512000">';
            echo '<div class="field"><label for="adv_img">Изображение</label> <input name="adv_img" type="file"></div>';
        }

        echo '<div class="field"><label for="url">url</label> <input type="text" name="url" value="'.$url.'"</div>';

        echo '<div class="field"><label for="categories">Категории (отделяйте точкой с запятой)</label> <input type="text" name="categories" value="'.$categories.'"></div>';

        echo '<input type="hidden" name="type" value="'.$currentType->id.'">';
        echo '<input type="hidden" name="action" value="addAdv">';
        echo '<input type="submit" value="Добавить">';
		echo '</div>';
        echo '</form>';
    }
    ?>


<?php include('parts/footer.php'); ?>