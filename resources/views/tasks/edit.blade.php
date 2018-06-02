@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-8 col-md-6 mx-auto">
            <div class="card mb-4">
                <div class="card-header d-inline-flex align-items-center justify-content-between">
                    <div>Edit Task</div>
                    <div class="badge badge-success">
                        @if($task->is_done)
                            Completed
                        @else
                            Not completed
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    {{--@include('common.errors')--}}

                    <form action="{{ route('task.save', ['id'=>$task->id]) }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="task-name" class="control-label">Title:</label>
                            <div class="form-group">
                                <input type="text" name="name" id="task-name"
                                       class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       value="{{ old('name') ? old('name') : $task->name }}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="task-description" class="control-label">Description:</label>
                                <textarea type="text" name="description" id="task-description"
                                          class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">{{ old('description') ? old('description') : $task->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div>Added by: {{ date('d/m/Y h:i:s', strtotime($task->created_at)) }}</div>
                            @if($task->finished_at)
                                <div>Finished by: {{ date('d/m/Y h:i:s', strtotime($task->finished_at)) }}</div>
                            @endif
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa fa-btn fa-edit"></i> Update Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection