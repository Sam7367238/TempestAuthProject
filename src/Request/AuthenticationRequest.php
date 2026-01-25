<?php

namespace App\Request;

use Tempest\Http\IsRequest;
use Tempest\Http\Request;
use Tempest\Http\SensitiveField;
use Tempest\Validation\Rules;

final class AuthenticationRequest implements Request
{
    use IsRequest;

    #[Rules\HasLength(min: 3, max: 20)]
    public string $username;

    #[SensitiveField]
    #[Rules\HasLength(min: 8, max: 255)]
    public string $password;
}
