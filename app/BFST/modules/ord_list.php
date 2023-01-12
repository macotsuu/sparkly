<?php

/**
 * @var Module $module
 */

use Volcano\Module\Module;

$module->addScripts(assets("js/modules/ord_list.js"));
$module->addStyle(assets("css/orders.css"));
?>

<div class="searchbar">
    <div class="searchbox">
        <label for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
        <input type="text" id="search" placeholder="Wyszukaj przez # zamówienia"/>
    </div>
</div>

<table class="table" style="min-width: 900px">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Data</th>
        <th scope="col">Status</th>
        <th scope="col">Klient</th>
        <th scope="col">Kwota</th>
    </tr>
    </thead>
    <tbody id="orders"></tbody>
</table>
