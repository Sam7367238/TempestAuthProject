<?php

namespace App\Command;

use App\Event\UserRegistered;
use App\Model\User;
use Tempest\Console\ConsoleCommand;
use Tempest\Console\ExitCode;
use Tempest\Console\HasConsole;
use Tempest\Cryptography\Password\PasswordHasher;
use Tempest\EventBus\EventBus;

use function Tempest\Database\query;

final readonly class CreateUserCommand
{
    use HasConsole;

    public function __construct(
        private PasswordHasher $passwordHasher,
        private EventBus $eventBus
    ) {}

    #[ConsoleCommand('make:user', description: 'Creates a user.')]
    public function __invoke(string $username, string $password): ExitCode
    {
        $this->passwordHasher->hash($password);

        query(User::class)->insert(username: $username, password: $password)->execute();

        $this->eventBus->dispatch(new UserRegistered(username: $username));

        $this->console->info('User has been created!');

        return ExitCode::SUCCESS;
    }
}
