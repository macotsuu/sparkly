<?php

namespace BFST\User;

use BFST\User\Permissions\Permission;
use Exception;

class Authorization
{
    public const OK = 1;
    public const FAIL = 2;

    /**
     * @param string $email
     * @param string $password
     * @return array
     */
    public function authorize(string $email, string $password): array
    {
        try {
            $user = UserFactory::make($email);
            $user->isPasswordMatch($password);

            $_SESSION['user']['id'] = $user->id;
            $_SESSION['user']['email'] = $user->email;

            return [
                'status' => self::OK
            ];
        } catch (Exception $exception) {
            return [
                'status' => self::FAIL,
                'message' => $exception->getMessage()
            ];
        }
    }
}
