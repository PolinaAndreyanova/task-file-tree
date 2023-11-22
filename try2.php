<?php
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

// $arData = array(["type" => "folder", "name" => "d", "objects" => array(
//     ["type" => "file", "name" => "f_1"], 
//     ["type" => "file", "name" => "f_2"], 
//     ["type" => "folder", "name" => "d_1", "objects" => array(
//         ["type" => "file", "name" => "f_3"],
//         ["type" => "file", "name" => "f_4"]
//     )]
// )]);

$arData = array(["type" => "folder", "name" => "d", "objects" => array(
    ["type" => "file", "name" => "f_1"], 
    ["type" => "file", "name" => "f_2"], 
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

// echo "<pre>";
// echo "New";
// print_r($arM);
// echo "</pre>";

// $arM = array(
//     array(["type" => "folder", "name" => "d"], ["type" => "file", "name" => "f_1"]), 
//     array(1 => ["type" => "file", "name" => "f_2"]),
//     array(1 => ["type" => "folder", "name" => "d_1"], ["type" => "file", "name" => "f_3"]), 
//     array(2 => ["type" => "file", "name" => "f_4"])
// );
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <title>Дерево файлов</title>
    <style>
        table {
            border: 1px solid black;
            border-spacing: 5px;
            /* border-collapse: collapse; */
            /* width: 100px; */
            box-sizing: content-box;
        }
        thead {
            /* width: 100px; */
        }
        tbody {
            /* height: 100px;
            width: 100px; */
        }
        th, td {
            padding: 0;
            height: 20px;
            width: 20px;
            /* border: 1px solid black; */
            font-size: 5px;
            
        }
        div {
            display: flex;
            align-items: center;
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
            <?php for ($i = 0; $i < $rowCount; $i++) {?>
                <tr>
                    <?php for ($j = 0; $j < $columnCount; $j++) {
                        if ($arM[$i][$j]["type"] == "folder") {?>
                            <td>
                                <div>
                                    <img src="./folder.png" alt="folder" width="10"/>
                                    <?=$arM[$i][$j]["name"]?>
                                    <img src="./arrow.png" alt="arrow" width="10"/>
                                </div>
                            </td>
                        <?php } else if ($arM[$i][$j]["type"] == "file") {?>
                            <td><img src="./file.png" alt="file" width="10"/><?=$arM[$i][$j]["name"]?></td>
                        <?php } else {?>
                            <td></td>
                        <?php }?>
                    <?php }?>
                </tr>
            <?php }?>
        </tbody>
        
    </table>
</body>
</html>