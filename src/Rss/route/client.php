<?php

namespace Rss\Route;

use Rss\Client\Controller\Top;
use Symfony\Component\HttpFoundation\Response;

class Client {
    function __construct($app) {
        $app->get('/', function() use($app){
            $controller = new Top();
            return $controller->invoke($app);
        });

        $app->match('/convert', function() use($app){
            $controller = new Top();
            return $controller->convert($app);
        })->method('GET|POST');

        $app->error(function (\Exception $e, $code) use($app){
            if ($_SERVER['REQUEST_URI'] !== '/') {
                return $app->redirect('/');
            }
        });
    }
}
