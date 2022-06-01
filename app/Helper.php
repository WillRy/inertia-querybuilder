<?php


namespace App;


class Helper
{
    public static function clean(&$item, $chavesLimpar)
    {
        if (is_iterable($item)) $item = array_values($item);

        function walk(&$anything, $chavesLimpar)
        {
            if (!is_iterable($anything)) return;
            foreach ($anything as $key => &$value) {
                if (in_array($key, $chavesLimpar, true)) {
                    $anything[$key] = array_values($value);
                }
                walk($value, $chavesLimpar);
            }
        }

        walk($item, $chavesLimpar);
    }
}
