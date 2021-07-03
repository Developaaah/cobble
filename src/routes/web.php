<?php

#
# Web Routes
#
# usage: $app->get();

use App\Controller\Core\MigrateController;
use App\Controller\Frontend\IndexController;

$app->get("/", IndexController::class);
$app->get("/download", IndexController::class . ":downloadAction");
$app->get("/lang/{lang}", IndexController::class . ":lang");

$app->get("/migrate", MigrateController::class);