<?php

namespace App\Controller;

use App\Middleware\Authenticated;
use App\Middleware\Guest;
use App\Repository\UserRepository;
use App\Request\AuthenticationRequest;
use Tempest\Auth\Authentication\Authenticator;
use Tempest\Cryptography\Password\PasswordHasher;
use Tempest\Http\Response;
use Tempest\Http\Responses\Redirect;
use Tempest\Intl\Translator;
use Tempest\Router\Get;
use Tempest\Router\Post;
use Tempest\View\View;

use function Tempest\root_path;
use function Tempest\view;

final readonly class SessionController
{
    public function __construct(
        private PasswordHasher $passwordHasher,
        private Authenticator $authenticator,
        private UserRepository $userRepository,
        private Translator $translator
    ) {}

    #[Get('/login', middleware: [Guest::class])]
    public function loginForm(): View
    {
        return view(root_path('templates/login.view.php'));
    }

    #[Post('/login', middleware: [Guest::class])]
    public function processLoginForm(AuthenticationRequest $request): Response
    {
        $user = $this->userRepository->findByUsername($request->username);

        if (!$user || $this->passwordHasher->verify($request->password, $user->password)) {
            return new Redirect('/login')->flash('status', $this->translator->translate('flash.invalid_credentials'));
        }

        $this->authenticator->authenticate($user);

        return new Redirect('/')->flash('status', $this->translator->translate('flash.login_successful'));
    }

    #[Post('/logout', middleware: [Authenticated::class])]
    public function logout(): Redirect
    {
        $this->authenticator->deauthenticate();

        return new Redirect('/login')->flash('status', $this->translator->translate('flash.logout_successful'));
    }
}
