<?php
/**
 * @var null|string $title The webpage's title
 */

use Tempest\Auth\Authentication\Authenticator;
use Tempest\Http\Session\Session;

use function Tempest\get;

/** @var Authenticator $authenticator */
$authenticator = get(Authenticator::class);

/** @var Session $session */
$session = get(Session::class);

$user = $authenticator->current();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Tempest' }}</title>

    <x-slot name="head"/>
</head>
<body>
    <nav>
        <a :if="!$user" href="/register">Register</a> | 
        <a :if="!$user" href="/login">Login</a> | 

        <form :isset="$user" method="post" action="/logout">
            <x-csrf-token/>

            <input type="submit" value="Log Out">
        </form>
    </nav>

    <p :if="$session -> get('status')">{{ $session -> get("status") }}</p>

    <x-slot/>
    <x-slot name="scripts"/>
</body>
</html>