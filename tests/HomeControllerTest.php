<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\Test;

/**
 * @internal
 *
 * @coversNothing
 */
final class HomeControllerTest extends IntegrationTestCase
{
    #[Test]
    public function indexIsReachable(): void
    {
        $this->http
            ->get('/')
            ->assertOk()
            ->assertSee('Tempest')
        ;
    }
}
