<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use App\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Folder $folder)
    {
        //ユーザのフォルダを取得
        $folders = Auth::user()->folders()->get();

        //選んだフォルダについてのタスクを取得する
        $tasks = $folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);
    }

    public function showCreateForm(Folder $folder)
    {
        return view('tasks/create', [
            'folder_id' =>$folder->id,
        ]);
    }

    public function create(Folder $folder, CreateTask $request)
    {

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_data;

        $folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id'=>$folder->id,
        ]);
    }

    public function showEditForm(Folder $folder, Task $task)
    {
        return view('tasks/edit', [
            'task' => $task,
        ]);
    }
    //

    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        

        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index',[
            'id'=>$task->folder_id,
        ]);
    }

    private function checRelation(Folder $folder, Task $task)
    {
        if ($folder->id !==$task->folder_id)
        {
            abort(404);
        }
    }
}
