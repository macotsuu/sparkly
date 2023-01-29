<?php

namespace BFST\Base\Authorization;

use BFST\Base\Authorization\Exception\AuthorizationException;
use BFST\Base\User\User;
use User\UserFactory;
use Volcano\ORM\ORM;

class Authorization
{
    /**
     * @param string $email
     * @param string $password
     * @return array<string>
     */
    public function authorize(string $email, string $password): array
    {
        try {
            $user = app()->make(ORM::class)
                ->getRepository(User::class)
                ->find(['where' => ['email' => $email]]);

            if ($user) {
                if (!password_verify($password, $user[0]->password)) {
                    throw new AuthorizationException("Password not match");
                }

                $_SESSION['user']['uid'] = $user[0]->id;
                $_SESSION['user']['email'] = $user[0]->email;

                return ['status' => 'ok'];
            }
        } catch (AuthorizationException $exc) {
            return [
                'status' => 'error',
                'message' => $exc->getMessage()
            ];
        }
    }
}
