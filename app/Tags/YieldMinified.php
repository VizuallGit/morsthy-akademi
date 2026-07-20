<?php

namespace App\Tags;

use Statamic\Facades\Cascade;
use Statamic\Tags\Tags;
use App\Tags\StylePush;

class YieldMinified extends Tags
{
    protected static $handle = 'yield_minified';

    public function index()
    {
        $section = $this->params->get('section');

        $content = StylePush::getAll();
        if (!$content) {
            $content = view()->shared('__env')->yieldContent($section);
        }
        if (!$content) {
            $content = Cascade::instance()->sections()->get($section);
        }

        $content = (string) $content;
        $content = preg_replace('!<style[^>]*>|</style>!i', '', $content);
        $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
        $content = preg_replace('/\s+/', ' ', $content);
        $content = preg_replace('/\s*([:;{},])\s*/', '$1', $content);
        $content = trim($content);

        return $content ? "<style>{$content}</style>" : '';
    }
}
