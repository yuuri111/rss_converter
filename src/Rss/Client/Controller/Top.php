<?php

namespace Rss\Client\Controller;

use Rss\Client\Service\RssService;
use Rss\Client\Middleware\Form;

class Top
{

    public function __construct()
    {
        $this->form = new Form();
    }

    public function invoke($app)
    {
        return $app['twig']->render("client/index.twig", []);
    }

    public function convert($app)
    {

        $rssService = new RssService();

        $urlList = $app['request']->get('url');
        foreach ($urlList as $url) {
            $this->form->mustBeText($url);
        }

        $showDate = $app['request']->get('show_date');
        $onlyTitle = $app['request']->get('only_title');

        $outputList = $rssService->getOutputList($urlList, $showDate, $onlyTitle);

        return $app['twig']->render("client/result.twig", [
            'outputList' => $outputList
        ]);
    }
}