<?php

namespace BFST\Base\Authorization\Permission;

use Volcano\ORM\MySQL;

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
