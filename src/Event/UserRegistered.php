<?php

namespace App\Event;

/**
 * UserRegistration Event
 * @param string $username
 */
final readonly class UserRegistered
{
    public function __construct(public string $username) {}
}
