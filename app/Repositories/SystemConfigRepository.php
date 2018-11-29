<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/11/29
 * Time: 21:53
 */

namespace App\Repositories;


use App\SystemConfig;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Boolean;

class SystemConfigRepository
{

    public function create(array $data)
    {
        return SystemConfig::create($data);
    }

    public function byId(int $id)
    {
        return SystemConfig::find($id);
    }

    public function update(array $data, int $id)
    {
        $config = SystemConfig::find($id);
        if (!$config)
            return false;
        return $config->fill($data)->save() ? $config: false;
    }

    public function del(int $id)
    {
        $config = SystemConfig::find($id);
        if (!$config)
            return false;
        return $config->delete();
    }

    public function page(int $pageSize)
    {
        return SystemConfig::with('user')->orderBy('created_at', 'desc')->paginate($pageSize);
    }

    public function all()
    {
        return SystemConfig::all();
    }
}