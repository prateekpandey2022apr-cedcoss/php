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

    if( isset($_POST["btn"]) )
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

        $required_fields = array( "num1", "num2");
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
            // $num1_err = $num2_err = "";

            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];
            $operation = $_POST['btn'];
            
            // if(!is_numeric($num1))
            // {
            //     $num1_err = "Field must be numeric";
            // }
    
            // if(!is_numeric($num1))
            // {
            //     $num1_err = "Field must be numeric";
            // }
    
            switch ($operation) 
            {
                case '+':
                    $result = $num1 + $num2;
                    break;
                case '-':
                    $result = $num1 - $num2;
                    break;            
                case 'x':                
                    $result = $num1 * $num2;
                    break;                
                case '/':                
                    $result = $num1 / $num2;                
                    break;                
                default:
                    $result = "Invalid Operation";                
            }      
            
            $_POST['result'] = $result;

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
            <td <?php validate_field("num1", $missing_fields); ?>
            >Number 1</td>
            <td><input type="text" name="num1" id="num1"                
               value="<?php echo $_POST['num1']; ?>">
            </td>            
        </tr>
        <tr>
            <td <?php validate_field("num2", $missing_fields); ?> 
             >Number 2</td>
            <td><input type="text" name="num2" id="num2" 
                value="<?php echo $_POST['num2']; ?>" ></td>        
        </tr>
        <tr>
            <td>Result</td>
            <td><input type="text" name="result" id="result"
             value="<?php echo $_POST['result']; ?>" ></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="btn" id="add" value="+">
                <input type="submit" name="btn" id="sub" value="-">
                <input type="submit" name="btn" id="mul" value="x">
                <input type="submit" name="btn" id="div" value="/">
            </td>
        </tr>
    </table>

</form>

<?php } ?>

</body>
</html>