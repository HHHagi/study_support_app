<?php

namespace App\Http\Controllers;

use App\Models\TaskExplanation;
use App\Models\Task;
use Illuminate\Http\Request;

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
        $task_explanations = new TaskExplanation;
        $task = Task::find($request->task_id);
        $task->is_done  = '1'; 
        $form  = $request->all();
        $task_explanations->fill($form);
        $task_explanations->save();
        $task->update();
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
        $task_explanation = TaskExplanation::find($id);
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
    public function destroy($task_explanation_id, Request $request)
    {
        $task_explanation = TaskExplanation::find($task_explanation_id);
        $task_explanation->delete();
        // taskexplanationがゼロになったら、taskのis_doneをゼロにする処理をかく
        $task_id = $request->task_id;
        $task_explanation =  TaskExplanation::find($task_id);
        if(!$task_explanation){
            $task = Task::find($task_id);
            $task->is_done  = '1';
            $task->update();
        }
        return back();
    }
}
