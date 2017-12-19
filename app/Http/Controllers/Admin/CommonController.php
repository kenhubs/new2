<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        $cate1 = Category::where('cate_pid',0)->get();
        $cate2Temp = Category::where('cate_uuid','ZHSQ')->first();
        $cate2 = Category::where('cate_pid',$cate2Temp->cate_id)->get();
        View::share('cate1',$cate1);
        View::share('cate2',$cate2);
    }
    //图片上传
    public function upload()
    {
        $file = Input::file('Filedata');
        if($file -> isValid()){
            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file -> move(base_path().'/uploads',$newName);
            $filepath = 'uploads/'.$newName;
            return $filepath;
        }
    }

    public function cacheClear(){
        Cache::flush();
        return response()->json(['code'=>200,'msg'=>'success']);
    }
}
