<?php

App::uses('TextHelper', 'View/Helper');

class ExtraTextHelper extends TextHelper
{
    public function ellipsize($str, $max_length, $position = 1, $ellipsis = '&hellip;')
    {
        // Strip tags
        $str = preg_replace("/\s+/", " ", trim(strip_tags($str)));
        // Is the string long enough to ellipsize?
        if (strlen($str) <= $max_length) {
            return $str;
        }
        $beg = substr($str, 0, floor($max_length * $position));
        $position = ($position > 1) ? 1 : $position;
        if ($position === 1) {
            $end = substr($str, 0, -($max_length - strlen($beg)));
        } else {
            $end = substr($str, -($max_length - strlen($beg)));
        }
        return $beg.$ellipsis.$end;
    }

    public function lineLimiter($string, $number_of_lines = 10)
    {
        return implode("\n", array_slice(explode("\n", $string), 0, $number_of_lines));
    }
}
