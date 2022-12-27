<?php

namespace BFST\User;

use Exception;

class User
{
    public function __construct(
        public ?int              $id = null,
        public ?string           $email = null,
        private readonly ?string $password = null
    )
    {
    }

    /**
     * @param string $password
     * @return bool
     * @throws Exception
     */
    public function isPasswordMatch(string $password): bool
    {
        if (!password_verify(trim($password), $this->password)) {
            throw new Exception("Hasło nie prawidłowe.");
        }

        return true;
    }
}
