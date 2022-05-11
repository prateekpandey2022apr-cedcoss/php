<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .error {
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

    if (isset($_POST["submit"])) {
        process_form();
    } else {
        display_form(array());
    }

    function validate_field($field, $missing_fields)
    {
        global $validation_errors;

        if(in_array($field, $missing_fields))
        {
            echo ' class="error"';
        }        
    }

    function process_form()
    {   
        $required_fields = array( "input", "conversion");
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

            // echo "<pre>";
            // var_dump($_POST);
            // echo "</pre>";
        
            // echo "called";
            // $num1_err = $num2_err = "";

            $hrs = $_POST['input'];            
            $conversion = $_POST['conversion'];

            if($conversion == "min")
            {
                $_POST['result'] = $hrs * 60;
            }
            else
            {
                $_POST['result'] = $hrs * 60 * 60;
            }
        
            display_form(array());
            // echo "form submitted";
        }
    }

    function display_form($missing_fields)
    {
        // global $validation_errors;
    ?>
        <?php if ($missing_fields) { ?>
            <p>There were some errors while trying to fill the form</p>
        <?php } ?>


        <?php //var_dump($validation_errors); 
        ?>

        <form action="" method="post">

            <p>
                <input type="text" name="input" id="input"
                 value="<?php echo $_POST['input'] ?>"
                 <?php echo validate_field("input", $missing_fields); ?>   >
            </p>            

            <p <?php echo validate_field("conversion", $missing_fields); ?> >
                <label for="min">
                    <input type="radio" name="conversion" value="min" id="min" 
                    
                    <?php if(isset($_POST['conversion']) && 
                    $_POST['conversion'] == "min" ) echo "checked" ?>  >Hours to mins
                </label>
                <br>
                <label for="sec">
                    <input type="radio" name="conversion" value="sec" id="sec"
                    <?php if(isset($_POST['conversion']) && 
                    $_POST['conversion'] == "sec" ) echo "checked" ?>
                    >Hours to secs
                </label>                
            </p>

            <?php if(isset($_POST['result'])) { ?>
                <p><?php echo $_POST['result'] ?></p>
            <?php } ?>            

            <p>
                <input type="submit" name="submit" value="Convert" id="submit">
            </p>       

        </form>

    <?php } ?>

</body>

</html>