<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/11/25
 * Time: 18:44
 */

namespace App\Repositories;


use App\Article;
use App\Category;
use App\Helpers\MarkdownHelper;
use App\Tag;
use Qiniu\Auth;

class ArticleRepository
{

    public function create(array $data)
    {
        if ($article = Article::create($data)) {
            if ($data['tags'])
                $article->tags()->sync($this->storeNonExistentTags($data['tags']));
            if ($data['categories'])
                $article->categories()->sync($this->storeNonExistentCategories($data['categories']));
            return $article;
        }

        return false;
    }

    public function storeNonExistentTags($tags)
    {
        return collect($tags)->map(function ($tag) {
            if (is_numeric($tag))
                return $tag;
            else {
                return Tag::create([
                    'name' => $tag,
                    'order' => 20,
                    'status' => 1,
                    'user_id' => Auth()->id(),
                ])->id;
            }
        });
    }

    public function storeNonExistentCategories($categories)
    {
        return collect($categories)->map(function ($category) {
            if (is_numeric($category))
                return $category;
            else {
                return Category::create([
                    'name' => $category,
                    'order' => 20,
                    'status' => 1,
                    'user_id' => Auth()->id(),
                ])->id;
            }
        });
    }

    public function byId(int $id)
    {
        $article = Article::with(['tags', 'categories', 'user'])->find($id);
        $article->menus = (new MarkdownHelper())->generateMenus($article->content);
        return $article;
    }

    public function update(array $data, int $id)
    {
        $article = Article::find($id);
        if (!$article)
            return false;

        if ($article->fill($data)->save()) {
            if ($data['tags'])
                $article->tags()->sync($data['tags']);
            if ($data['categories'])
                $article->categories()->sync($data['categories']);
            return $article;
        }
        return false;
    }

    public function del(int $id)
    {
        $article = Article::find($id);
        if (!$article)
            return false;
        $article->status = Article::STATUS_DELETED;
        if ($article->save()) {
            // $article->tags()->detach();
            // $article->categories()->detach();
            return true;
        }
        return false;
    }

    public function pub($id)
    {
        $article = Article::find($id);
        if (!$article)
            return false;
        $article->status = Article::STATUS_OK;

        if ($article->save()) {
            // $article->tags()->detach();
            // $article->categories()->detach();
            return true;
        }
        return false;
    }

    public function rev($id)
    {
        $article = Article::find($id);
        if (!$article)
            return false;
        $article->status = Article::STATUS_REPUBLISH;

        if ($article->save()) {
            // $article->tags()->detach();
            // $article->categories()->detach();
            return true;
        }
        return false;
    }

    public function page($map, $pageSize)
    {
        return Article::with(['user', 'tags', 'categories'])->filter($map)->orderBy('updated_at', 'desc')->paginate($pageSize);
    }
}