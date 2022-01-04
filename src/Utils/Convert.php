<?php

namespace CeddyG\ClaraPim\Utils;

/**
 * Description of Convert
 *
 * @author ceddy
 */
class Convert
{
    public static function intToCslashes(int $iInt)
    {
        return str_replace('\\', '/', 
            addcslashes(
                $iInt, '0..9'
            )
        );
    }
}
