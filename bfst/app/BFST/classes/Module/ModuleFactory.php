<?php

namespace BFST\Module;

use BFST\Database\MySQL;
use Exception;

class ModuleFactory
{
    /**
     * @param int $moduleID
     * @return Module|null
     * @throws Exception
     * @throws ModuleException
     */
    public static function create(int $moduleID): ?Module
    {
        $row = MySQL::i()->first("SELECT id, filename, title, active FROM modules WHERE id = $moduleID");

        if ($row !== false) {
            $module = new Module(
                $row->id,
                $row->filename,
                $row->title,
                $row->active
            );

            if (!$module->isActive()) {
                throw new ModuleException("Moduł jest nieaktywny.");
            }

            if (!$module->isFileExists()) {
                throw new ModuleException("Plik modułu nie został znaleziony.");
            }

            return $module;
        }

        return null;
    }
}