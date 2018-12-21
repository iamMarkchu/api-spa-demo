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

    /**
     * 创建标签
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return Tag::create($data);
    }

    /**
     * 获取标签
     * @param int $id
     * @return Tag|null
     */
    public function withUserById(int $id)
    {
        return Tag::with('user')->find($id);
    }

    /**
     * 更新标签
     * @param array $data
     * @param $id
     * @return bool
     */
    public function update(array $data, $id)
    {
        $category = Tag::find($id);
        if (!$category)
            return false;
        $category->fill($data)->save();
        return $category;
    }

    /**
     * 删除标签
     * @param int $id
     * @return bool
     */
    public function del(int $id)
    {
        $category = Tag::find($id);
        if (!$category)
            return false;
        return $category->delete();
    }

    /**
     * 分页获取标签
     * @param int $pageSize
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function page(int $pageSize)
    {
        return Tag::with('user')->paginate($pageSize);
    }

    /**
     * 获取所有标签
     * @return Tag[]
     */
    public function all()
    {
        return Tag::orderBy('order')->get();
    }
}
