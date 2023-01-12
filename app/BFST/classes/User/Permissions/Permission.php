<?php

namespace User\Permissions;

use Volcano\Foundation\MySQL;

class Permission
{
    public function loadPermissionsForUser(int $userID): array
    {
        $permissions = [];
        $rows = MySQL::i()->select(
            "SELECT module_id FROM user_permission WHERE user_id = ?",
            [$userID]
        );

        while ($rows->valid()) {
            $permissions[] = $rows->current()->module_id;
            $rows->next();
        }

        return $permissions;
    }
}
