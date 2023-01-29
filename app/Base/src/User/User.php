<?php

namespace BFST\Base\User;

final class User
{
    public int $id;
    public string $email;
    public string $password;
    protected string $table = 'users';
}