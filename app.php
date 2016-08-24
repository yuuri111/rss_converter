<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/src/Rss/route/client.php';

use Rss\Route\Client;

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/template',
));

new Client($app);
