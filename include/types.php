<?php

// Структуры типов и подтипов. Задание самих типов ниже.

    class subtype{
        var $id, $name,
            $rows, $columns;

        function __construct($id, $name,
                             $rows, $columns)
        {
            $this->id=$id; $this->name=$name;
            $this->rows=$rows; $this->columns=$columns;
        }
    }

    class type{
        var $id, $name,
            $hasCaption, $hasText, $hasImage,
            $captionLength, $textLength,
            $subTypes; // массив подтипов

        function __construct($id, $name,
                             $hasCaption, $hasText, $hasImage,
                             $captionLength, $textLength,
                             $subTypes)
        {
            $this->id=$id; $this->name=$name;
            $this->hasCaption=$hasCaption; $this->hasText=$hasText; $this->hasImage=$hasImage;
            $this->captionLength=$captionLength; $this->textLength=$textLength;
            $this->subTypes=$subTypes;
        }
    }



//--------- Типы объявлений -----------
    $types=array(
        0 => new type(0, 'Текстовая строка', false, true, false, 0, 130, null),
        1 => new type(1, 'Текстовый блок', true, true, false, 45, 150, null),
        2 => new type(2, 'Блок с изображениями', true, false, true, 30, 0,
                        array( //Подтипы
                            new subtype(0, '1x1', 1, 1),
                            new subtype(1, '1x4', 1, 4),
                            new subtype(2, '3x1', 3, 1)
                        ))
    );

    $typesCnt=count($types);