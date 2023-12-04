<!DOCTYPE html>
<html lang="ru">
<?php
// Функция для просмотра содержимого массива с сохранением отступов для вложенности (необходима для отладки)
function Dumper($arA) {
    echo "<pre>";
    print_r($arA);
    echo "</pre>";
}

// Функция, конвертирующая массив с исходными данными о папках и файлах в массив, используемый для отрисовки дерева,
// и вычисляющая значение корневой папки
function ConvertArray($arD, $arNewD = [], $currentFolder = "") {
    foreach ($arD as $key => $value) {
        if ($value["parent"] == ".") {
            $currentFolder = $key;
        } else {
            $arNewD[$value["parent"]][$key] = $value["type"];
        }
    }
    return [$currentFolder, $arNewD];
}

// Массив с исходными данными о папках и файлах
$arData = [
    "7" => ["type" => "file", "parent" => "d6"],
    "d5" => ["type" => "folder", "parent" => "d1"],
    "3" => ["type" => "file", "parent" => "d2"],
    "d3" => ["type" => "folder", "parent" => "d1"],
    "4" => ["type" => "file", "parent" => "d3"],
    "d4" => ["type" => "folder", "parent" => "d2"],
    "d1" => ["type" => "folder", "parent" => "."],
    "1" => ["type" => "file", "parent" => "d1"],
    "2" => ["type" => "file", "parent" => "d1"],
    "d2" => ["type" => "folder", "parent" => "d1"],
    "5" => ["type" => "file", "parent" => "d4"],
    "6" => ["type" => "file", "parent" => "d4"],
    "d6" => ["type" => "folder", "parent" => "d5"],
];

$arNewData = ConvertArray($arData);
$currentFolder = $arNewData[0];
$arParents = $arNewData[1];

function FileTree($absPosition) {
    global $arParents;
    global $currentFolder;

    // сортировка по ключам в алфавитном порядке
    ksort($arParents[$currentFolder]);
    // пользовательская сортировка по значениям - сначала файлы, потом папки
    uasort($arParents[$currentFolder], function($x, $y) {
        if ($x == "file" && $y == "folder") {
            return -1;
        } elseif ($x == "folder" && $y == "file") {
            return 1;
        }
        return 0;
    });

    foreach($arParents[$currentFolder] as $key => $value) {
        echo "
            <div>
                <img style=\"margin-left: calc($absPosition * 50px)\" src=\"$value.png\" />
                $key
            </div>
        ";
        if ($value == "folder") {
            $currentFolder = $key;
            FileTree($absPosition + 1);    
        } else {
            continue;
        }
    }
}
?>
<head>
    <meta charset="UTF-8" />
    <title>Дерево файлов</title>
    <style>
        div {
            display: flex;
            align-items: center;
            font-size: 14px;
        }
        img {
            margin: 5px;
            width: 40px;
        }
    </style>
</head>

<body>
<?php
echo "
    <div>
        <img src=\"folder.png\" />
        $currentFolder
    </div>
";
$absPosition = 1;
FileTree($absPosition);
?>
</body>

</html>