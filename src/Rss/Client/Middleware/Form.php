<?php

namespace Rss\Client\Middleware;

class Form {

    public function __construct() {
    }

    public function mustBeText($value, $maxSize = 500) {
        if (empty($value) || !is_string($value) || $maxSize < mb_strlen($value)) {
            throw new \Exception('テキストが不正です');
        }
    }
}