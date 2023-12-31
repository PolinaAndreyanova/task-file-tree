<!DOCTYPE html>
<html lang="ru">
<?php
// Функция, вычисляющая общее количество папок и файлов
function CountFoldersAndFiles($arA) {
    $c = count($arA);
    foreach ($arA as $k => $v) {
        if ($v["type"] == "folder") {
            return ($c + CountFoldersAndFiles($v["objects"]));
        } else {
            continue;
        }
    }
    return $c;
}

// Функция, вычисляющая количество папок
function CountFolders($arA) {
    $c = 0;
    foreach ($arA as $k => $v) {
        if ($v["type"] == "folder") {
            $c += 1;
            return ($c + CountFolders($v["objects"]));
        } else {
            continue;
        }
    }
    return $c;
}

// Функция, конвертирующая массив с исходными данными о папках и файлах в массив, используемый для отрисовки дерева
function ConvertArray($arD, $arM = [], $absPos = 0) {
    foreach ($arD as $k => $v) {
        if ($k == 0 && $arM[count($arM) - 1]) {
            $arM[count($arM) - 1] += [($absPos + 1) => ["type" => $v["type"], "name" => $v["name"]]];
            $absPos += 1;
            continue;
        } else if ($v["type"] == "folder") {
            $arM[] = [($absPos) => ["type" => $v["type"], "name" => $v["name"]]];
            return ConvertArray($v["objects"], $arM, $absPos);
        } else {
            $arM[] = [($absPos) => ["type" => $v["type"], "name" => $v["name"]]];
            continue;
        }
    }
    return $arM;
}

// Массив с исходными данными о папках и файлах
$arData = array(
    ["type" => "folder", "name" => "d", "objects" => array(
        ["type" => "folder", "name" => "d_1", "objects" => array(
            ["type" => "file", "name" => "f_3"],
            ["type" => "folder", "name" => "d_2", "objects" => array(
                ["type" => "file", "name" => "f_4"], 
                ["type" => "file", "name" => "f_5"],
                ["type" => "folder", "name" => "d_3", "objects" => array(
                    ["type" => "file", "name" => "f_6"],
                    ["type" => "file", "name" => "f_7"]
                )]
            )]  
        )]
)]);

$folderCount = CountFolders($arData);
$rowCount = CountFoldersAndFiles($arData) - $folderCount;
$columnCount = $folderCount + 1;
$arM = ConvertArray($arData);
echo "<pre>";
print_r($arM);
echo "</pre>";
?>
<head>
    <meta charset="UTF-8" />
    <title>Дерево файлов</title>
    <style>
        table {
            border: 1px solid black;
            border-spacing: 5px;
            box-sizing: content-box;
        }
        th, td {
            padding: 0;
            height: 20px;
            width: 20px;
            font-size: 5px;
            
        }
        div {
            display: flex;
            align-items: center;
        }
        img {
            width: 10px;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th colspan="<?=$columnCount?>">File tree</th>
            </tr>
        </thead>
        <tbody>
<?php 
for ($i = 0; $i < $rowCount; $i++) {
?>
            <tr>
<?php 
for ($j = 0; $j < $columnCount; $j++) {
    if ($arM[$i][$j]["type"] == "folder") {
?>
                <td>
                    <div>
                        <img src="./folder.png" alt="folder" />
<?php 
$arM[$i][$j]["name"]
?>
                        <img src="./arrow.png" alt="arrow" />
                    </div>
                </td>
<?php 
} else if ($arM[$i][$j]["type"] == "file") {
?>
                <td>
                    <img src="./file.png" alt="file" />
<?php 
$arM[$i][$j]["name"]
?>
                </td>
<?php
} else {
?>
                <td></td>
<?php
    }
}
?>
            </tr>
<?php
}
?>
        </tbody>      
    </table>
</body>

</html>