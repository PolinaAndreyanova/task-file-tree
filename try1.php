<?php
$arData = array(
    ["type" => "file", "name" => "f_1"], 
    ["type" => "file", "name" => "f_2"], 
    ["type" => "folder", "name" => "d_1", "objects" => array(
        ["type" => "file", "name" => "f_3"],
        ["type" => "file", "name" => "f_4"]
    )]
);
$columnCount = 3;
$rowCount = 4;
$arM = array(
    array(["type" => "folder", "name" => "d"], ["type" => "file", "name" => "f_1"]), 
    array(1 => ["type" => "file", "name" => "f_2"]),
    array(1 => ["type" => "folder", "name" => "d_1"], ["type" => "file", "name" => "f_3"]), 
    array(2 => ["type" => "file", "name" => "f_4"])
);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <title>Дерево файлов</title>
    <style>
        table {
            border: 1px solid black;
            border-spacing: 0px;
            border-collapse: collapse;
            /* width: 100px; */
            box-sizing: content-box;
        }
        /* thead {
            width: 100px;
        }
        tbody {
            height: 100px;
            width: 100px;
        } */
        th, td {
            padding: 0;
            height: 10px;
            width: 10px;
            border: 1px solid black;
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
                            <td><img src="./folder.png" alt="folder" width="10"/></td>
                        <?php } else if ($arM[$i][$j]["type"] == "file") {?>
                            <td><img src="./file.png" alt="file" width="10"/></td>
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