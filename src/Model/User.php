<?php

namespace App\Model;

use Tempest\Auth\Authentication\Authenticatable;
use Tempest\Database\Hashed;
use Tempest\Database\PrimaryKey;

final class User implements Authenticatable
{
    public PrimaryKey $id;

    public function __construct(
        public string $username,
        #[Hashed]
        #[\SensitiveParameter]
        public string $password,
    ) {}
}
