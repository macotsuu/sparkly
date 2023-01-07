<?php

use PHPUnit\Framework\TestCase;
use Volcano\Module\Module;

class ModuleTest extends TestCase
    {
        public function testModuleInstance(): Module {
            $module = new Module(
                9999,
                "phpunit.php",
                "PHP Unit",
                true
            );

            $this->assertInstanceOf(Module::class, $module);

            return $module;
        }

        /**
         * @covers Module::isActive
         * @depends testModuleInstance
         */
        public function testIsActiveModule(Module $module): void
        {
            $this->assertTrue($module->isActive(), "Zwraca wartość powinna być prawdą.");
        }

        /**
         * @covers Module::addStyle
         * @depends testModuleInstance
         */
        public function testAddStyle(Module $module): void
        {
            $module->addStyle("css/style.css");

            $this->assertNotEmpty($module->styles);
            $this->assertContains("css/style.css", $module->styles);
        }

    }