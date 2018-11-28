<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/11/25
 * Time: 13:39
 */

namespace App\Repositories;


use App\Category;

class CategoryRepository
{
    public function create(array $data)
    {
        return Category::create($data);
    }

    public function withUserById(int $id)
    {
        return Category::with('user')->find($id);
    }

    public function update(array $data, $id)
    {
        $category = Category::find($id);
        if (!$category)
            return false;
        $category->fill($data)->save();
        return $category;
    }

    public function del(int $id)
    {
        $category = Category::find($id);
        if (!$category)
            return false;
        return $category->delete();
    }

    public function page(int $pageSize)
    {
        return Category::with('user')->paginate($pageSize);
    }

    public function all()
    {
        return Category::orderBy('order')->get();
    }
}