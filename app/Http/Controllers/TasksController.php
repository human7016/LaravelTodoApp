<?php

namespace App\Http\Controllers;

// ★ Authクラスをインポートする
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;

class TasksController extends Controller
{
    public function index(Folder $folder)
    { 
        if (Auth::user()->id !== $folder->user_id) {
            abort(403);
        }
        // ★ ユーザーのフォルダを取得する
        $folders = Auth::user()->folders()->get();

        // 選ばれたフォルダに紐づくタスクを取得する
        $tasks = $folder->tasks()->get(); // ★

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);
    }

    /**
    * GET /folders/{id}/tasks/create
    */
    public function showCreateForm(Folder $folder)
    {
        return view('tasks/create', [
            'folder' => $folder->id
        ]);
    }

    public function create(CreateTask $request, Folder $folder)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'folder' => $folder
        ]);
    }

    /**
    * GET /folders/{id}/tasks/{task_id}/edit
    */
    public function showEditForm(Folder $folder, Task $task)
    {
        return view('tasks/edit', [
            'task' => $task,
            'folder' => $folder,
        ]);
    }

    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index', [
            'folder' => $folder,
        ]);
    }
}