<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<?php 

    // 450
    // 50, 400
    // 100, 300,
    // 100, 200,


    function calculate_bill($units)
    {
        $price = 0;        
        // $remaining_unit = 0;
        
        if($units <= 50)
        {
            $price = $units * 3.5;            
        }
        elseif($$units <= 150)
        {
            $price =  (50 * 3.5) + ($units - 50) * 4;
        }

        elseif($$units <= 250)
        {
            $price =  (50 * 3.5) + (100 * 4) + ($units - 150) * 4;
        }

        else
        {
            $price =  (50 * 3.5) + (100 * 4) + (100 * 5.2) + 
                      ($units - 250) * 6.5;
        }

        
        return $price;
    }

    echo calculate_bill(100);

?>
    
</body>
</html>