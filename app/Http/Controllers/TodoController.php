<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoCheckRequest;
use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todo;
    /**
     * TodoController constructor.
     */
    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function index()
    {
        $undo = $this->todo->where('completed','0')->where('display','1')->get();
        $todo = $this->todo->where('completed','1')->where('display','1')->get();
        $done = $this->todo->where('completed','2')->where('display','1')->get();

        return response()->json(compact('undo','todo','done'));
    }

    public function store(TodoCheckRequest $request)
    {
        $todo = $request->all();
        $result = $this->todo->create($todo);
        return response()->json($result);
    }

    public function changeToDoing($id)
    {
        $result = $this->todo->where('id','=',$id)->first();
        $result->update(['completed' => '1']);
        return response()->json($result);
    }

    public function changeToDone($id)
    {
        $result = $this->todo->where('id','=',$id)->first();
        $result->update(['completed' => '2']);
        return response()->json($result);
    }

    public function destroy($id)
    {
        $this->todo->where('id','=',$id)->update(['display' => '0']);
        return response()->json('删除成功');
    }

}
