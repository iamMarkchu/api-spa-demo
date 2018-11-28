<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/11/25
 * Time: 14:17
 */

namespace App\Repositories;


use App\Tag;

class TagRepository
{

    public function create(array $data)
    {
        return Tag::create($data);
    }

    public function withUserById(int $id)
    {
        return Tag::with('user')->find($id);
    }

    public function update(array $data, $id)
    {
        $category = Tag::find($id);
        if (!$category)
            return false;
        $category->fill($data)->save();
        return $category;
    }

    public function del(int $id)
    {
        $category = Tag::find($id);
        if (!$category)
            return false;
        return $category->delete();
    }

    public function page(int $pageSize)
    {
        return Tag::with('user')->paginate($pageSize);
    }

    public function all()
    {
        return Tag::orderBy('order')->get();
    }
}