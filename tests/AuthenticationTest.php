<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\PreCondition;
use PHPUnit\Framework\Attributes\Test;
use Tempest\Http\Status;

final class AuthenticationTest extends IntegrationTestCase
{
    private const string DUMMY_USERNAME = "Dummy";
    private const string DUMMY_PASSWORD = "DummyPassword";

    #[PreCondition]
    protected function configure(): void
    {
        $this->database->setup();
    }

    /**
     * 
     */
    #[Test]
    public function test_registration_is_successful_and_in_the_database(): void
    {
        $this->http->post('/register', [
            'username' => self::DUMMY_USERNAME,
            'password' => self::DUMMY_PASSWORD,
        ])->assertStatus(Status::FOUND);

        $this->database->assertTableHasRow('users', username: self::DUMMY_USERNAME);
    }
}
