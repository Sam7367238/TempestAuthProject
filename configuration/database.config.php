<?php

use Tempest\Database\Config\SQLiteConfig;

use function Tempest\root_path;

// Create a database folder in the root of the project if you are using SQLite.
return new SQLiteConfig(path: root_path('database/database.sqlite'));
