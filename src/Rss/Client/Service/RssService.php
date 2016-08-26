<?php

namespace Rss\Client\Service;

class RssService
{

    const STRIP_TITLE_LENGTH = 10;
    const STRIP_DESCRIPTION_LENGTH = 30;

    function __construct()
    {
    }

    public function getOutputList($urlList)
    {
        // convert
        $outputList = $this->convertRss($urlList);

        return $outputList;
    }

    private function convertRss($urlList)
    {
        $outputList = [];
        foreach ($urlList as $urlKey => $url) {
            libxml_use_internal_errors(true);
            $xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
            if ($xml) {
                if (!empty($xml->channel->item)) {
                    $itemList = $xml->channel->item;
                } else {
                    $itemList = $xml;
                }

                $counter = 0;
                foreach ($itemList as $list) {
                    $title = $list->title->__toString();

                    $stripTitle = $this->stripText($title, self::STRIP_TITLE_LENGTH);
                    $outputList[$urlKey][$counter]['title'] = $stripTitle;


                    $description = $list->description->__toString();
                    $stripDescription = $this->stripText($description, self::STRIP_DESCRIPTION_LENGTH);

                    $outputList[$urlKey][$counter]['description'] = $stripDescription;

                    $counter++;
                }
            }
        }

        return $outputList;
    }

    private function stripText($text, $textLength)
    {
        $stripText = strip_tags($text);
        if (mb_strlen($stripText) >= $textLength) {
            $stripText = mb_substr($stripText, 0, $textLength);
        }

        return $stripText;
    }

}
