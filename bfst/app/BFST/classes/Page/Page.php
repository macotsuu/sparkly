<?php

namespace BFST\Page;

use Exception;

class  Page
{
    public string $fullPath;

    public function __construct(
        public int    $pageID,
        public string $filename,
        public string $title,
        public bool   $active
    )
    {
        $this->fullPath = BFST_DIR_MODULES . $this->filename;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isFileExists(): bool
    {
        if (!file_exists($this->fullPath)) {
            throw new Exception("Plik modułu nie został znaleziony.");
        }

        return true;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        ob_start('ob_gzhandler');
        require_once $this->fullPath;
        return ob_get_clean();
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isActive(): bool
    {
        if ($this->active === false) {
            throw new Exception("Moduł jest nie aktywny.");
        }

        return $this->active;
    }

    /**
     *
     * @return bool
     * @throws Exception
     */
    public function hasUserAccess(): bool
    {
        if (!in_array($this->pageID, $_SESSION['user']['permissions'])) {
            throw new Exception("Brak uprawnień do modułu.");
        }

        return true;
    }
}
