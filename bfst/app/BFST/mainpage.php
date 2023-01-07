<?php

use Volcano\Database\MySQL;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <link rel="stylesheet" href="<?= assets("css/reset.css"); ?>"/>
    <link rel="stylesheet" href="<?= assets("css/style.css"); ?>"/>

    <script src="<?= assets("js/libraries/hashdom.js"); ?>"></script>
    <script src="<?= assets("js/libraries/ajax.js"); ?>"></script>
    <script type="module" src="<?= assets("js/app.js"); ?>"></script>

    <title>Strona główna | Blazing Sales Tools</title>
</head>
<body>

<div id="sidebar">
    <?php
    try {
        $sql = MySQL::i();
        $rows = $sql->select("SELECT bm.module_id, mc.name, mo.title FROM bfst_menu bm
                LEFT JOIN menu_category mc ON bm.category_id = mc.id
                LEFT JOIN modules mo ON mo.id = bm.module_id
                ORDER BY mc.id ASC, bm.position DESC
            ");

        $positions = [];
        foreach ($rows as $row) {
            $positions[$row->name][$row->module_id] = $row;
        }

        foreach ($positions as $category => $modules) {
            echo "<div>{$category}</div>";
            echo "<ul>";

            foreach ($modules as $moduleID => $module) {
                echo "<li><a href='?page=$moduleID' class='navigation'>$module->title</a></li>";
            }

            echo "</ul>";
        }
    } catch (Exception $e) {
    }
    ?>
</div>
<div id="pageContainer">
    <div id="loader"></div>
    <div id="pageContent"></div>
</div>

</body>
</html>
