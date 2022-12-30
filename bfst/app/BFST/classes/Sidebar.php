<?php

namespace BFST;

use BFST\Database\MySQL;

class Sidebar
{
    private array $positions = [];

    public function __construct()
    {
        $this->loadMenuPositions();
    }

    private function loadMenuPositions(): void
    {
        $rows = MySQL::i()->select("
            SELECT me.module_id, mc.name, mo.title FROM menu me
            LEFT JOIN menu_category mc ON me.category_id = mc.id
            LEFT JOIN modules mo ON mo.id = me.module_id
            ORDER BY mc.id ASC, me.position DESC
        ");

        foreach ($rows as $row) {
            $this->positions[$row->name][$row->module_id] = $row;
        }
    }

    public function render(): string
    {
        $html = "";

        foreach ($this->positions as $category => $entries) {
            $html .= "<div>{$category}</div>";
            $html .= "<ul>";
            foreach ($entries as $moduleID => $entry) {
                $html .= "
                    <li>
                        <a href='?page={$moduleID}' class='navigation'>{$entry->title}</a>
                    </li>
                ";
            }
            $html .= "</ul>";
        }

        return $html;
    }
}