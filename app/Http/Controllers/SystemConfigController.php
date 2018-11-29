<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSystemConfigRequest;
use App\Http\Requests\UpdateSystemConfigRequest;
use App\Repositories\SystemConfigRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemConfigController extends Controller
{

    /**
     * @var SystemConfigRepository
     */
    private $systemConfig;

    public function __construct(SystemConfigRepository $systemConfig)
    {
        $this->systemConfig = $systemConfig;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->api($this->systemConfig->page($request->input('pageSize', 50)), '配置项列表');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSystemConfigRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSystemConfigRequest $request)
    {
        $data = [
            'name' => $request->input('name'),
            'value' => $request->input('value'),
            'short_desc' => $request->input('short_desc'),
            'user_id' => Auth::id()  //todo 替换 auth()->id
        ];
        return response()->api($this->systemConfig->create($data), '保存系统配置');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->api($this->systemConfig->byId($id), '通过id获取配置');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSystemConfigRequest $request, $id)
    {
        $data = [
            'name' => $request->input('name'),
            'value' => $request->input('value'),
            'short_desc' => $request->input('short_desc'),
        ];
        return response()->api($this->systemConfig->update($data, $id), '更新配置');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->api($this->systemConfig->del($id), '删除配置');
    }

    public function all()
    {
        return response()->api($this->systemConfig->all(), '获取所有配置');
    }
}
