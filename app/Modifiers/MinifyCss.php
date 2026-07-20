<?php

namespace App\Modifiers;

use Statamic\Modifiers\Modifier;

class MinifyCss extends Modifier
{
    public function index($value, $params, $context)
    {
        $value = (string) $value;
        $value = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $value);
        $value = preg_replace('/\s+/', ' ', $value);
        $value = preg_replace('/\s*([:;{},>~])\s*/', '$1', $value);
        return trim($value);
    }
}
