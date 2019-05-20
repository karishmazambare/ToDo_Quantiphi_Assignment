$(document).ready(function() {
    // Code to add task
    $('#add_btn').click(function(e){
        e.preventDefault();
        var data = {};
        userId = $('.task_input_user_id').val();
        task = $('.task_input').val();
        data['call'] = 'add_task';
        data['userId'] = userId;
        data['task'] = task;
        
        $.ajax({
            url: "ajax.php",
            type: "post",
            data: data,
            dataType: "json",
            success: function(result) {
                console.log(result);
                console.log(result.status);
                if (result.status == 'success') {
                    jQuery('.task_table > tbody:last-child').append('<tr><td><input type="checkbox" name="mark_complete" value="'+result.insertId+'"></td><td class="task">'+task+'</td><td class="delete"><a href="#" class = "delete" data-id = "'+result.insertId+'">delete</a> <a href="#" class = "update" data-id = "'+result.insertId+'">update</a></td></tr>');
                    $('.task_input').val('');
                } else {
                    $('.error_msg').text('Task cannot be empty');
                }
            }
        });
    })

    //Code to delete task
    $('body').on('click', '.delete', function(e) {
        e.preventDefault();
        var data = {};
        $thiss = $(this);
        taskId = $(this).attr('data-id');
        data['call'] = 'delete_task';
        data['taskId'] = taskId;
        
        $.ajax({
            url: "ajax.php",
            type: "post",
            data: data,
            dataType: "json",
            success: function(result) {
                console.log("SUCCESS");
                console.log(result);
                if (result.status == 'success') {
                    $thiss.closest('tr').remove();
                } else {
                    $('.error_msg').text('Some issue with deletion');
                }
            }
        });
    })

    //Code to display textbox for Update task
    $('body').on('click', '.update', function(e) {
        e.preventDefault();
        $html = $(this).closest('tr').find('.task').html();
        taskId = $(this).attr('data-id');
        $(this).closest('tr').find('.task').html('<input class="updateTaskText" type="text" value="'+$html+'"><button class="btn_update" data-id = "'+taskId+'">Update Task</button>');
    })

    //Code to Update task
    $('body').on('click', '.btn_update', function(e) {
        e.preventDefault();
        var data = {};
        $thiss = $(this);
        taskId = $(this).attr('data-id');
        task = $(this).closest('td').find('.updateTaskText').val();
        data['call'] = 'update_task';
        data['taskId'] = taskId;
        data['task'] = task;
        
        $.ajax({
            url: "ajax.php",
            type: "post",
            data: data,
            dataType: "json",
            success: function(result) {
                console.log("SUCCESS");
                console.log(result);
                if (result.status == 'success') {
                    $thiss.closest('tr').find('.task').html(task);
                } else {
                    $('.error_msg').text('Some issue with update');
                }
            }
        });
    })

    // Code to mark complete
    $('body').on('change', '[name=mark_complete]', function(e) {
    // jQuery('[name=mark_complete]').change(function(){
        markComplete = 0;
        if (jQuery(this).is(':checked')) {
            markComplete = 1;
        }

        var data = {};
        $thiss = $(this);
        taskId = $(this).val();
        data['call'] = 'mark_complete';
        data['taskId'] = taskId;
        data['completeStatus'] = markComplete;
        
        $.ajax({
            url: "ajax.php",
            type: "post",
            data: data,
            dataType: "json",
            success: function(result) {
            }
        });
    })
})