<?php

$routes = require_once dirname(__DIR__, 3) . '/config/routes.php';

$routes['users']->handle();