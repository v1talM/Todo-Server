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

    protected function getUserInfoByRequest(Request $request)
    {
        return $request->user();
    }

    public function getUndoByUser(Request $request)
    {
        $user = $this->getUserInfoByRequest($request);
        $undos = $this->todo->where('user_id', '=', $user->id)
            ->where('completed', '=', '0')
            ->get();
        return response()->json(['data' => $undos, 'message' => '获取数据成功']);
    }

    public function getDoingByUser(Request $request)
    {
        $user = $this->getUserInfoByRequest($request);
        $doings = $this->todo->where('user_id', '=', $user->id)
            ->where('completed', '=', '1')
            ->get();
        return response()->json(['data' => $doings, 'message' => '获取数据成功']);
    }

    public function getDidByUser(Request $request)
    {
        $user = $this->getUserInfoByRequest($request);
        $dids = $this->todo->where('user_id', '=', $user->id)
            ->where('completed', '=', '2')
            ->get();
        return response()->json(['data' => $dids, 'message' => '获取数据成功']);
    }

    public function index()
    {
        $undo = $this->todo->where('completed','0')->where('display','1')->get();
        $todo = $this->todo->where('completed','1')->where('display','1')->get();
        $done = $this->todo->where('completed','2')->where('display','1')->get();

        return response()->json(compact('undo','todo','done'));
    }

    public function addTodoByUser(Request $request)
    {
        $user = $this->getUserInfoByRequest($request);
        $title = $request->input('title');
        if($title == ''){
            return response()->json([
                'status' => 422,
                'message' => '添加Todo失败,请重试'
            ]);
        }
        try{
            $todo = $this->todo->create([
                'title' => $request->input('title'),
                'user_id' => $user->id,
                'completed' => '0'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 422,
                'message' => '添加Todo失败,请重试'
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => '添加Todo成功',
            'data' => $todo
        ]);
    }

    public function delTodoByUser(Request $request, $id)
    {
        $user = $this->getUserInfoByRequest($request);

        $todo = $this->todo->whereId($id)->first();

        if($user->id == $todo->user_id){
            try{
                $todo->delete();
            }catch (\Exception $e){
                return response()->json([
                    'status' => 422,
                    'message' => '删除失败,请重试'
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => '删除成功'
            ]);
        }
        return response()->json([
            'status' => 401,
            'message' => '删除失败'
        ]);
    }

    public function changeToUndo(Request $request, $id)
    {
        $user = $this->getUserInfoByRequest($request);

        $result = $this->todo->where('id','=',$id)->first();

        if($result->user_id !== $user->id){
            return response()->json(['message' => '修改失败,你没有权限', 'status' => 401]);
        }

        $result->update(['completed' => '0']);

        return response()->json(['message' => '修改成功', 'status' => 200]);
    }

    public function changeToDoing(Request $request, $id)
    {
        $user = $this->getUserInfoByRequest($request);

        $result = $this->todo->where('id','=',$id)->first();

        if($result->user_id !== $user->id){
            return response()->json(['message' => '修改失败,你没有权限', 'status' => 401]);
        }

        $result->update(['completed' => '1']);

        return response()->json(['message' => '修改成功', 'status' => 200]);
    }

    public function changeToDid(Request $request, $id)
    {
        $user = $this->getUserInfoByRequest($request);

        $result = $this->todo->where('id','=',$id)->first();

        if($result->user_id !== $user->id){
            return response()->json(['message' => '修改失败,你没有权限', 'status' => 401]);
        }

        $result->update(['completed' => '2']);

        return response()->json(['message' => '修改成功', 'status' => 200]);
    }

    public function destroy($id)
    {
        $this->todo->where('id','=',$id)->update(['display' => '0']);
        return response()->json('删除成功');
    }


}
