<?php

namespace Volcano\Foundation;

use Exception;
use ReflectionClass;
use ReflectionException;

class View
{
    /** @var string $template */
    private string $template;
    /** @var string $passable */
    private string $passable;
    /** @var array $attributes */
    private array $attributes = [];

    /**
     * @return string
     * @throws Exception
     */
    public function render(): string
    {
        if (!file_exists($this->fullPath())) {
            throw new Exception("{$this->template} not found.");
        }

        ob_start();
        extract($this->attributes);
        require_once __DIR__ . '/Template/header.php';
        require $this->fullPath();
        require_once __DIR__ . '/Template/footer.php';
        return ob_get_clean();
    }

    /**
     * @param string $template
     * @return $this
     */
    public function view(string $template): self
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function attributes(array $attributes): self
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param string $passable
     * @return $this
     */
    public function passable(string $passable): self
    {
        $this->passable = $passable;
        return $this;
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    private function fullPath(): string
    {
        return dirname(
                (new ReflectionClass($this->passable))->getFileName(),
                4
            ) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->template;
    }


}