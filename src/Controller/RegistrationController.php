<?php

namespace App\Controller;

use App\Event\UserRegistered;
use App\Middleware\Guest;
use App\Model\User;
use App\Repository\UserRepository;
use App\Request\AuthenticationRequest;
use Tempest\Auth\Authentication\Authenticator;
use Tempest\Cryptography\Password\PasswordHasher;
use Tempest\EventBus\EventBus;
use Tempest\Http\Response;
use Tempest\Http\Responses\Redirect;
use Tempest\Intl\Translator;
use Tempest\Router\Get;
use Tempest\Router\Post;
use Tempest\View\View;

use function Tempest\Database\query;
use function Tempest\root_path;
use function Tempest\view;

final readonly class RegistrationController
{
    public function __construct(
        private PasswordHasher $passwordHasher,
        private Authenticator $authenticator,
        private UserRepository $userRepository,
        private EventBus $eventBus,
        private Translator $translator
    ) {}

    #[Get('/register', middleware: [Guest::class])]
    public function registerForm(): View
    {
        return view(root_path('templates/register.view.php'));
    }

    #[Post('/register', middleware: [Guest::class])]
    public function processRegisterForm(AuthenticationRequest $request): Response
    {
        $user = $this->userRepository->findByUsername($request->username);

        if ($user) {
            return new Redirect('/register')->flash('status', $this->translator->translate('flash.username_taken'));
        }

        $password = $this->passwordHasher->hash($request->password);

        query(User::class)->insert(
            username: $request->username,
            password: $password
        )->execute();

        $this->eventBus->dispatch(new UserRegistered(username: $request->username));

        $authenticatedUser = $this->userRepository->findByUsername($request->username);

        $this->authenticator->authenticate($authenticatedUser);

        return new Redirect('/')->flash('status', $this->translator->translate('flash.register_success'));
    }
}
