<?php

namespace App\Migration;

use Tempest\Database\MigratesUp;
use Tempest\Database\QueryStatement;
use Tempest\Database\QueryStatements\CreateTableStatement;
use Tempest\DateTime\DateTime;

class CreateUsersTable implements MigratesUp
{
    public string $name = '2026-1-24_create_users_table';

    public function up(): QueryStatement
    {
        return new CreateTableStatement('users')
            ->primary()
            ->string('username')
            ->string('password')
            ->datetime('registered_at', default: DateTime::now())
        ;
    }
}
