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
use App\Models\Book;
use App\Models\Task;
use App\Models\BookExplanation;
use App\Models\TaskExplanation;
use Illuminate\Support\Facades\DB;

class OurTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $users = User::all();
        $PAGE_NUMBER = 5;
        $public_categories = PublicCategory::all();
        // dd($request->public_category_id);
        if ($request->public_category_id) {
            if ($request->public_category_id == 1) {
                $targets = Target::where('is_private', "1")->with('likes')->orderBy('id', 'desc')->paginate($PAGE_NUMBER, ['*'], 'targetPage');
        $request->session()->regenerateToken();
                return view('contents_views.our_targets', compact('user_id', 'users', 'targets', 'public_categories'));
            }
            $targets = Target::where('is_private', "1")->with('likes')->where('public_category_id', $request->public_category_id)->orderBy('id', 'desc')->paginate($PAGE_NUMBER, ['*'], 'targetPage');
        $request->session()->regenerateToken();
            return view('contents_views.our_targets', compact('user_id', 'users', 'targets', 'public_categories'));
        }
        $targets = Target::where('is_private', "1")->with('likes')->orderBy('id', 'desc')->paginate($PAGE_NUMBER, ['*'], 'targetPage');
        return view('contents_views.our_targets', compact('user_id', 'users', 'targets', 'public_categories'));
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
        DB::beginTransaction();
        try {
            $target = new Target;
            $target->user_id = Auth::user()->id;
            $target->title = $request->title;
            $target->public_category_id = $request->public_category_id;
            $target->private_category_id = $request->private_category_id;
            $target->limit = $request->limit;
            $target->is_done = $request->is_done;
            $target->is_private = $request->is_private;

            $target->save();
            $last_insert_target_id = $target->id;

            $books = Book::where('target_id', $request->target_id)->get();
            $tasks = Task::where('target_id', $request->target_id)->get();
            foreach ($books as $book) {
                $data = [
                    'target_id' => $last_insert_target_id,
                    'title' => $book->title,
                    'first_knowledge' => $request->first_knowledge,
                    'priority' => '2',
                    'is_done' => '2',
                    'private_category_id' => $request->private_category_id,
                ];
                $book = Book::insert($data);
            }
            foreach ($tasks as $task) {
                $data = [
                    'target_id' => $last_insert_target_id,
                    'title' => $task->title,
                    'first_knowledge' => $request->first_knowledge,
                    'priority' => '2',
                    'is_done' => '2',
                    'private_category_id' => $request->private_category_id,
                ];
                $task = Task::insert($data);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput();
        }
        DB::commit();
        // CSRFトークンを再生成して、二重送信対策
        $request->session()->regenerateToken();
        return redirect('/our_targets');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $target = Target::find($id);
        $private_categories = PrivateCategory::where('user_id', $user_id)->get();
        $PAGE_NUMBER = 2;
        $books = Book::where('target_id', $id)->orderBy('id', 'desc')->paginate($PAGE_NUMBER, ['*'], 'bookPage')->appends(["taskPage" => $request->input('taskPage')]);
        $tasks = Task::where('target_id', $id)->orderBy('id', 'desc')->paginate($PAGE_NUMBER, ['*'], 'taskPage')->appends(["bookPage" => $request->input('bookPage')]);
        return view('/contents_views.our_targets_show', compact('user_id', 'target', 'books', 'tasks', 'private_categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $users = User::all();
        $PAGE_NUMBER = 5;
        $public_categories = PublicCategory::all();
        $target_title = $request->target_title;

        $targets = Target::where('is_private', "1")->where('title', 'LIKE', "%$target_title%")->with('likes')->paginate($PAGE_NUMBER, ['*'], 'targetPage');
        return view('contents_views.our_targets', compact('user_id', 'users', 'targets', 'public_categories'));
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
