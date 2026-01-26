<?php

?>

<x-base title="Register">
    <h1>Register</h1>

    <x-form :action="uri([SessionController::class, 'processRegisterForm'])">
        <x-input name="username" type="text" label="Username"/>
        <x-input name="password" type="password" label="Password"/>

        <x-csrf-token/>

        <x-submit/>
    </x-form>
</x-base>