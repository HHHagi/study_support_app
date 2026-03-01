<?php

namespace App\Http\Controllers;

use App\Models\TaskExplanation;
use App\Models\Task;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskExplanationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:2000',
        ]);
        $task_explanations = new TaskExplanation;
        $task = Task::findOrFail($request->task_id);
        $task->is_done  = '1';
        $form  = $request->all();
        $task_explanations->fill($form);
        $task_explanations->save();
        $task->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|max:2000',
        ]);
        $task_explanation = TaskExplanation::findOrFail($id);
        Target::where('id', $task_explanation->target_id)->where('user_id', Auth::id())->firstOrFail();
        $form  = $request->all();
        $task_explanation->update($form);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $task_explanation = TaskExplanation::findOrFail($id);
        Target::where('id', $task_explanation->target_id)->where('user_id', Auth::id())->firstOrFail();
        $task_id = $task_explanation->task_id;
        $task_explanation->delete();

        // TaskExplanationが0件になったらTaskのis_doneを'2'にリセット
        if (TaskExplanation::where('task_id', $task_id)->count() === 0) {
            $task = Task::find($task_id);
            if ($task) {
                $task->is_done = '2';
                $task->save();
            }
        }

        return back();
    }
}
