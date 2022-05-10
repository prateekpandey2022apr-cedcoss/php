<?php

    $first_arr = array(
        'c1' => 'Red', 
        'c2' => 'Green', 
        'c3' => 'White', 
        'c4' => 'Black',
    );

    $filter_by = array("c2", "c4");

    $new_array = array_filter($first_arr, function($key) use($filter_by){
        // return $key !== "c2" && $key !== "c4";
        return !in_array($key, $filter_by);
    }, ARRAY_FILTER_USE_KEY);

    echo "<pre>";
    var_dump($new_array);
    echo "</pre>";

?>