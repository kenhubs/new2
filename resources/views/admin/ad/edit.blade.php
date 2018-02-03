@extends('layouts.admin')
@section('content')
<style>
    .adHide{
        display: none;
    }
</style>
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 广告管理 &raquo; 编辑
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>编辑广告</h3>
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
            <a href="{{url('admin/ad/create')}}"><i class="fa fa-plus"></i>添加广告</a>
            <a href="{{url('admin/ad')}}"><i class="fa fa-recycle"></i>全部广告</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/ad/'.$field->ad_id)}}" method="post">
        <input type="hidden" name="_method" value="put">
        <input type="hidden" name="ad_type" value="{{$field->ad_type}}">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            {{--<tr>
                <th width="120">分类：</th>
                <td>
                    <select name="cate_id">
                        @foreach($data as $d)
                        <option value="{{$d->cate_id}}"
                                @if($field->cate_id==$d->cate_id) selected @endif
                        >{{$d->_cate_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>--}}
            <tr>
                <th><i class="require">*</i> 文章标题：</th>
                <td>
                    <input type="text" class="lg" name="ad_title" value="{{$field->ad_title}}">
                </td>
            </tr>
            @if($field->ad_type == 1)
            <tr class="adContent">
                <th><i class="require">*</i>广告内容：</th>
                <td>
                    <textarea class="sm" name="ad_text">{{$field->ad_text}}</textarea>
                </td>
            </tr>
            @else
            <tr class="adPosition">
                <th><i class="require">*</i> 投放位置：</th>
                <td>
                    <input type="radio" class="lg" name="ad_position" value="0" @if($field->ad_position==0) checked @endif onclick="app.changePosition(0)">启动页
                    <input type="radio" class="lg" name="ad_position" value="1" @if($field->ad_position==1) checked @endif onclick="app.changePosition(1)">轮播
                    <input type="radio" class="lg" name="ad_position" value="2" @if($field->ad_position==2) checked @endif onclick="app.changePosition(2)">列表
                </td>
            </tr>
            <tr class="adCate @if($field->ad_position!=2) adHide @endif">
                <th></th>
                <td>
                    <select name="ad_cate_id">
                        @foreach($cate as $d)
                            <option value="{{$d->cate_id}}" @if($field->ad_cate_id==$d->cate_id) selected @endif>{{$d->_cate_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr class="adContent">
                <th>广告图片：</th>
                <td>
                    <div id="ad_img">
                        <div class="show-ad_img">
                            @if($field->ad_img)
                                <img src="{{$field->ad_img}}" class="thumbnail_ad_img" width="200px;" onclick="myUploadApp.del('ad_img','img','选择图片')">
                            @endif
                        </div>
                        <div id="picker-ad_img" class="wu-example">

                        </div>
                        <div class="progress" style="display: none;width: 300px;">
                            <div class="progress-bar progress-bar-striped active" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="max-width: 100%;height: 5px;">
                            </div>
                        </div>
                        <input type="hidden" readonly class="lg inputMap-ad_img pub-hide" name="ad_img" value="{{$field->ad_img ? $field->ad_img : ''}}"/>
                    </div>
                </td>
            </tr>
            @endif
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

@endsection
@section('js')
    <script>
        $(function(){
            var ad_img = "{{$field->ad_img ? $field->ad_img : ''}}"
            if(!ad_img) myUploadApp.uploadBase('ad_img', 'img', '选择图片')
            
            window.app = {
                require:['ad_title','ad_text'],
                msgConfig:{
                    ad_title:'标题不能为空！<br>',
                    ad_text:'广告内容不能为空！<br>',
                    ad_img:'广告图片不能为空！<br>'
                },
                setType(type){
                    this.require = type==1 ? ['ad_title','ad_text'] : ['ad_title','ad_img']
                    $('input[name=ad_type]').val(type)
                    $('.adType').eq(type-1).addClass('adActive').siblings().removeClass('adActive')
                    $('.adContent').eq(type-1).removeClass('adHide')
                    $('.adContent').eq(2-type).addClass('adHide')
                },
                changePosition(posType){
                    if(posType == 2){
                        $('.adCate').removeClass('adHide')
                    }else{
                        $('.adCate').addClass('adHide')
                    }
                },
                checkData(){
                    _this = this
                    var msgs = ''
                    this.require.map(function(item){
                        var inValue = item == 'ad_text' ? $('textarea[name=ad_text]').val() : $('input[name='+item+']').val()
                        if(!inValue) msgs+=_this.msgConfig[item]
                    })
                    if(msgs){
                        layer.open({
                            title: '温馨提示：'
                            ,content: msgs
                        });
                    }else{
                        $('form').submit()
                    }
                }
            }
        })
    </script>
@endsection