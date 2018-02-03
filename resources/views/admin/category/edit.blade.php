@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 分类管理
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>编辑分类</h3>
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
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>添加分类</a>
            <a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>全部分类</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/category/'.$field->cate_id)}}" method="post">
        <input type="hidden" name="_method" value="put">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>父级分类：</th>
                <td>
                    <select name="cate_pid">
                        <option value="0">==顶级分类==</option>
                        @foreach($data as $d)
                        <option value="{{$d->cate_id}}"
                                @if($d->cate_id==$field->cate_pid) selected @endif
                        >{{$d->cate_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>分类名称：</th>
                <td>
                    <input type="text" name="cate_name" value="{{$field->cate_name}}">
                    <span><i class="fa fa-exclamation-circle yellow"></i>分类名称必须填写</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>唯一识别码：</th>
                <td>
                    <input type="text" name="cate_uuid" placeholder="取分类名称首字母的大写" value="{{$field->cate_uuid}}">
                    <span><i class="fa fa-exclamation-circle yellow"></i>必须填写</span>
                </td>
            </tr>
            <tr>
                <th>图标：</th>
                <td>
                    <div id="cate_icon">
                        <div class="show-cate_icon">
                            @if($field->cate_icon)
                                <img src="/{{$field->cate_icon}}" class="thumbnail_cate_icon" width="200px;" onclick="myUploadApp.del('cate_icon','img','选择图片')">
                            @endif
                        </div>
                        <div id="picker-cate_icon" class="wu-example">

                        </div>
                        <div class="progress" style="display: none;width: 300px;">
                            <div class="progress-bar progress-bar-striped active" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="max-width: 100%;height: 5px;">
                            </div>
                        </div>
                        <input type="hidden" readonly class="lg inputMap-cate_icon pub-hide" name="cate_icon" value="{{$field->cate_icon ? $field->cate_icon : ''}}"/>
                    </div>
                </td>
            </tr>
            {{--<tr>
                <th>分类标题：</th>
                <td>
                    <input type="text" class="lg" name="cate_title"  value="{{$field->cate_title}}">
                </td>
            </tr>
            <tr>
                <th>关键词：</th>
                <td>
                    <textarea name="cate_keywords">{{$field->cate_keywords}}</textarea>
                </td>
            </tr>
            <tr>
                <th>描述：</th>
                <td>
                    <textarea name="cate_description">{{$field->cate_description}}</textarea>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>排序：</th>
                <td>
                    <input type="text" class="sm" name="cate_order"  value="{{$field->cate_order}}">
                </td>
            </tr>--}}
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
    window.onload = function(){
        var cate_icon="{{$field->cate_icon ? $field->cate_icon : ''}}"
        if(!cate_icon) myUploadApp.uploadBase('cate_icon', 'img', '选择图片')
    }
</script>
@endsection
