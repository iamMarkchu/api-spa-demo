<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * @var ArticleRepository
     */
    private $article;

    /**
     * ArticleController constructor.
     * @param ArticleRepository $article
     */
    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->api($this->article->page($request->all(), $request->input('pageSize', 15)), '文章列表');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $data = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'cover' => $request->input('cover', ' '),
            'order' => $request->input('order'),
            'tags' => $request->input('tags'),
            'categories' => $request->input('categories'),
            'status' => $request->input('status', Article::STATUS_REPUBLISH),
            'user_id' => Auth::id()
        ];
        return response()->api($this->article->create($data), '保存文章');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->api($this->article->byId($id), '获取文章');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, $id)
    {
        $data = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'cover' => $request->input('cover', ' '),
            'order' => $request->input('order'),
            'tags' => $request->input('tags'),
            'categories' => $request->input('categories'),
        ];
        return response()->api($this->article->update($data, $id), '修改文章');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->api($this->article->del($id), '删除文章');
    }

    public function publish($id)
    {
        return response()->api($this->article->pub($id), '发布文章');
    }

    public function revoke($id)
    {
        return response()->api($this->article->rev($id), '撤销发布文章');
    }
}
