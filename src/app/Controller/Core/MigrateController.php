<?php

namespace App\Controller\Core;

use App\Core\Controller;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Stream;

class MigrateController extends Controller
{

    public function index(RequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {

        if ($_ENV["DB_MIGRATION_ENABLED"] === 'true') {
            $dir = __DIR__ . "/../../../database/";

            $settings = $this->container->get("settings")["db"];
            $host = $settings['host'];
            $database = $settings['database'];
            $user = $settings['username'];
            $pass = $settings['password'];

            $file = "";
            if (isset($args['name']) && $args['name'] != "") $file = $args['name'] . ".sql";

            $output = shell_exec("php {$dir}migrate.php -m {$host} -d {$database} -u {$user} -p '{$pass}' {$dir}migrations/{$file}");
            echo nl2br($output);
            return $response;
        } else {
            return $this->notFound($response);
        }

    }

}