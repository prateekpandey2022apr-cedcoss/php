<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>

    tr, td{
        border: 1px solid #e3e3e3;
        padding: 20px 10px;
    }

    table{
        border-collapse: collapse;
    }

    table tr:nth-child(odd) td:nth-child(even) {
    background: #000;
    }
    
    table tr:nth-child(even) td:nth-child(odd) {
    background: #000;
    }


    </style>

</head>
<body>

<?php

function chess_board(){

    $out_str = "<table>";

    for ($i = 1; $i < 9; $i++) { 
        $out_str .= "<tr>";

        for ($j = 1; $j < 9; $j++) { 
            $out_str .= "<td>($i, $j)</td>";            
        }

        $out_str .= "</tr>";
    }

    $out_str .= "</table>";

    return $out_str;
}


echo chess_board();


?>
    
</body>
</html>