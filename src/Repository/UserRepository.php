<?php

namespace App\Repository;

use App\Model\User;

use function Tempest\Database\query;

final class UserRepository
{
    public function findByUsername(string $username): array|object|null
    {
        return query(User::class)
            ->select()
            ->where('username', $username)
            ->first()
        ;
    }
}
