<?php

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../app/config/app.php';

$app = new \TanTest\Foundation\App(compact('config'));

$app->run();