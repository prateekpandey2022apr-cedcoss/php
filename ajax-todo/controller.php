<?php 

session_start();

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
            // unset($_SESSION['task'][$type][$key]);
            array_splice($_SESSION['task'][$type], $key, 1);
        }
    }

    // echo "<pre>";
    // var_dump($_SESSION['task']);
    // echo "</pre>";
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

if(isset($_GET['action']) && $_GET['action'] == "get-all" ){
    echo json_encode($_SESSION['task']);
}

elseif (isset($_POST['add'])) {

    // echo "adding...";

    // var_dump($_POST);
    // var_dump($_SESSION);

    $new_task_count = (int)$_SESSION['count'] + 1;
    $_SESSION['task']['incompleted'][] = array(
        "id" => $new_task_count,
        "label" => $_POST['new_task'],
    );
    $_SESSION['count'] = $new_task_count;

    echo json_encode($_SESSION['task']);

    // header("location: index.php");
    // exit();

} elseif (isset($_POST['edit'])) {
    // echo "updating ...";
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
    // echo "editing ...";

    $new_label = $_POST['new_task'];
    $task_id = (int)$_POST['task_id'];
    $from = $_POST['from'];

    // var_dump($new_label);
    // var_dump($task_id);    

    edit_task_by_id($task_id, $from, $new_label);

    echo json_encode($_SESSION['task']);

    // header("location: index.php");
    // exit();

} elseif (
    isset($_GET['action']) &&
    $_GET['action'] == "move_to_complete"
) {

    $task_id = (int)$_GET['task_id'];
    // var_dump($task_id);
    move_to_completed($task_id);

    echo json_encode($_SESSION['task']);

    // header("location: index.php");
    // exit();

} elseif (
    isset($_GET['action']) &&
    $_GET['action'] == "move_to_incomplete"
) {

    $task_id = (int)$_GET['task_id'];
    // var_dump($task_id);
    move_to_incompleted($task_id);

    echo json_encode($_SESSION['task']);

    // header("location: index.php");
    // exit();
    
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

    // $_GET['task'] = $task['label']; 
    
    echo json_encode($task);

    // var_dump($_GET);

    // echo "</pre>";
} elseif (
    isset($_GET['action']) &&
    $_GET['action'] == "delete"
) {
    //  delete
    // echo "going to delete";
    $task_id = (int)$_GET['task_id'];
    $from = $_GET['from'];
    
    // $type = $_GET['type'] ? ;

    // var_dump($task_id);
    // var_dump();

    delete_task($task_id, $from);

    echo json_encode($_SESSION['task']);

    // header("location: index.php");
    // exit();
}

// var_dump(delete_task(1, "incompleted"));

// var_dump(edit_task_by_id(4, "incompleted", "item 4 ## edited" ));

// echo "<pre>";
// var_dump($_S)
// var_dump(array_pop(find_task_by_id(4)) );
// var_dump(array_pop(find_task_by_id(4))['label']  = "newwwwwwwwww");
// echo "</pre>";
// var_dump(find_task_by_id(4));

// else{
//     display_form();
// }
