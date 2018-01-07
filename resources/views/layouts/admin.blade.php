<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('resources/views/admin/style/css/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('resources/views/admin/style/font/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/css/bootstrap.css')}}">
{{--    <link rel="stylesheet" type="text/css" href="{{asset('resources/org/webuploader/webuploader.css')}}">--}}
    <script type="text/javascript" src="{{asset('resources/views/admin/style/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/style/js/ch-ui.admin.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/org/layer/layer.js')}}"></script>
    {{--<script type="text/javascript" src="{{asset('resources/org/webuploader/webuploader.js')}}"></script>--}}
    <script type="text/javascript" src="{{asset('resources/org/uploadLibs/myWebUpload/webuploader.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/org/uploadLibs/myWebUpload/myUploadApp.js')}}"></script>
    <style>
        input[type='submit'], input[type='button']{
            line-height:25px;
        }
    </style>
</head>
<body>
<!--头部 开始-->
<div class="top_box">
    <div class="top_left">
        <div class="logo">后台管理系统</div>
        <ul>
            {{--<li><a href="{{url('/')}}" target="_blank" class="active">首页</a></li>
            <li><a href="{{url('admin/index')}}">管理页</a></li>--}}
            <li><a href="{{url('admin/index')}}">首页</a></li>
        </ul>
    </div>
    <div class="top_right">
        <ul>
            <li>管理员：admin</li>
            <li><a href="{{url('admin/pass')}}">修改密码</a></li>
            <li><a href="{{url('admin/quit')}}">退出</a></li>
        </ul>
    </div>
</div>
<!--头部 结束-->

<!--左侧导航 开始-->
<div class="menu_box">
    <ul>
        <li>
            <h3><i class="fa fa-fw fa-clipboard"></i>分类管理</h3>
            <ul class="sub_menu">
                <li><a href="{{url('admin/category/create')}}">添加分类</a></li>
                <li><a href="{{url('admin/category')}}">分类列表</a></li>
                {{--<li><a href="{{url('admin/article/create')}}"><i class="fa fa-fw fa-plus-square"></i>添加文章</a></li>
                <li><a href="{{url('admin/article')}}"><i class="fa fa-fw fa-list-ul"></i>文章列表</a></li>--}}
            </ul>
        </li>
        <li>
            <h3><i class="fa fa-fw fa-clipboard"></i>广告管理</h3>
            <ul class="sub_menu">
                <li><a href="{{url('admin/ad/create')}}" >添加广告</a></li>
                <li><a href="{{url('admin/ad')}}">广告列表</a></li>
            </ul>
        </li>
        <li>
            <h3><i class="fa fa-fw fa-clipboard"></i>社区服务</h3>
            <ul class="sub_menu">
                @foreach($cate1 as $v)
                    @if($v->cate_uuid != 'ZHSQ')
                    <li><a href="{{url('admin/article/list').'/'.$v->cate_id}}">{{$v->cate_name}}</a></li>
                    @endif
                @endforeach
            </ul>
        </li>
        <li>
            <h3><i class="fa fa-fw fa-clipboard"></i>智慧商圈</h3>
            <ul class="sub_menu">
                @foreach($cate2 as $v)
                    <li><a href="{{url('admin/article/list').'/'.$v->cate_id}}">{{$v->cate_name}}</a></li>
                @endforeach
            </ul>
        </li>
        <li>
            <h3><i class="fa fa-fw fa-cog"></i>系统设置</h3>
            <ul class="sub_menu" style="display: block;">
                <li><a href="{{url('admin/links')}}">友情链接</a></li>
                {{--<li><a href="{{url('admin/navs')}}"><i class="fa fa-fw fa-navicon"></i>自定义导航</a></li>--}}
                <li><a href="{{url('admin/config')}}">网站配置</a></li>
            </ul>
        </li>
    </ul>
</div>
<!--左侧导航 结束-->

<!--主体部分 开始-->
<div class="main_box" style="overflow:scroll">
    @yield('content')

</div>
<!--主体部分 结束-->

<!--底部 开始-->
<div class="bottom_box">
    CopyRight © {{date('Y',time())}}. Powered By <a href="{{env('APP_URL')}}">{{env('APP_URL')}}</a>.
</div>
<!--底部 结束-->

@yield('js')
</body>
</html>