<?php
require __DIR__ . '/../vendor/autoload.php';

use TanTest\Foundation\App;

$config = require __DIR__ . '/../app/config/app.php';

$app = new App(compact('config'));
$app->run();