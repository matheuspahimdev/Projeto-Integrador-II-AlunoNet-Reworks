<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/auth.php';

logoutSession();
header('Location: /pages/auth/login.php');
exit;