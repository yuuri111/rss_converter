<?php
namespace Rss\Client\Controller;

class Top
{

    public function invoke($app)
    {
        return $app['twig']->render("client/index.twig", []);
    }
}
