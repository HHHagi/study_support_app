<?php

namespace App\Http\Controllers;

use App\Models\BookExplanation;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookExplanationController extends Controller
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
        $book_explanations = new BookExplanation;
        $form  = $request->all();
        $book_explanations->fill($form);
        $book_explanations->save();
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
        $book_explanation = BookExplanation::findOrFail($id);
        Target::where('id', $book_explanation->target_id)->where('user_id', Auth::id())->firstOrFail();
        $form  = $request->all();
        $book_explanation->update($form);
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
        $book_explanation = BookExplanation::findOrFail($id);
        Target::where('id', $book_explanation->target_id)->where('user_id', Auth::id())->firstOrFail();
        $book_explanation->delete();
        return back();
    }
}
