#!/usr/bin/env php
<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Application;

$server = new \App\SwooleServer(new Application(__DIR__ . '/config'));
$server->run();
