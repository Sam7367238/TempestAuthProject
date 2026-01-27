<?php

namespace App\Middleware;

use Tempest\Auth\Authentication\Authenticator;
use Tempest\Core\Priority;
use Tempest\Discovery\SkipDiscovery;
use Tempest\Http\GenericResponse;
use Tempest\Http\Request;
use Tempest\Http\Response;
use Tempest\Http\Status;
use Tempest\Router\HttpMiddleware;
use Tempest\Router\HttpMiddlewareCallable;

/**
 * Guest Middleware
 * @param Authenticator $authenticator Tempest's Authenticator
 */
#[SkipDiscovery]
#[Priority(Priority::HIGHEST)]
final readonly class Guest implements HttpMiddleware
{
    public function __construct(private Authenticator $authenticator) {}

    /**
     * @param Request $request
     * @param HttpMiddlewareCallable $next
     * @return GenericResponse|Response
     */
    public function __invoke(Request $request, HttpMiddlewareCallable $next): Response
    {
        $user = $this->authenticator->current();

        if ($user) {
            return new GenericResponse(Status::UNAUTHORIZED, 'Access Denied');
        }

        return $next($request);
    }
}
