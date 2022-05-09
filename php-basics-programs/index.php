<?php

function factorial($num){

    $fact = 1;

    for ($i = $num; $i > 1; $i--) { 
        $fact *= $i;
    }
   
    return $fact;
}


echo factorial(5) . "<br>";
echo factorial(0) . "<br>";


?>