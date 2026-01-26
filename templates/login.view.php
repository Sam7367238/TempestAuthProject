<?php

use App\Controller\SessionController;

use function Tempest\Router\uri;

?>

<x-base title="Log In">
    <h1>Log In</h1>

    <x-form :action="uri([SessionController::class, 'processLoginForm'])">
        <x-input name="username" type="text" label="Username"/>
        <x-input name="password" type="password" label="Password"/>

        <x-csrf-token/>

        <x-submit/>
    </x-form>
</x-base>