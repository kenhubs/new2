@extends('layouts.admin')
@section('content')
<style>
    .adActive{
        color:red;
    }
    .adHide{
        display: none;
    }
</style>
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 广告管理 &raquo; 添加
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>添加广告</h3>
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
            <a class="adType adActive" href="javascript:void(0)" onclick="app.setType(1)"><i class="fa fa-plus"></i>添加文字广告</a>
            <a class="adType" href="javascript:void(0)" onclick="app.setType(2)"><i class="fa fa-plus"></i>添加图片广告</a>
            <a href="{{url('admin/ad')}}"><i class="fa fa-recycle"></i>广告列表</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/ad')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" class="lg" name="ad_type" value="1">
        <table class="add_tab">
            <tbody>
            {{--<tr>
                <th width="120">分类：</th>
                <td>
                    <select name="cate_id">
                        @foreach($data as $d)
                        <option value="{{$d->cate_id}}">{{$d->_cate_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>--}}
            <tr>
                <th><i class="require">*</i> 广告标题：</th>
                <td>
                    <input type="text" class="lg" name="ad_title">
                </td>
            </tr>
            <tr class="adContent">
                <th><i class="require">*</i>广告内容：</th>
                <td>
                    <textarea class="sm" name="ad_text"></textarea>
                </td>
            </tr>
            <tr class="adPosition adHide">
                <th><i class="require">*</i> 投放位置：</th>
                <td>
                    <input type="radio" class="lg" name="ad_position" value="1">轮播
                    <input type="radio" class="lg" name="ad_position" value="2" checked>列表
                </td>
            </tr>
            <tr class="adContent adHide">
                <th><i class="require">*</i>广告图片：</th>
                <td>
                    <input type="hidden" size="50" name="ad_img">
                    <input id="file_upload" name="file_upload" type="file" multiple="true">
                    <script src="{{asset('resources/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                    <link rel="stylesheet" type="text/css" href="{{asset('resources/org/uploadify/uploadify.css')}}">
                    <script type="text/javascript">
                        <?php $timestamp = time();?>
                        $(function() {
                            $('#file_upload').uploadify({
                                'buttonText' : '图片上传',
                                'formData'     : {
                                    'timestamp' : '<?php echo $timestamp;?>',
                                    '_token'     : "{{csrf_token()}}"
                                },
                                'swf'      : "{{asset('resources/org/uploadify/uploadify.swf')}}",
                                'uploader' : "{{url('admin/upload')}}",
                                'onUploadSuccess' : function(file, data, response) {
                                    $('#ad_img').append('<img src="/'+data+'" alt="" style="max-width: 350px; max-height:100px;">')
                                    var imgValue = $('input[name=ad_img]').val()
                                    imgValue += imgValue ? ','+data : data
                                    $('input[name=ad_img]').val(imgValue);
                                }
                            });
                        });
                    </script>
                    <style>
                        .uploadify{display:inline-block;}
                        .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                        table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
                    </style>
                </td>
            </tr>
            <tr>
                <th></th>
                <td id="ad_img">
                </td>
            </tr>

            <tr>
                <th></th>
                <td>
                    <input type="button" value="提交" onclick="app.checkData()">
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
        window.app = {
            require:['ad_title','ad_text'],
            msgConfig:{
                ad_title:'标题不能为空！<br>',
                ad_text:'广告内容不能为空！<br>',
                ad_img:'广告图片不能为空！<br>'
            },
            setType(type){
                this.require = type==1 ? ['ad_title','ad_text'] : ['ad_title','ad_img']
                if(type==2){
                    $('.adPosition').removeClass('adHide')
                }else{
                    $('.adPosition').addClass('adHide')
                }
                $('input[name=ad_type]').val(type)
                $('.adType').eq(type-1).addClass('adActive').siblings().removeClass('adActive')
                $('.adContent').eq(type-1).removeClass('adHide')
                $('.adContent').eq(2-type).addClass('adHide')
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