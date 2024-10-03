<?php

// Our chopStringEnd function
function chopStringEnd(string $str, int $len): string
{
    if (strlen($str) < $len)
        return $str;
    else
        return substr($str, 0, $len - strlen($str)) . '---';
}

// Our variables
$origStr = 'Welkom in deze tweede workshop van Web Programming on Servers and Devices!';
$cutoffLength = 40;
$endStr = '...';

// Go!
echo chopStringEnd($origStr, $cutoffLength, $endStr);