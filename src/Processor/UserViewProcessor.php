<?php

namespace App\Processor;

use Tempest\Auth\Authentication\Authenticator;
use Tempest\View\View;
use Tempest\View\ViewProcessor;

final readonly class UserViewProcessor implements ViewProcessor
{
    public function __construct(private Authenticator $authenticator) {}

    public function process(View $view): View
    {
        return $view->data(user: $this->authenticator->current());
    }
}
