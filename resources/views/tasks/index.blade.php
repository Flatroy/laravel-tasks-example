@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-8 col-md-6 mx-auto">
            <div class="card mb-4">
                <div class="card-header">
                    New Task
                </div>

                <div class="card-body">
                    {{--                @include('common.errors')--}}
                    <form action="{{ url('task') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="task-name" class="control-label">Title:</label>
                            <input type="text" name="name" id="task-name"
                                   class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="task-description" class="control-label">Description:</label>
                            <textarea type="text" name="description" id="task-description"
                                      class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa fa-btn fa-plus"></i> Add Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Tasks -->
            @if (count($tasks) > 0)
                <h2>Your tasks:</h2>
                {{--<div class="card">--}}
                {{--<div class="card-header">--}}
                {{--Current Tasks--}}
                {{--</div>--}}

                {{--<div class="card-body">--}}
                {{--@foreach ($tasks as $task)--}}
                {{--<one-task :task="{{ $task }}"></one-task>--}}
                {{--@endforeach--}}
                {{--</div>--}}
                {{--</div>--}}

                @foreach ($tasks as $task)
                    <one-task :task="{{ $task }}"></one-task>
                @endforeach
            @endif
        </div>
    </div>
@endsection