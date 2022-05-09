<?php

function find_grade($marks){
    if($marks >= 60){
        return "First Division";
    }
    elseif( $marks >= 45 && $marks <= 59 ){
        return "Second Division";
    }
    elseif( $marks >= 33 && $marks <= 44 ){
        return "Third Division";
    }
    else{
        return "Fail";
    }
}


echo find_grade(95) . "<br>";
echo find_grade(40) . "<br>";


?>