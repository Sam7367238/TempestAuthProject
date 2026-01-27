<?php

namespace App\Observer;

use App\Event\UserRegistered;
use Tempest\EventBus\EventHandler;

/**
 * An observer for the UserRegistered event.
 */
final class UserRegisteredObserver
{
    #[EventHandler]
    public function onUserRegistered(UserRegistered $event): void
    {
        // ll("A user with the name of {$event -> username} has registered.");
    }
}
