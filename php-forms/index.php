<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>

    .error{
        background-color: red;
    }

    </style>

</head>

<body>


<?php 
    
    // echo "<pre>";
    // var_dump($_POST);    
    // echo "</pre>";    

    // $validation_errors = array();

    if( isset($_POST["submit"]) )
    {        
        process_form();
    }    
    else
    {        
        display_form(array());
    }
    
    function validate_field($field, $missing_fields)
    {
        global $validation_errors;

        if(in_array($field, $missing_fields))
        {
            echo ' class="error"';
        }

        else
        {
            if ( !is_numeric($_POST[$field]) && !empty($_POST[$field]) )
            {
                $validation_errors[$field] = "$field must be numeric";
                echo ' class="error"';
                // var_dump($validation_errors);
            }
        }
    }

    function process_form()
    {

        $required_fields = array( "length", "width");
        $missing_fields = array();

        foreach ($required_fields as $field) {
            if( !isset($_POST[$field]) or empty($_POST[$field]) )
            {
                $missing_fields[] = $field;
            }
        }

        if($missing_fields)
        {
            display_form($missing_fields);
        }
        else
        {
            // echo "called";
            // $num1_err = $num2_err = "";

            $length = $_POST['length'];
            $width = $_POST['width'];            

            $_POST['area'] = $length * $width;
            $_POST['peri'] = 2 * ($length + $width);
            $_POST['result'] = true;
            
            // if(!is_numeric($num1))
            // {
            //     $num1_err = "Field must be numeric";
            // }
    
            // if(!is_numeric($num1))
            // {
            //     $num1_err = "Field must be numeric";
            // }          

            // var_dump($_POST);

            display_form(array());

    
        }

        // echo "form submitted";
    }

    function display_form($missing_fields)
    { 
        // global $validation_errors;
?>
    <?php if ($missing_fields) { ?>
        <p>There were some errors while trying to fill the form</p>
    <?php } ?>


    <?php //var_dump($validation_errors); ?>

<form action="" method="post">

    <table>
        <tr>
            <td <?php validate_field("length", $missing_fields); ?>
            >Length of Rectangle</td>
            <td><input type="text" name="length" id="length"                
               value="<?php echo $_POST['length']; ?>">
            </td>            
        </tr>
        <tr>
            <td <?php validate_field("width", $missing_fields); ?> 
             >Width of rectangle</td>
            <td><input type="text" name="width" id="width" 
                value="<?php echo $_POST['width']; ?>" ></td>        
        </tr>        
        <tr>
            <td></td>
            <td>
                <input type="submit" name="submit" id="submit" 
                value="Calculate Area and Perimeter">                
            </td>
        </tr>
    </table>

    <?php    

    ?>

    <?php if(isset($_POST['result'])) { ?>

    <div class="">
        <div>Area is <?php echo $_POST['area'] . " sq. mtr." ?></div>
        <div>Perimeter is <?php echo $_POST['peri'] . " mtr" ?></div>
    </div>

    <?php } ?>

</form>

<?php } ?>

</body>
</html>