<?php

use App\Controller\RegistrationController;

use function Tempest\Router\uri;

?>

<x-base title="Register">
    <h1>Register</h1>

    <x-form :action="uri([RegistrationController::class, 'processRegisterForm'])">
        <x-input name="username" type="text" label="Username"/>
        <x-input name="password" type="password" label="Password"/>

        <x-csrf-token/>

        <x-submit/>
    </x-form>
</x-base>