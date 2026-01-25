<?php

namespace App\Controller;

use Tempest\Router\Get;
use Tempest\View\View;

use function Tempest\root_path;
use function Tempest\view;

final readonly class HomeController
{
    #[Get('/')]
    public function __invoke(): View
    {
        return view(root_path('templates/home.view.php'));
    }
}
