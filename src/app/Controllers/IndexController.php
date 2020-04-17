<?php

namespace App\Controllers;

use App\Core\Controller;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class IndexController extends Controller
{

    protected $styles = ['style'];

    protected $scripts = ['app'];

    public function index(Request $request, Response $response)
    {
        return $this->view("frontend/index", $response, []);
    }

}