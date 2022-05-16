<?php

session_start();
ob_start();

function find_task_by_id($id, $type = "incompleted")
{

    // var_dump($type);    
    // var_dump($_SESSION['task'][$type]);

    return array_pop(array_filter($_SESSION['task'][$type], function ($item) use ($id) {
        return $item['id'] == $id;
    }));
}

function edit_task_by_id($id, $type = "incompleted", $new_label)
{
    foreach ($_SESSION['task'][$type] as $key => &$task) {
        // echo "called";
        if ($id == $task['id']) {
            $task['label'] = $new_label;
        }
    }
}

function delete_task($id, $type = "incompleted")
{
    foreach ($_SESSION['task'][$type] as $key => &$task) {
        // echo "called";
        if ($id == $task['id']) {
            unset($_SESSION['task'][$type][$key]);
        }
    }
}

function move_to_completed($id)
{
    $task = find_task_by_id($id);
    $_SESSION['task']['completed'][] = $task;
    delete_task($id);
}

function move_to_incompleted($id)
{
    $task = find_task_by_id($id, "completed");
    $_SESSION['task']['incompleted'][] = $task;
    delete_task($id, "completed");
}


// move_to_completed(2);
// move_to_incompleted(2);

// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";

if (!isset($_SESSION['task'])) {
    $_SESSION['task'] = array(
        "completed" => array(),
        "incompleted" => array(),
    );
    $_SESSION['count'] = 0;
}

if (isset($_POST['add'])) {

    echo "adding...";

    var_dump($_POST);

    $new_task_count = (int)$_SESSION['count'] + 1;
    $_SESSION['task']['incompleted'][] = array(
        "id" => $new_task_count,
        "label" => $_POST['new-task'],
    );
    $_SESSION['count'] = $new_task_count;

    header("location: index.php");
    exit();

} elseif (isset($_POST['edit'])) {
    // echo "updating ...";
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $new_label = $_POST['new-task'];
    $task_id = (int)$_POST['task_id'];
    $from = $_POST['from'];

    // var_dump($new_label);
    // var_dump($task_id);    

    edit_task_by_id($task_id, $from, $new_label);

    header("location: index.php");
    exit();

} elseif (
    isset($_GET['action']) &&
    $_GET['action'] == "move_to_complete"
) {

    $task_id = (int)$_GET['task_id'];
    var_dump($task_id);
    move_to_completed($task_id);
    header("location: index.php");
    exit();

} elseif (
    isset($_GET['action']) &&
    $_GET['action'] == "move_to_incomplete"
) {

    $task_id = (int)$_GET['task_id'];
    var_dump($task_id);
    move_to_incompleted($task_id);
    header("location: index.php");
    exit();
    
} elseif (isset($_GET['action']) && $_GET['action'] == "edit") {
    //  edit    

    // echo "editing ..";

    $task_id = (int)$_GET['task_id'];
    $from = $_GET['from'];

    // echo "<pre>";
    // var_dump(find_task_by_id($task_id, $type));
    // echo "--";

    $task = find_task_by_id($task_id, $from);

    // var_dump($task);
    // echo $task['label'];

    $_GET['task'] = $task['label'];    

    // var_dump($_GET);

    // echo "</pre>";
} elseif (
    isset($_GET['action']) &&
    $_GET['action'] == "delete"
) {
    //  delete
    echo "going to delete";
    $task_id = (int)$_GET['task_id'];
    $from = $_GET['from'];
    
    // $type = $_GET['type'] ? ;

    // var_dump($task_id);
    // var_dump();

    delete_task($task_id, $from);
    header("location: index.php");
    exit();
}

// var_dump(delete_task(1, "incompleted"));

// var_dump(edit_task_by_id(4, "incompleted", "item 4 ## edited" ));

echo "<pre>";
// var_dump($_S)
// var_dump(array_pop(find_task_by_id(4)) );
// var_dump(array_pop(find_task_by_id(4))['label']  = "newwwwwwwwww");
echo "</pre>";
// var_dump(find_task_by_id(4));

// else{
//     display_form();
// }

?>

<!DOCTYPE html>
<html>

<head>
    <title>TODO List</title>
    <link href="style.css" type="text/css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <form action=""></form>
    <div class="container">
        <h2>TODO LIST</h2>
        <h3>Add Item</h3>
        <form action="" method="POST">
            <p>
                <input id="new-task" name="new-task"
                 type="text" value="<?php echo $_GET['task'] ?>">

                <?php if (isset($_GET['task'])) ?>
                <input type="hidden" name="task_id" value="<?php echo $_GET['task_id'] ?>">
                <input type="hidden" name="from" value="<?php echo $_GET['from'] ?>">
                <php } ?>

                <?php if (isset($_GET['task_id'])) { ?>
                    <button type="submit" name="edit" class="edit">Update</button>
                <?php } else { ?>
                    <button type="submit" name="add" class="add">Add</button>
                <?php } ?>

                <!-- <a href="?action=add" class="add">Add</a> -->
            </p>
        </form>



        <h3>Todo</h3>

        <ul id="incomplete-tasks">
            <?php foreach ($_SESSION['task']['incompleted'] as $task) { ?>
                <li data-id="<?php echo $task['id'] ?>">
                    <input type="checkbox">
                    <label><?php echo $task['label'] ?></label>
                    <input type="text">
                    <!-- <button class="edit">Edit</button>
                <button class="delete">Delete</button> -->
                    <a class="edit" 
                    href="?action=edit&amp;from=incompleted&amp;task_id=<?php echo $task['id'] ?>">Edit</a> <br>
                    <a class="delete" 
                    href="?action=delete&amp;from=incompleted&amp;task_id=<?php echo $task['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </li>
            <?php } ?>
        </ul>

        <h3>Completed</h3>
        <ul id="completed-tasks">
            <?php foreach ($_SESSION['task']['completed'] as $task) { ?>
                <li data-id="<?php echo $task['id'] ?>">
                    <input type="checkbox" checked>
                    <label><?php echo $task['label'] ?></label>
                    <input type="text">

                    <a class="edit"
                     href="?action=edit&amp;from=completed&amp;task_id=<?php echo $task['id'] ?>">Edit</a> <br>

                    <a class="delete" 
                    href="?action=delete&amp;from=completed&amp;task_id=<?php echo $task['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </li>
            <?php } ?>
        </ul>
    </div>

    <script>
        $(document).ready(function() {

            $("#incomplete-tasks").on("change", "input[type=checkbox]", function() {

                // console.log($(this).parent().attr("data-id"));

                let task_id = $(this).parent().attr("data-id");

                window.location.href =
                    `?action=move_to_complete&task_id=${task_id}`;

            });

            $("#completed-tasks").on("change", "input[type=checkbox]", function() {

                // console.log($(this).parent().attr("data-id"));

                let task_id = $(this).parent().attr("data-id");

                window.location.href =
                    `?action=move_to_incomplete&task_id=${task_id}`;

            });

            // $(".add").on("click", function(){

            //     let data = {};
            //     let task = $(this).prev().val();
            //     data['task'] = task;
            //     data['action'] = "add";

            //     $.post("index.php", data, function(data){
            //         console.log(data);
            //     });

            // });

            // $("#incomplete-tasks").

        });
    </script>

</body>

</html>