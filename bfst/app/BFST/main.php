<?php

use BFST\Sidebar;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= assets("css/style.css"); ?>"/>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script defer src="<?= assets("js/app.js"); ?>"></script>
    <script defer src="<?= assets("js/ajax.js"); ?>"></script>

    <title>Blazing Sales Tools</title>
</head>
<body>

<div id="sidebar"><?= (new Sidebar())->render(); ?></div>

<div id="pageContainer">
    <div id="bstAjaxLoader"><img src="public/img/loader.gif"/></div>
    <div id="pageContent"></div>
</div>
</body>
</html>