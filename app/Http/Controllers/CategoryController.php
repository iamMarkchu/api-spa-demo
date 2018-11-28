<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $category;

    public function __construct(CategoryRepository $category)
    {

        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->api($this->category->page($request->input('pageSize', 15)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = [
            'name' => $request->input('name'),
            'order' => $request->input('order'),
            'status' => true,
            'user_id' => Auth::id(),
        ];
        return response()->api($this->category->create($data), '保存类别');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->api($this->category->withUserById($id), '获取类别');
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
        return response()->api($this->category->update($request->all(), $id), '更新类别');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->api($this->category->del($id), '删除类别');
    }

    public function all()
    {
        return response()->api($this->category->all(), '获取所有类别');
    }
}
