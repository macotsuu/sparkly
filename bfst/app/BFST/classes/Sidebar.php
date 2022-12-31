<?php

namespace BFST;

use BFST\Database\MySQL;
use Exception;

class Sidebar
{
    private array $positions = [];

    public function __construct()
    {
        $this->loadMenuPositions();
    }

    /**
     * @throws Exception
     */
    private function loadMenuPositions(): void
    {
        $rows = MySQL::i()->select("
            SELECT bm.module_id, mc.name, mo.title FROM bfst_menu bm
            LEFT JOIN menu_category mc ON bm.category_id = mc.id
            LEFT JOIN modules mo ON mo.id = bm.module_id
            ORDER BY mc.id ASC, bm.position DESC
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