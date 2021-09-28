<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
    <title>To Do App</title>
</head>
<body>
<div class="container">
<h1>Todo App</h1>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
            <div class="col-12 text-right">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTodoModal">Add Todo</button>
            </div>
            </div>
            <div class="row" style="clear: both;margin-top: 18px;">
                <div class="col-12">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Todo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    
                    @foreach($todos as $todo)
                        <tr id="todo_{{$todo->id}}">
                            <td>{{ $todo->id  }}</td>
                            <td>{{ $todo->todo }}</td>
                            <td>
                                <a data-id="{{ $todo->id }}" onclick="editTodo(event.target)" class="btn btn-info">Edit</a>
                                <a class="btn btn-danger" onclick="deleteTodo({{ $todo->id }})">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
    
</div>
<div class="modal fade" id="addTodoModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Add Todo</h4>
        </div>
        <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="col-sm-2">Task</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="task" name="todo" placeholder="Enter task">
                        <span id="taskError" class="alert-message"></span>
                    </div>
                </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="addTodo()">Save</button>
        </div>
    </div>
  </div>
  
</div>
<div class="modal fade" id="editTodoModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit Todo</h4>
        </div>
        <div class="modal-body">

               <input type="hidden" name="todo_id" id="todo_id">
                <div class="form-group">
                    <label for="name" class="col-sm-2">Task</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="edittask" name="todo" placeholder="Enter task">
                        <span id="taskError" class="alert-message"></span>
                    </div>
                </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="updateTodo()">Save</button>
        </div>
    </div>
  </div>
<script>

    function addTodo() {
        var task = $('#task').val();
        let _url     = `api/todos/create`;

        $.ajax({
            url: _url,
            type: "POST",
            data: {
                todo: task,
            },
            success: function(data) {
                    todo = data
                    $('table tbody').append(`
                        <tr id="todo_${todo.id}">
                            <td>${todo.id}</td>
                            <td>${ todo.todo }</td>
                            <td>
                                <a data-id="${ todo.id }" onclick="editTodo(${todo.id})" class="btn btn-info">Edit</a>
                                <a data-id="${todo.id}" class="btn btn-danger" onclick="deleteTodo(${todo.id})">Delete</a>
                            </td>
                        </tr>
                    `);

                    $('#task').val('');

                    $('#addTodoModal').modal('hide');
            },
            error: function(response) {
                $('#taskError').text(response.responseJSON.errors.todo);
            }
        });
    }

    function deleteTodo(id) {
        let url = `api/todos/${id}`;

        $.ajax({
            url: url,
            type: 'DELETE',
            data: {
            },
            success: function(response) {
                $("#todo_"+id).remove();
            }
        });
    }

    function editTodo(e) {
        var id  = $(e).data("id");
        var todo  = $("#todo_"+id+" td:nth-child(2)").html();
        $("#todo_id").val(id);
        $("#edittask").val(todo);
        $('#editTodoModal').modal('show');
    }

    function updateTodo() {
        var task = $('#edittask').val();
        var id = $('#todo_id').val();
        let _url     = `api/todos/${id}`;
        let _token   = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: "PUT",
            data: {
                todo: task,
                _token: _token
            },
            success: function(data) {
                    todo = data
                    $("#todo_"+id+" td:nth-child(2)").html(todo.todo);
                    $('#todo_id').val('');
                    $('#edittask').val('');
                    $('#editTodoModal').modal('hide');
            },
            error: function(response) {
                $('#taskError').text(response.responseJSON.errors.todo);
            }
        });
    }

</script>

    
</body>
</html>