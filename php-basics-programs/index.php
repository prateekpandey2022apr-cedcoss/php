<?php

function weekday($num){

    switch ($num) {
        case 1:            
            return "Monday";
        case 2:            
            return "Tuesday";
        case 3:            
            return "Wednesday";
        case 4:            
            return "Thursday";
        case 5:            
            return "Friday";
        case 6:            
            return "Saturday";
        case 7:            
            return "Sunday";        
        default:
            return "Invalid Number";
    }
    
}


echo weekday(1) . "<br>";
echo weekday(6) . "<br>";
echo weekday(8). "<br>";


?>