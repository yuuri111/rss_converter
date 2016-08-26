<?php

namespace Rss\Client\Service;

class RssService
{

    const STRIP_TITLE_LENGTH = 10;
    const STRIP_DESCRIPTION_LENGTH = 30;

    public function getOutputList($urlList, $showDate, $onlyTitle)
    {
        // convert
        $outputList = $this->convertRss($urlList, $showDate, $onlyTitle);

        return $outputList;
    }

    private function convertRss($urlList, $showDate, $onlyTitle)
    {
        $outputList = [];
        foreach ($urlList as $url) {
            libxml_use_internal_errors(true);
            $xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
            if ($xml) {
                if (!empty($xml->channel->item)) {
                    $itemList = $xml->channel->item;
                } else {
                    $itemList = $xml;
                }
                $siteTitle = $xml->channel->title->__toString();

                $counter = 0;
                foreach ($itemList as $list) {
                    $title = $list->title->__toString();

                    $stripTitle = $this->stripText($title, self::STRIP_TITLE_LENGTH);
                    $outputList[$siteTitle][$counter]['title'] = $stripTitle;

                    if ($onlyTitle !== "on") {
                        $description = $list->description->__toString();
                        $stripDescription = $this->stripText($description, self::STRIP_DESCRIPTION_LENGTH);

                        $outputList[$siteTitle][$counter]['description'] = $stripDescription;

                        if ($showDate === "on") {
                            $pubDate = $list->pubDate->__toString();
                            $outputList[$siteTitle][$counter]['pubDate'] = date("Y-m-d H:i:s", strtotime($pubDate));
                        }
                    }

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
