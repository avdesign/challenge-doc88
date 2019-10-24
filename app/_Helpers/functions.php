<?php

/**
* Price: Real
*
* @param  decimal $value
*/
if (! function_exists('formatReal')) {
    function formatReal($value){
        return 'R$ '.number_format((float)$value,2,',','.');
    }
}

/**
 *Words Shuffle
 *
 * @param  array $array
 */
if (! function_exists('wordsShuffle')) {
    function wordsShuffle($array){
        $count = count($array);
        $indi = range(0,$count-1);
        shuffle($indi);
        $newarray = array($count);
        $i = 0;
        foreach ($indi as $index)
        {
            $newarray[$i] = $array[$index];
            $i++;
        }
        return $newarray[0];
    }
}

/**
 *Cell Numbers
 *
 * @param  string $prefix
 */
if (! function_exists('cellNumbers')) {
    function cellNumbers($prefix){
        $n1 = rand() % 9000 + 1000;
        $n2 = rand() % 9000 + 1000;

        return "{$prefix}9$n1-$n2";
    }
}


/**
 * Retorna só número de uma string;
 */
if ( !function_exists('returnNumber'))
{
    function returnNumber($str)
    {
        return preg_replace("/[^0-9]/", "", $str);
    }
}



