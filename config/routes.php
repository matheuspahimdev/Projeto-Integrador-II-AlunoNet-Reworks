<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once SRC_PATH . '/controllers/users/UsersController.php';

return [
    'users' => new UsersController(),
];