<?php
include_once('include/auth.php');
include_once('include/types.php');
include_once('models/Block.php');
include_once('models/Category.php');
include_once('include/db.php');

if(isset($_POST['type'])){
    $typeId=$_POST['type'];
    if(!is_numeric($typeId) || $typeId<0 || $typeId>=$typesCnt)
        die();

    $currentType=$types[$typeId];
}

if($_POST['action']=='addBlock'){
    $subType=$_POST['subtype'];
    $name=trim($_POST['name']);
    $bgcolor=$_POST['bgcolor'];
    $txtcolor=$_POST['txtcolor'];
    $categories=$_POST['categories'];

    $regErrors=Block::addBlock($currentUser->user_id, $name, $currentType->id, $subType, $bgcolor, $txtcolor);


    if(!$regErrors){
        $block_id=mysqli_insert_id($db);
        if(!Category::updateForBlock($block_id, $categories))
            $regErrors[]='Не удалось добавить категории.<br /> Рекламный блок создан.';

        if(!$regErrors)
            header('Location: /home/blocks.php');
    }
}

?>
<?php
$title='Добавить';
$css=array('style1.css');
?>
<?php include('parts/header.php'); ?>
<?php include('parts/user_name.php'); ?>

<a href="/home.php"><img src="/img/logo.jpg"/></a>
<div id="navig"><a href="/home/adv.php">Моя реклама</a><br />
<a href="/home/blocks.php">Мои блоки</a></div>

<div id="add"><h1 style="color:maroon">Выберите тип блока:</h1></div>
<div id="osh">
    <?php
        if(isset($regErrors)){
            echo '<h3>При добавлении блока произошли ошибки:</h3><ul>';

            foreach($regErrors as $error)
                echo '<li>'.$error.'</li>';

            echo '</ul>';
        }
    ?>
</div>

<div id="add4">
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
</div>

<div id="add2">
    <?php //Прошу прощения за это, но как сделать по-другому я не знаю
        if(isset($currentType)){
            echo '<form method="post" action="">';

            if(isset($currentType->subTypes)){
                echo '<select name="subtype" size="1">';

                    foreach($currentType->subTypes as $subType)
                        echo '<option value="'.$subType->id.'" '.($subType->id==0 ? "selected" : "").'>'
                                .$subType->name
                             .'</option>';

                echo '</select>';
            }

            echo '<p>Имя блока <input type="text" name="name" value="'.$name.'"></p>';
            echo '<p>Цвет фона <input type="text" name="bgcolor" value='.($bgcolor ? $bgcolor : "#ffffff").'></p>';
            echo '<p>Цвет текста <input type="text" name="txtcolor" value='.($txtcolor ? $txtcolor : "#000000").'></p>';

            echo '<p>Категории (отделяйте точкой с запятой) <br /> <input type="text" name="categories" value="'.$categories.'"></p>';

            echo '<input type="hidden" name="type" value="'.$currentType->id.'">';
            echo '<input type="hidden" name="action" value="addBlock">';
            echo '<input type="submit" value="Добавить">';

            echo '</form>';
        }
    ?>
</div>

<?php include('parts/footer.php'); ?>