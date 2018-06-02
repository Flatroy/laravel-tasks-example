<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');
        $this->tasks = $tasks;
    }

    public function index(Request $request)
    {
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }

    public function view(Request $request, Task $task)
    {
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    public function save(Request $request, Task $task)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|max:65535',
        ]);

        $task->name = $request->name;
        $task->description = $request->description;
        $task->save();
        return redirect('/tasks/');
    }

    /**
     * Create a new task.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|max:65535',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect('/tasks');
    }

    /**
     * Destroy the given task.
     *
     * @param  Request $request
     * @param  Task $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);
        $task->delete();
        return [
            'status' => 'ok'
        ];
    }

    /**
     * Change statis for the given task.
     *
     * @param  Request $request
     * @param  Task $task
     * @return Response
     */
    public function changeStatus(Request $request, Task $task)
    {
        $old = $task->is_done;
        if ($task->is_done) {
            $task->finished_at = null;
            $task->is_done = false;
        } else {
            $task->finished_at = now();
            $task->is_done = true;
        }
        // $task->is_done = !$task->is_done;

        $task->save();
        return [
            'status' => 'ok',
            'task' => $task,
            'is_done' => $task->is_done,
            'old' => $old
        ];
    }
}
