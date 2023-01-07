<?php

namespace User\Authorization;

use User\UserFactory;

class Authorization
{
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
            $user->setSessionData();

            $result = ['status' => 'ok'];
        } catch (AuthorizationException $exc) {
            $result = [
                'status' => 'error',
                'message' => $exc->getMessage()
            ];
        }

        return $result;
    }
}
