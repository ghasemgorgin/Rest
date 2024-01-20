<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\TaskCollection;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function index()
    {
         $tasks=DB::for(Task::class)
            ->allowedFilters('is done')
            ->defaultSort('-created_at')
            ->allowedSorts(['title','is done','created_at'])
            ->paginate();
        return new TaskCollection(Task::all());
    }


    public function show(Request $request, Task $task)
    {
        return new TaskResource($task);
    }



    public function store(StoreTaskRequest $request)
    {

        $validate = $request->validated();

        // $task = Task::create($validate);
        $task=Auth::user()->tasks()->create($validate);
        return new TaskResource($task);
    }
    public function update(UpdateTaskRequest $request,Task $task){
        $validate=$request->validated();

        $task->update($validate);

        return new TaskResource($task);

    }
    public function destroy(Request $request, Task $task){
        
         $task->delete();
        
        return response()->noContent();
    }
}
