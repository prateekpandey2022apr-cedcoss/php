<?php

    $arr = array(1, 2, 3, 4, 5,);

    echo "Original Array";

    echo "<pre>";
    var_dump($arr);
    echo "</pre>";

    array_splice($arr, 3, 0, "$");

    echo "Modified Array";

    echo "<pre>";
    var_dump($arr);
    echo "</pre>";

?>