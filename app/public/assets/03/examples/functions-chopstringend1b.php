<?php

// Our chopStringEnd function
function chopStringEnd(string $str, int $len, ?string $ending): string
{
    if (strlen($str) < $len)
        return $str;
    else
        return substr($str, 0, $len - strlen($str)) . $ending;
}

// Our variables
$origStr = 'Welkom in deze tweede workshop van Web Programming on Servers and Devices!';
$cutoffLength = '40'; // Oops... wrong type? Not really ... still flawlessly juggled
$endStr = '...';

// Go!
echo chopStringEnd($origStr, $cutoffLength, $endStr);