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

    // echo "<hr>";

    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

    // echo "<pre>";    
    // // var_dump($_FILES['image']['size'] / (1024 * 1024) );
    // // var_dump($_FILES['image']['size'] / (1024 * 1024) > 2 );
    // echo "</pre>";

    // $validation_errors = array();

    if (isset($_POST["submit"]) && 
    $_FILES['image']['error'] == "UPLOAD_ERR_OK") 
    {
        if( $_FILES['image']['size'] / (1024 * 1024) > 2)
        {
            echo "Size > 2MB";
        }
        elseif( $_FILES['image']['type'] != "image/png" )
        {
            echo "File isn't PNG";            
        }
        else
        {
            // echo "uploading ...";

            move_uploaded_file($_FILES['image']['tmp_name'], 
            "./uploads/" . $_FILES['image']['name']);

            echo "File Uploaded";            
        }

        display_form(array());
        
    } 
    else 
    {
        display_form(array());
    }

    function validate_field($field, $missing_fields)
    {
        // global $validation_errors;

        if(in_array($field, $missing_fields))
        {
            echo ' class="error"';
        }
    }

    function process_form()
    {
        $required_fields = array( "image",);
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

            // $hrs = $_POST['input'];
            // $conversion = $_POST['conversion'];

            // if($conversion == "min")
            // {
            //     $_POST['result'] = $hrs * 60;
            // }
            // else
            // {
            //     $_POST['result'] = $hrs * 60 * 60;
            // }

            display_form(array());
            // echo "form submitted";
        }
    }

    function display_form($missing_fields)
    {

        // var_dump($missing_fields);
        // global $validation_errors;
    ?>        


        <?php //var_dump($validation_errors);
        ?>

        <form action="" method="post" enctype="multipart/form-data">

            <p>                
                <input type="file" name="image" id="image">
            </p>

            <p>
            <input type="submit" name="submit">
            </p>

        </form>

    <?php } ?>

</body>

</html>