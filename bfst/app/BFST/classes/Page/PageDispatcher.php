<?php

namespace BFST\Page;

use BFST\Cache\Cache;
use BFST\Database\MySQL;
use Exception;
use RedisException;

class PageDispatcher
{
    /**
     * @param int $pageID
     * @return array
     * @throws RedisException
     * @throws Exception
     */
    public function loadPage(int $pageID): array
    {
        $result = Cache::cache()->get(__METHOD__ . '::' . $pageID);
        $result = false;

        if ($result === false) {
            $result = $this->loadPageGo($pageID);
            Cache::cache()->set(__METHOD__ . '::' . $pageID, $result);
        }

        return $result;
    }

    /**
     * @param int $pageID
     * @return array
     * @throws Exception
     */
    private function loadPageGo(int $pageID): array
    {
        try {
            $page = $this->fetchPage($pageID);
            $page->isFileExists();
            $page->isActive();
            //$page->hasUserAccess();
            $result = [
                "content" => $page->render(),
                "title" => $page->title
            ];

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $result;
    }

    /**
     * @param int $pageID
     * @return Page
     * @throws Exception
     */
    private function fetchPage(int $pageID): Page
    {
        $row = MySQL::i()->select("
            SELECT id, filename, title, active
            FROM modules
            WHERE id = $pageID
        ");

        if (empty($row)) {
            throw new Exception("Moduł nie został znaleziony.");
        }

        return new Page(
            $row[0]->id,
            $row[0]->filename,
            $row[0]->title,
            $row[0]->active
        );
    }
}