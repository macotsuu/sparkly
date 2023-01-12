<?php

namespace User;

use User\Authorization\AuthorizationException;

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
     * @throws AuthorizationException
     */
    public function isPasswordMatch(string $password): bool
    {
        if ($this->password !== null) {
            if (!password_verify(trim($password), $this->password)) {
                throw new AuthorizationException("Hasło nie prawidłowe.");
            }

            return true;
        }

        return false;
    }

    /**
     * @return void
     */
    public function setSessionData(): void
    {
        $_SESSION['user']['id'] = $this->id;
        $_SESSION['user']['email'] = $this->email;
    }
}
