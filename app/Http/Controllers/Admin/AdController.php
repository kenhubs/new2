<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Model\Ad;
use App\Http\Model\Category;
class AdController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Ad::orderBy('ad_id','desc')->paginate(10);
        $cate = [];
        $cateAll = Category::all();
        foreach($cateAll as $v){
            $cate[$v->cate_id] = $v->cate_name;
        }
        //dd($cate,$data);
        return view('admin.ad.index',compact('data','cate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = (new Category)->tree();
        return view('admin.ad.add',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $input = Input::except('_token','file');
        if($input['ad_type']==1){
            $input['ad_cate_id']=0;
            $input['ad_position']=0;
        }else{
            if($input['ad_position']!=2) $input['ad_cate_id']=0;
        }
        $input['ad_created'] = time();
        Ad::create($input);
        return redirect('admin/ad');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ad_id)
    {
        $field = Ad::find($ad_id);
        $cate = (new Category)->tree();
        return view('admin.ad.edit',compact('field','cate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($ad_id)
    {
        $input = Input::except('_token','_method','file');
        if($input['ad_type']==1){
            $input['ad_cate_id']=0;
            $input['ad_position']=0;
        }else{
            if($input['ad_position']!=2) $input['ad_cate_id']=0;
        }
        $re = Ad::where('ad_id',$ad_id)->update($input);
        if($re){
            return redirect('admin/ad');
        }else{
            return back()->with('errors','广告更新失败，请稍后重试！');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ad_id)
    {
        $re = Ad::where('ad_id',$ad_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '广告删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '广告删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
}
