<?php

namespace BFST\User;

use BFST\Database\MySQL;
use Exception;

class UserFactory
{
    /**
     * @param string $email
     * @return User
     * @throws Exception
     */
    public static function make(string $email): User
    {
        $user = MySQL::i()->select("SELECT id, email, password FROM users WHERE email = '" . addslashes($email) . "' LIMIT 1");

        if (!$user) {
            throw new Exception("Użytkownik nie został znaleziony.");
        }

        return new User(
            $user[0]->id,
            $user[0]->email,
            $user[0]->password
        );
    }
}