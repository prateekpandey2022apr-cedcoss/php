<?php

    $first_arr = array(
        "one",
        "two",
        "three",
        "four",
    );
    
    $to_delete = "two";

    echo "Original Array: ";

    echo "<pre>";
    var_dump($first_arr);
    echo "</pre>";

    $new_array = array_filter($first_arr, function($val) use($to_delete){
        return $val != $to_delete;
    });

    echo "After deletion of: {$to_delete}";
    
    echo "<pre>";
    var_dump($new_array);
    echo "</pre>";

    // echo "<pre>";
    // var_dump($first_arr);
    // echo "</pre>";

?>