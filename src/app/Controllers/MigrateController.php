<?php

namespace App\Controllers;

use App\Core\Controller;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class MigrateController extends Controller
{

    public function migrate(Request $request, Response $response, array $args)
    {
        if (getenv("DB_MIGRATION_ENABLED") === 'true') {
            $dir = __DIR__ . "/../../database/";

            $host = getenv("DB_HOST");
            $database = getenv("DB_DATABASE");
            $user = getenv("DB_USERNAME");
            $pass = getenv("DB_PASSWORD");

            $file = "";
            if (isset($args['name']) && $args['name'] != "") $file = $args['name'] . ".sql";

            $output = shell_exec("php {$dir}migrate.php -m {$host} -d {$database} -u {$user} -p '{$pass}' {$dir}migrations/{$file}");
            return nl2br($output);
        } else {
            return $this->error($response, "Error 404", "Page not found");
        }
    }

}