<?php

namespace Rss\Client\Controller;

use Rss\Client\Service\RssService;

class Top
{

    public function invoke($app)
    {
        return $app['twig']->render("client/index.twig", []);
    }

    public function convert($app)
    {

        $rssService = new RssService();

        $urlList = $app['request']->get('url');
        $outputList = $rssService->getOutputList($urlList);

        return $app['twig']->render("client/result.twig", [
            'outputList' => $outputList
        ]);
    }
}