<?php
require_once __DIR__ . '/../../lib/autenticacao.php';

logout();
redirectTo(LOGIN_PATH);
