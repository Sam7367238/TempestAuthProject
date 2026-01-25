<?php

namespace App\Controller;

use App\Middleware\Authenticated;
use App\Middleware\Guest;
use App\Model\User;
use App\Repository\UserRepository;
use App\Request\AuthenticationRequest;
use Tempest\Auth\Authentication\Authenticator;
use Tempest\Cryptography\Password\PasswordHasher;
use Tempest\Http\Response;
use Tempest\Http\Responses\Redirect;
use Tempest\Router\Get;
use Tempest\Router\Post;
use Tempest\View\View;

use function Tempest\Database\query;
use function Tempest\root_path;
use function Tempest\view;

final readonly class SessionController
{
    public function __construct(
        private PasswordHasher $passwordHasher,
        private Authenticator $authenticator,
        private UserRepository $userRepository,
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
            return new Redirect('/register')->flash('status', 'This Username Is Taken');
        }

        query(User::class)->insert(
            username: $request->username,
            password: $request->password,
        )->execute();

        $authenticatedUser = $this->userRepository->findByUsername($request->username);

        $this->authenticator->authenticate($authenticatedUser);

        return new Redirect('/')->flash('status', 'Signed In Successfully');
    }

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
            return new Redirect('/login')->flash('status', 'Invalid Credentials');
        }

        $this->authenticator->authenticate($user);

        return new Redirect('/')->flash('status', 'Logged In Successfully');
    }

    #[Post('/logout', middleware: [Authenticated::class])]
    public function logout(): Redirect
    {
        $this->authenticator->deauthenticate();

        return new Redirect('/login')->flash('status', 'Logged Out Successfully');
    }
}
