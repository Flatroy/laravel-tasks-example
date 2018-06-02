@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="card mb-4">
                <div class="card-header">
                    New Task
                </div>

                <div class="card-body">
                    <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Task Form -->
                    <form action="{{ url('task') }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="control-label">Name:</label>
                            <div class="form-group">
                                <input type="text" name="name" id="task-name" class="form-control"
                                       value="{{ old('task') }}">
                            </div>
                            <label for="task-name" class="control-label">Description:</label>

                            <div class="form-group">
                                <textarea type="text" name="description" id="task-name"
                                          class="form-control">{{ old('task') }}</textarea>
                            </div>
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fa fa-btn fa-plus"></i> Add Task
                                </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Tasks -->
            @if (count($tasks) > 0)
                <div class="card">
                    <div class="card-header">
                        Current Tasks
                    </div>

                    <div class="card-body">
                        <table class="table table-striped task-table">
                            <thead>
                            <th>Task</th>
                            <th>&nbsp;</th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="table-text">
                                        <div>{{ $task->name }}</div>
                                    </td>

                                    <!-- Task Delete Button -->
                                    <td>
                                        <form action="{{url('task/' . $task->id)}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" id="delete-task-{{ $task->id }}"
                                                    class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection