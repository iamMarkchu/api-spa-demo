<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Repositories\TagRepository;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{

    /**
     * @var TagRepository
     */
    private $tag;

    public function __construct(TagRepository $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTagRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request)
    {
        $data = [
            'name' => $request->input('name'),
            'order' => $request->input('order'),
            'status' => true,
            'user_id' => Auth::id()
        ];
        return response()->api($this->tag->create($data), '保存标签');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->api($this->tag->withUserById($id), '获取标签');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response()->api($this->tag->update($request->all(), $id), '修改标签');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->api($this->tag->del($id), '删除标签');
    }

    /**
     * 获取所有标签
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->api($this->tag->all(), '获取所有标签');
    }
}
