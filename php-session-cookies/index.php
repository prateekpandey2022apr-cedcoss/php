<?php

session_start();

if (
    isset($_POST["submit"]) &&
    $_FILES['image']['error'] == "UPLOAD_ERR_OK"
) {
    if ($_FILES['image']['size'] / (1024 * 1024) > 2) {
        echo "Size > 2MB";
    } elseif ($_FILES['image']['type'] != "image/png") {
        echo "File isn't PNG";
    } else {
        // echo "uploading ...";

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "./uploads/" . $_FILES['image']['name']
        );        

        // echo "File Uploaded";

        // setcookie(
        //     time(),
        //     "./uploads/" . time() . "_" . $_FILES['image']['name'],
        //     time() + 60 * 60,
        //     "/"
        // );

        $_SESSION[uniqid()] = "./uploads/" . $_FILES['image']['name'];        

        // session_write_close();

        header("location: index.php");
        exit;
    }

    display_form(array());
} else {
    display_form(array());
}

?>

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

        div{
            display: inline-block;
            margin: 15px 15px;
            text-align: center;
            border: 1px solid #e3e3e3;            
            padding: 5px 10px;
        }

        .caption{
            display: inline-block;
            font-weight: bold;
            margin: 10px;
        }

    </style>

</head>

<body>

    <?php

    function validate_field($field, $missing_fields)
    {
        // global $validation_errors;

        if (in_array($field, $missing_fields)) {
            echo ' class="error"';
        }
    }

    function process_form()
    {
        $required_fields = array("image",);
        $missing_fields = array();


        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) or empty($_POST[$field])) {
                $missing_fields[] = $field;
            }
        }

        if ($missing_fields) {
            display_form($missing_fields);
        } else {

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

        <h1>Image Gallery</h1>

        <p>This page displays the list of uploaded images</p>

        <form action="" method="post" enctype="multipart/form-data">

            <p>
                <input type="file" name="image" id="image">
            </p>

            <p>
                <input type="submit" name="submit">
            </p>

        </form>        

    <?php
    }
    ?>

    <?php    
    // var_dump(count($_SESSION));

    // echo "<pre>";
    // var_dump($_SESSION);
    // echo "</pre>";

    if (count($_SESSION)) {
        foreach ($_SESSION as $key => $value) {   ?>
            <div class="display">
                <img src="<?php echo $value ?>" width="200" size="200" alt=""> <br>
                <span class="caption"><?php echo basename($value); ?></span>
            </div>
    <?php }
    } ?>

</body>

</html>