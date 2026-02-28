<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PrivateCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PrivateCategoryController extends Controller
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
        $auth_id = Auth::id();
        $request->validate([
            'category' => [
                'required',
                'max:50',
                \Illuminate\Validation\Rule::unique('private_categories', 'category')->where('user_id', $auth_id),
            ],
        ]);
        $private_categories = new PrivateCategory;
        $form  = $request->all();
        $private_categories->fill($form);
        $private_categories->user_id = $auth_id;
        $private_categories->save();
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
        $auth_id = Auth::id();
        $request->validate([
            'category' => [
                'required',
                'max:50',
                \Illuminate\Validation\Rule::unique('private_categories', 'category')->where('user_id', $auth_id)->ignore($id),
            ],
        ]);
        $private_category = PrivateCategory::where('id', $id)->where('user_id', $auth_id)->firstOrFail();
        $private_category->category = $request->category;
        $private_category->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $private_category = PrivateCategory::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $private_category->delete();
        return back();
    }
}
