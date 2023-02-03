<?php

namespace src\UserDomain;

final class User
{
    public int $id;
    public string $email;
    public string $password;
    protected string $table = 'users';
    protected string $primaryKey = 'id';
}