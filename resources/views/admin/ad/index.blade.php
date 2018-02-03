@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 广告管理 &raquo; 列表
</div>
<!--面包屑导航 结束-->

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_title">
            <h3>广告列表</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/ad/create')}}"><i class="fa fa-plus"></i>添加广告</a>
                <a href="{{url('admin/ad')}}"><i class="fa fa-recycle"></i>全部广告</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc">ID</th>
                    <th>标题</th>
                    <th>广告</th>
                    <th>投放区域</th>
                    <th>发布时间</th>
                    <th>操作</th>
                </tr>
                @foreach($data as $v)
                <tr>
                    <td class="tc">{{$v->ad_id}}</td>
                    <td>
                        <a href="#">{{$v->ad_title}}</a>
                    </td>
                    @if($v->ad_type == 1)
                        <td>{{$v->ad_text}}</td>
                        <td>----</td>
                    @else
                        <td>
                            @foreach(explode(',',$v->ad_img) as $vv)
                                <img alt="" style="max-width: 350px; max-height:100px;" src="{{url($vv)}}">
                            @endforeach
                        </td>
                        <td>
                            <a href="#">{{$v->ad_position == 0 ? '启动页':($v->ad_position == 1 ?'轮播': $cate[$v->ad_cate_id])}}</a>
                        </td>
                    @endif
                    <td>{{date('Y-m-d H:i:s',$v->ad_created)}}</td>
                    <td>
                        <a href="{{url('admin/ad/'.$v->ad_id.'/edit')}}">修改</a>
                        <a href="javascript:;" onclick="delArt({{$v->ad_id}})">删除</a>
                    </td>
                </tr>
                @endforeach
            </table>

            <div class="page_list">
                {{$data->links()}}
            </div>
        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->

<style>
    .result_content ul li span {
        font-size: 15px;
        padding: 6px 12px;
    }
</style>

<script>
    //删除分类
    function delArt(ad_id) {
        layer.confirm('您确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('admin/ad')}}/"+ad_id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                if(data.status==0){
                    layer.msg(data.msg, {icon: 6});
                    location.href = location.href;
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            });
        }, function(){

        });
    }
</script>

@endsection
