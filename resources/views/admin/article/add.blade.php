@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
{{--<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 文章管理
</div>--}}
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>添加文章</h3>
        @if(count($errors)>0)
            <div class="mark">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                @else
                    <p>{{$errors}}</p>
                @endif
            </div>
        @endif
    </div>
    {{--<div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
            <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
        </div>
    </div>--}}
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap" id="vuee">
    <form action="{{url('admin/article')}}" method="post">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120">分类：</th>
                <td>
                    <select name="cate_id">
                        @foreach($data as $d)
                        <option value="{{$d->cate_id}}"
                                @if($d->cate_id==$cate_id) selected @endif
                        >{{$d->_cate_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i> 文章标题：</th>
                <td>
                    <input type="text" class="lg" name="art_title">
                </td>
            </tr>
            <tr>
                <th>作者：</th>
                <td>
                    <input type="text" class="sm" name="art_editor">
                </td>
            </tr>
            <tr>
                <th>缩略图：</th>
                <td>
                    <div id="art_thumb">
                        <div class="show-art_thumb">

                        </div>
                        <div id="picker-art_thumb" class="wu-example">

                        </div>
                        <div class="progress" style="display: none;width: 300px;">
                            <div class="progress-bar progress-bar-striped active" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="max-width: 100%;height: 5px;">
                            </div>
                        </div>
                        <input type="hidden" readonly class="lg inputMap-art_thumb pub-hide" name="art_thumb" value=""/>
                    </div>
                </td>
            </tr>
            <tr>
                <th>[选填] 小区：</th>
                <td>
                    <input type="text" class="lg" name="art_area" value="" placeholder="根据实际情况选填">
                </td>
            </tr>
            <tr>
                <th>[选填] 电话：</th>
                <td>
                    <input type="text" class="lg" name="art_phone" value="" placeholder="根据实际情况选填">
                </td>
            </tr>
            <tr>
                <th>[选填] 地址：</th>
                <td>
                    <input type="text" class="lg" name="art_address" value="" placeholder="根据实际情况选填">
                </td>
            </tr>
            <tr>
                <th>文章内容：</th>
                <td>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                    <script id="editor" name="art_content" type="text/plain" style="width:860px;height:500px;"></script>
                    <script type="text/javascript">
                        var ue = UE.getEditor('editor');
                    </script>
                    <style>
                        .edui-default{line-height: 28px;}
                        div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                        {overflow: hidden; height:20px;}
                        div.edui-box{overflow: hidden; height:22px;}
                    </style>
                </td>
            </tr>
            <tr>
                <th>广告标题：</th>
                <td>
                    <input type="text" class="sm" name="art_ad_title">
                </td>
            </tr>
            <tr>
                <th>广告图片：</th>
                <td>
                    <div id="art_ad_img">
                        <div class="show-art_ad_img">

                        </div>
                        <div id="picker-art_ad_img" class="wu-example">

                        </div>
                        <div class="progress" style="display: none;width: 300px;">
                            <div class="progress-bar progress-bar-striped active" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="max-width: 100%;height: 5px;">
                            </div>
                        </div>
                        <input type="hidden" readonly class="lg inputMap-art_ad_img pub-hide" name="art_ad_img" value=""/>
                    </div>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<script>
    myUploadApp.uploadBase('art_thumb','img', '选择图片')
    myUploadApp.uploadBase('art_ad_img','img', '选择图片')
</script>
@endsection
