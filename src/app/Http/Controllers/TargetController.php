<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTargetRequest;
use App\Http\Requests\UpdateTargetRequest;
use App\Http\Requests\StoreUpdateMemoRequest;

use App\Models\Target;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Idea;
use App\Models\PrivateCategory;
use App\Models\PublicCategory;

class TargetController extends Controller
{
    // ログインしてなければログイン画面へ飛ばす
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $targets = Target::all();
        $users = User::all();
        $ideas = Idea::all();
        $private_categories= PrivateCategory::all();
        $public_categories= PublicCategory::all();
        return view('contents_views.targets', compact('targets', 'users', 'ideas', 'private_categories', 'public_categories'));
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
    public function store(StoreTargetRequest $request)
    {
        $targets = new Target;
        $form  = $request->all();
        $targets->fill($form);
        $targets->user_id = Auth::user()->id;
        $targets->save();
        return redirect('/targets');
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
        $target = Target::find($id);
        $private_categories= PrivateCategory::all();
        $ideas = Idea::all();
        return view('contents_views.target_edit', compact('target', 'private_categories', 'ideas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTargetRequest $request, $id)
    {
        $target = Target::find($id);
        $form  = $request->all();
        $target->update($form);
        return redirect('/targets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $target = Target::find($id);
        $target->delete();
        return redirect('/targets');
    }
}
