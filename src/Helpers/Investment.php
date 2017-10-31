<?php

namespace Debenture\Helpers;

class Investment
{
    
    public function __construct()
    {
        echo "Investment instance";
    }

    public static function calculate($value, $interest, $correction)
    {
        $index = $interest + $correction;
        return $value + ($value * ($index / 100));
    }

    public static function interest($value, $interest, $correction)
    {
        $index = $interest + $correction;
        return $value * ($index / 100);
    }

}
