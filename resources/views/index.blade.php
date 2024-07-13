<!--
 Name:- Atul Pratap Singh
 Company:- WebReinvent
 Date:- 13/07/2024

-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atul Pratap Singh | WebReinvent Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">   
     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .task-item.done {
            text-decoration: line-through;
            color: grey;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Atul Pratap Singh | WebReinvent ToDo List Task</h3>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <input type="text" id="task-name" class="form-control" placeholder="Add a new task">
                    <div class="input-group-append">
                        <button class="btn btn-primary" id="add-task">Add Task</button>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Task</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="task-list">
                        
                    </tbody>
                </table>
                <button class="btn btn-secondary mt-3" id="show-all-tasks">Show All Tasks</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var taskCount = 0;

            // Add Task
            $('#add-task').click(function() {
                var taskName = $('#task-name').val();
                if(taskName.trim() === "") {
                    alert('Task name cannot be empty.');
                    return;
                }

                $.ajax({
                    url: '/tasks',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: taskName
                    },
                    success: function(response) {
                        taskCount++;
                        $('#task-list').append('<tr class="task-item" data-id="' + response.id + '"><td>' + taskCount + '</td><td>' + response.name + '</td><td class="status">Not Completed</td><td><button class="btn btn-sm btn-success mark-complete">✓</button> <button class="btn btn-sm btn-danger delete-task">✗</button></td></tr>');
                        $('#task-name').val('');
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.errors.name[0]);
                    }
                });
            });

            // Complete Task
            $(document).on('click', '.mark-complete', function() {
                var taskId = $(this).closest('tr').data('id');
                $.ajax({
                    url: '/tasks/' + taskId,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var taskRow = $('[data-id="' + response.id + '"]');
                        taskRow.addClass('done');
                        taskRow.find('.status').text('Completed');
                        taskRow.find('.mark-complete').hide();
                    }
                });
            });

            // Delete Task
            $(document).on('click', '.delete-task', function() {
                if (confirm('Are you sure to delete this task?')) {
                    var taskId = $(this).closest('tr').data('id');
                    $.ajax({
                        url: '/tasks/' + taskId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                $('[data-id="' + taskId + '"]').remove();
                                taskCount--;
                                updateTaskNumbers();
                            }
                        }
                    });
                }
            });

            // Show All Tasks
            $('#show-all-tasks').click(function() {
                $.ajax({
                    url: '/tasks',
                    type: 'GET',
                    success: function(response) {
                        $('#task-list').empty();
                        taskCount = 0;
                        $.each(response, function(index, task) {
                            taskCount++;
                            var taskClass = task.completed ? 'done' : '';
                            var taskStatus = task.completed ? 'Completed' : 'Not Completed';
                            var completeButtonVisibility = task.completed ? 'style="display:none;"' : '';
                            $('#task-list').append('<tr class="task-item ' + taskClass + '" data-id="' + task.id + '"><td>' + taskCount + '</td><td>' + task.name + '</td><td class="status">' + taskStatus + '</td><td><button class="btn btn-sm btn-success mark-complete" ' + completeButtonVisibility + '>✓</button> <button class="btn btn-sm btn-danger delete-task">✗</button></td></tr>');
                        });
                    }
                });
            });

            function updateTaskNumbers() {
                $('#task-list tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });
            }
        });
    </script>
</body>
</html>
