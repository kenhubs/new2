<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use App\Http\Model\Category;
use App\Http\Model\Article;
use App\Http\Model\Ad;

class ApiController extends Controller
{
    //社区公告
    public function noticeList(){
        $page = Input::get('page') ? Input::get('page') : 1;
        $res = Cache::remember('api_notice_page_'.$page, 120, function() {
            return $this->artListHandle('SQGG',['id','title','thumb','time']);
        });
        return response()->json($res);
    }
    public function noticeDetail($id){
        return response()->json($this->getArtDetail($id,['id','title','thumb','content']));
    }
    //社区新闻
    public function newsList(){
        $page = Input::get('page') ? Input::get('page') : 1;
        $res = Cache::remember('api_news_page_'.$page, 120, function() {
            return $this->artListHandle('SQXW',['id','title','thumb','time']);
        });
        return response()->json($res);
    }
    public function newsDetail($id){
        return response()->json($this->getArtDetail($id,['id','title','editor','thumb','content']));
    }
    //社区文萃
    public function cultureList(){
        $page = Input::get('page') ? Input::get('page') : 1;
        $res = Cache::remember('api_culture_page_'.$page, 120, function() {
            return $this->artListHandle('SQWC',['id','title','editor','area','thumb','time']);
        });
        return response()->json($res);
    }
    public function cultureDetail($id){
        return response()->json($this->getArtDetail($id,['id','title','editor','area','thumb','content','time']));
    }

    //社区百科
    public function baikeList(){
        $page = Input::get('page') ? Input::get('page') : 1;
        $res = Cache::remember('api_baike_page_'.$page, 120, function() {
            return $this->artListHandle('SQBK',['id','title','time']);
        });
        return response()->json($res);
    }
    public function baikeDetail($id){
        return response()->json($this->getArtDetail($id,['id','title','thumb','content','time']));
    }

    //社区便民
    public function convenienceList(){
        $page = Input::get('page') ? Input::get('page') : 1;
        $res = Cache::remember('api_convenience_page_'.$page, 120, function() {
            return $this->artListHandle('SQXW',['id','title','time']);
        });
        return response()->json($res);
    }
    public function convenienceDetail($id){
        return response()->json($this->getArtDetail($id,['id','title','thumb','content','time']));
    }

    //智慧商圈 分类列表
    public function businessSub(){
        $res = Cache::remember('api_business_list', 120, function() {
            $data = [];
            $cate_id = Category::where('cate_uuid','ZHSQ')->first()->cate_id;
            $subs = Category::where('cate_pid',$cate_id)->get();
            foreach($subs as $v){
                $data[] = [
                    'id' => $v->cate_id,
                    'name'=>$v->cate_name,
                    'icon'=>$v->cate_icon
                ];
            }
            return $data;
        });
        return response()->json($res);
    }
    public function businessSubList($id){
        $page = Input::get('page') ? Input::get('page') : 1;
        $res = Cache::remember('api_business_'.$id.'_page_'.$page, 120, function() use($id) {
            $cate_uuid = Category::find($id)->cate_uuid;
            return $this->artListHandle($cate_uuid,['id','title','thumb','address','phone','time']);
        });
        return response()->json($res);
    }
    public function businessSubDetail($id){
        return response()->json($this->getArtDetail($id,['id','title','thumb','address','phone','content','time']));
    }

    //广告
    public function adText(){
        return response()->json($this->adHandle(1,2,['id','title','text']));
    }
    public function adLunbo(){
        return response()->json($this->adHandle(2,1,['id','title','img']));
    }
    public function adList(){
        return response()->json($this->adHandle(2,2,['id','title','img']));
    }



    //============================

    public function artListHandle($cate_uuid,$need_fields){
        $data = [];
        $cate_id = Category::where('cate_uuid',$cate_uuid)->first()->cate_id;
        $art = Article::orderBy('art_id','desc')->where('cate_id',$cate_id)->paginate(10);
        if($art){
            foreach($art as $v){
                $temp = [];
                foreach($need_fields as $vv){
                    $key = 'art_'.$vv;
                    $temp[$vv] = $vv == 'time' ? date('Y-m-d',$v->$key) : $v->$key;
                }
                $data[] = $temp;
            }
        }
        return $data;
    }
    public function getArtDetail($art_id,$need_fields){
        $res = Cache::remember('api_detail_'.$art_id, 120, function() use($art_id,$need_fields){
            $data = [];
            $art = Article::find($art_id);
            if($art){
                foreach($need_fields as $v){
                    $key = 'art_'.$v;
                    $data[$v] = $v == 'time' ? date('Y-m-d',$art->$key) : $art->$key;
                }
            }
            return $data;
        });
        return $res;
    }
    public function adHandle($ad_type,$position,$need_fields){
        $res = Cache::remember('api_ad_'.$ad_type.'_'.$position, 120, function() use($ad_type,$position,$need_fields){
            $data = [];
            $ads = Ad::orderBy('ad_id','desc')->where('ad_type',$ad_type)->where('ad_position',$position)->get();
            //dd($ads);
            if($ads){
                foreach($ads as $v){
                    $temp = [];
                    foreach($need_fields as $vv){
                        $key = 'ad_'.$vv;

                        $temp[$vv] = $vv == 'time' ? date('Y-m-d',$v->$key) : $v->$key;
                    }
                    $data[] = $temp;
                }
            }
            return $data;
        });
        return $res;
    }
}
