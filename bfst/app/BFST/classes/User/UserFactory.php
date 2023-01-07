<?php

namespace User;

use User\Authorization\AuthorizationException;
use Volcano\Database\MySQL;

class UserFactory
{
    /**
     * @param string $email
     * @return User
     * @throws AuthorizationException
     */
    public static function make(string $email): User
    {
        $sql = MySQL::i();
        $user = $sql->select(
            "SELECT id, email, password FROM users WHERE email = '" . addslashes($email) . "' LIMIT 1"
        );

        if (!$user) {
            throw new AuthorizationException("Użytkownik nie został znaleziony.");
        }

        return new User(
            $user[0]->id,
            $user[0]->email,
            $user[0]->password
        );
    }
}
