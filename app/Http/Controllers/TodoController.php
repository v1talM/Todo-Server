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
        $undo = $this->todo->where('completed','0')->get();
        $todo = $this->todo->where('completed','1')->get();
        $done = $this->todo->where('completed','2')->get();

        return response()->json(compact('undo','todo','done'));
    }

    public function store(TodoCheckRequest $request)
    {
        $todo = $request->all();

    }

}
