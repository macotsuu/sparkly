<?php

namespace BFST\Module;
class Module
{
    public array $scripts = [];
    public array $styles = [];
    public string $fullPath;

    public function __construct(
        public int    $moduleID,
        public string $filename,
        public string $title,
        public bool   $active
    )
    {
        $this->fullPath = BFST_DIR_MODULES . $this->filename;
    }

    /** Sprawdza, czy plik modułu istnieje
     *
     * @return bool
     */
    public function isFileExists(): bool
    {
        return file_exists($this->fullPath);
    }

    /** Sprawdza, czy podany moduł jest aktywny.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /** Sprawdza, czy użytkownik ma dostęp do modułu
     *
     * @return bool
     */
    public function isUserHasAccess(): bool
    {
        return in_array($this->moduleID, $_SESSION['user']['permissions']);
    }

    /** Dołączanie pliku CSS modułu
     *
     * @param string $url
     * @return $this
     */
    public function addStyle(string $url): self
    {
        $this->styles[] = $url;
        return $this;
    }

    /** Dołączanie pliku JS modułu
     *
     * @param string $url
     * @return $this
     */
    public function addScripts(string $url): self
    {
        $this->scripts[] = $url;
        return $this;
    }

    /** Ładowanie modułu w skompresowanej postaci
     *
     * @return string
     */
    public function loadModuleTemplate(): string
    {
        ob_start('ob_gzhandler');
        extract(['module' => $this]);
        require_once $this->fullPath;
        return ob_get_clean();
    }

    /**
     * @return array {
     *  'title': string,
     *  'content': string,
     *  'assets': {
     *      'scripts': [],
     *      'styles': []
     *  }
     * }
     */
    public function render(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->loadModuleTemplate(),
            'assets' => [
                'scripts' => array_unique($this->scripts),
                'styles' => array_unique($this->styles)
            ]
        ];
    }
}
