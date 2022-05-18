<?php

session_start();
ob_start();
require_once "./controller.php";

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
        <form action="" method="POST" id="form">
            <p>
                <input id="new_task" name="new_task" type="text" value="">

                <input type="hidden" name="task_id" id="task_id" value="null">
                <input type="hidden" name="from" id="from" value="incompleted">

                <input type="submit" name="submit" id="submit" class="add" value="add">

                <!-- <a href="?action=add" class="add">Add</a> -->
            </p>
        </form>


        <h3>Todo</h3>

        <ul id="incompleted">
        </ul>

        <h3>Completed</h3>
        <ul id="completed">
            <?php foreach ($_SESSION['task']['completed'] as $task) { ?>
                <li data-id="<?php echo $task['id'] ?>">
                    <input type="checkbox" checked>
                    <label><?php echo $task['label'] ?></label>
                    <input type="text">

                    <a class="edit" href="?action=edit&amp;from=completed&amp;task_id=<?php echo $task['id'] ?>">Edit</a> <br>

                    <a class="delete" href="?action=delete&amp;from=completed&amp;task_id=<?php echo $task['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </li>
            <?php } ?>
        </ul>
        
    </div>

    <script>

        function store_locally(data,) {
            localStorage.getItem("task")
        }

        function add_li(task, where) {

            let li_str = `\
<li data-id="${task.id}">
<input type="checkbox">
<label>${task.label}</label>
<input type="text">
<a class="edit" href="#">Edit</a> <br>
<a class="delete" 
href="#">Delete</a>
</li>`;

            let li_el = $(li_str);
            $(`#${where}`).append(li_el);

        }

        function populate_tasks(tasks) {
            $("#incompleted li").remove();
            $("#completed li").remove();

            if(tasks['incompleted'].length){
                for (const task of tasks['incompleted']) {
                    add_li(task, 'incompleted');
                }
            }

            if(tasks['completed'].length){
                for (const task of tasks['completed']) {
                    add_li(task, 'completed');
                }
            }

            $("#completed input[type=checkbox]").each(function(idx, el) { 
                $(el).attr("checked", "checked") 
            });
            
        }

        // populate form for editing the task
        function populate_form($task, from){
            $("#new_task").val($task['label']);
            $("#task_id").val($task['id']);
            $("#from").val(from);
            $("#submit").val("Update");
        }

        function clear_form(){
            if($("#new_task").val() !== ""){
                $("#new_task").val("");
                $("#task_id").val(null);
                $("#from").val("incompleted");
                $("#submit").val("Add");
            }
        }

        // parse query string 
        function parse_query_string(qs) {
            let qs_obj = {};
            qs = (qs[0] == "?") ? qs.substr(1, qs.length) : qs;
            let kv_pairs = qs.split("&");
            kv_pairs.forEach(function(val, idx) {
                // console.log(idx, val);
                let pair = val.split("=")
                qs_obj[decodeURIComponent(pair[0])] =
                    decodeURIComponent(pair[1])
            });

            // console.log(qs);
            // console.log(qs_obj);

            return qs_obj;
	    }   

        $(document).ready(function(){ 

            $("ul").on("click", ".delete", function(event) {

                let result = confirm("Are you sure?");
                if(!result){
                    return;
                }

                console.log($(this).closest("ul").attr("id"));
                let from = $(this).closest("ul").attr("id");
                let task_id = $(this).closest("li").attr("data-id");

                debugger;

                $.ajax({
                    url: "controller.php",
                    data: {
                        action: "delete",
                        task_id: task_id,
                        from: from
                    },
                    type: "GET",
                    error: function(xhr, status, err) {
                        console.log(xhr);
                    },
                    dataType: "json",
                    success: function(data, status, xhr) {
                        console.log("editring ...");
                        console.log(data);
                        // populate_form(data, from);
                        populate_tasks(data);
                        // debugger;
                        // store_locally(data);
                        // create_table(data);
                        // update_status()
                    },

                });

            });

            // handle click on edit button
            $("ul").on("click", ".edit", function(event) {
                event.preventDefault();
                console.log($(this).closest("ul"));
                let from = $(this).closest("ul").attr("id");
                let task_id = $(this).closest("li").attr("data-id");

                $.ajax({
                    url: "controller.php",
                    data: {
                        action: "edit",
                        task_id: task_id,
                        from: from
                    },
                    type: "GET",
                    error: function(xhr, status, err) {
                        console.log(xhr);
                    },
                    dataType: "json",
                    success: function(data, status, xhr) {
                        console.log("editring ...");
                        console.log(data);
                        populate_form(data, from);
                        // populate_tasks(data['incompleted']);
                        // debugger;
                        // store_locally(data);
                        // create_table(data);
                        // update_status()
                    },

                });

            });            


            // move tasks
            $("ul").on("change", "input[type=checkbox]", function() {

                // console.log($(this).parent().attr("data-id"));

                let from = $(this).closest("ul").attr("id");
                let task_id = $(this).closest("li").attr("data-id");

                let move = (from == "incompleted")? 
                "move_to_complete": "move_to_incomplete";
                
                // console.log(11);

                $.ajax({
                    url: "controller.php",
                    data: {
                        action: move,
                        task_id: task_id,                        
                    },
                    type: "GET",
                    error: function(xhr, status, err) {
                        console.log(xhr);
                    },
                    dataType: "json",
                    success: function(data, status, xhr) {
                        console.log("moved to complete");
                        console.log(data);
                        // populate_form(data, from);
                        populate_tasks(data);
                        // debugger;
                        // store_locally(data);
                        // create_table(data);
                        // update_status()
                    },

                });


                // window.location.href =
                //     `?action=move_to_complete&task_id=${task_id}`;

            });

            $("#completed-tasks").on("change", "input[type=checkbox]", function() {

                // console.log($(this).parent().attr("data-id"));

                let task_id = $(this).parent().attr("data-id");

                window.location.href =
                    `?action=move_to_incomplete&task_id=${task_id}`;

            });

            // add task
            // or handle edited task submission 
            $("form").on("submit", function(event) {
                event.preventDefault();       
                
                debugger;

                let form = $("#form");
                console.log(form.serialize());
                let form_serialized = form.serialize();

                if((/task_id=\d+/i).test(form_serialized)){
                    // edit the task
                    form_serialized += "&edit=submit";
                }
                else{
                    // add the task
                    form_serialized += "&add=submit";
                }                

                $.ajax({
                    url: "controller.php",
                    data: form_serialized,
                    type: "POST",
                    error: function(xhr, status, err) {
                        console.log(xhr);
                    },
                    dataType: "json",
                    success: function(data, status, xhr) {
                        console.log(data);
                        populate_tasks(data);
                        clear_form();                      
                    },

                });

            }); // form on submit
           

            // execute on page load
            $.ajax({
                url: "controller.php",
                data: {
                    'action': 'get-all'
                },
                type: "GET",
                error: function(xhr, status, err) {
                    console.log(xhr);
                },
                dataType: "json",
                success: function(data, status, xhr) {
                    console.log(data);
                    populate_tasks(data);
                    // debugger;
                    // store_locally(data);
                    // create_table(data);
                    // update_status()
                },

            });

            });  // documnent ready
    </script>

</body>

</html>