<?php

use Tempest\Intl\IntlConfig;
use Tempest\Intl\Locale;

return new IntlConfig(
    currentLocale: Locale::ENGLISH,
    fallbackLocale: Locale::ENGLISH,
);
