<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Like;
use App\Models\Target;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Idea;
use App\Models\PrivateCategory;
use App\Models\PublicCategory;
use App\Models\Book;
use App\Models\Task;
use App\Models\BookExplanation;
use App\Models\TaskExplanation;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        // dd($request->user_id);
        $likes = new Like;
        $form  = $request->all();
        $likes->fill($form);
        // $likes->user_id = Auth::user()->id;
        
        $likes->save();
        // CSRFトークンを再生成して、二重送信対策
        $request->session()->regenerateToken();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
