<?php

namespace Volcano\Module;

use Exception;
use RedisException;

class ModuleDispatcher
{
    private bool $useCache = false;

    /**
     * @param int $moduleID
     * @param bool $useCache
     * @return array
     * @throws RedisException
     * @throws Exception
     */
    public function loadModule(int $moduleID, bool $useCache = false): array
    {
        $this->setUseCache($useCache);

        $result = $this->getFromCache($moduleID);
        if ($result === false) {
            try {
                $module = ModuleFactory::create($moduleID);
                if ($module === null) {
                    throw new ModuleException("Taki moduł nie istnieje!");
                }

                $result = $module->render();
                $this->saveIntoCache($moduleID, $result);
            } catch (ModuleException $exception) {
                return [
                    "content" => sprintf(
                        "[?page=%d] %s",
                        $moduleID,
                        $exception->getMessage()
                    )
                ];
            }
        }

        return $result;
    }

    /**
     * @param bool $useCache
     * @return $this
     */
    public function setUseCache(bool $useCache): self
    {
        $this->useCache = $useCache;
        return $this;
    }

    /**
     * @param int $moduleID
     * @return mixed
     * @throws RedisException
     */
    private function getFromCache(int $moduleID): mixed
    {
        return cache()->get("?page=$moduleID");
    }

    /**
     * Zapis wyniku do pamięci Cache
     *
     * @param int $moduleID
     * @param array $result
     * @return void
     * @throws RedisException
     */
    private function saveIntoCache(int $moduleID, array $result): void
    {
        if ($this->useCache) {
            cache()->set("?page=$moduleID", $result);
        }
    }
}
