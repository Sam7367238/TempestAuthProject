<?php
/**
 * @var null|string        $action
 * @var null|Method|string $method
 * @var null|string        $enctype
 */

use Tempest\Http\Method;

$action ??= null;
$method ??= Method::POST;

if ($method instanceof Method) {
    $method = $method->value;
}

$needsSpoofing = null !== Method::trySpoofingFrom($method);
$formMethod = $needsSpoofing ? 'POST' : $method;
?>

<form :action="$action" :method="$formMethod" :enctype="$enctype">
    <x-csrf-token />

    <?php if ($needsSpoofing) { ?>
        <input type="hidden" name="_method" value="<?php echo htmlspecialchars($method); ?>">
    <?php } ?>

    <x-slot />
</form>
