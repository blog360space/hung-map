<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\AbstractAdminController;

use App\Task;
use App\Repositories\TaskRepository;
use App\Repositories\TodoRepository;

class AdminTaskController extends AbstractAdminController
{
    /**
     * The task repository instance.
     * 
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * 
     */
    protected $todo;


    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @param TodoRepository $todo
     * @return void
     */
    public function __construct(TaskRepository $tasks, TodoRepository $todo)
    {
        parent::__construct();

        $this->tasks = $tasks;
        $this->todo = $todo;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {        
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/admin/tasks');
    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/admin/tasks');
    }
}
