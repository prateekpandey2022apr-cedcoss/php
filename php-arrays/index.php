<?php

    $recorded_temps = array(
        78, 60, 62, 68, 71, 68, 73, 85, 66, 
        64, 76, 63, 75, 76, 73, 68, 62, 73, 
        72, 65, 74, 62, 62, 65, 64, 68, 73, 
        75, 79, 73
    );

    $sum = 0;

    foreach($recorded_temps as $tmp){
        $sum += $tmp;
    }

    $avg = $sum / count($recorded_temps);

    echo "Average Temperature is:  " . round($avg, 2);

    sort($recorded_temps);

    $lowest_tmp = array();
    $highest_tmp = array();
    
    // store lowest 5 temps
    for ($i = 0; $i < 5; $i++) { 
        $lowest_tmp[] = $recorded_temps[$i];
    }
        
    echo "<br>";

    echo "List of 5 lowest temperatures: ";

    foreach($lowest_tmp as $tmp){
        echo $tmp . " ";
    }

    echo "<br>";    

    // store highest 5 temps
    for ($i = count($recorded_temps) - 6; $i < count($recorded_temps) - 1 ; $i++) {         
        $highest_tmp[] = $recorded_temps[$i];
    }    

    echo "List of 5 highest temperatures: ";

    foreach($highest_tmp as $tmp){
        echo $tmp . " ";
    }

    echo "<br>";

?>