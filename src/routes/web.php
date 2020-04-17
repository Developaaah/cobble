<?php

use App\Controllers\IndexController;
use App\Controllers\MigrateController;

$app->get("/", IndexController::class . ":index");
$app->get('/migrate[/{name}]', MigrateController::class . ":migrate");