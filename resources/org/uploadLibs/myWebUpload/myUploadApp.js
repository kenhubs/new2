window.myUploadApp={
    typeConfig:{
        img:{
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },
        audio:{
            title: 'audio',
            extensions: 'mp3,ogg',
            mimeTypes: 'audio/*'
        },
        video:{
            title: 'video',
            extensions: 'mp4,AVI,RM,wmv,asf,mov,flv',
            mimeTypes: 'video/*'
        }
    },
    serverConfig:{
        img:'',
        audio:'',
        video:''
    },
    objConfig:{
        img:new Image(),
        audio:new Audio(),
        video:document.createElement("VIDEO")
    },
    uploadBase:function(domId, fileType, buttenName){
        _this = this
        var serverRoute = this.serverConfig[fileType]
        var opt = this.objConfig[fileType]

        // 初始化Web Uploader
        var up = WebUploader.create({
            auto: true,									// 选完文件后，是否自动上传。
            swf: "{{asset('images/Uploader.swf')}}",	// swf文件路径
            server: serverRoute, 						// 文件接收服务端。

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {
                id:'#picker-'+domId,
                multiple:false,// 是否支持多文件上传
                innerHTML:buttenName
            },

            // 只允许选择图片文件。
            accept: this.typeConfig[fileType]
        });

        up.on( 'fileQueued', function( file ) {

            // 当有文件添加进来的时候
            // console.log("添加进来了")
        });

        // 文件上传过程中创建进度条实时显示。
        up.on( 'uploadProgress', function( file, percentage ) {
            $("#picker-"+domId).css({"display":"none"});
            $("#"+domId+" .progress").css({
                display:"block"
            });
            $("#"+domId+" .progress .progress-bar").css({
                width:percentage * 100 + '%'
            })

        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        up.on( 'uploadSuccess', function( file ) {

        });
        up.on( 'uploadAccept', function( object ,ret) {
            $(".inputMap-"+domId).val(ret.filename)
            opt.src="/upload/"+fileType+'/'+ret.filename;
            $(".show-"+domId).html(opt)
            if(fileType == 'img'){
                opt.setAttribute("class","thumbnail thumbnail_"+domId)
                opt.setAttribute("width",200)
            }else if(fileType == 'audio'){
                opt.setAttribute("controls","controls")
                opt.style.float = 'left'

                //var style = fileType=='audio'?'float:right;':''
                //var remove =  "<span class='btn btn-danger btn-sm thumbnail_"+domId+"' style='"+style+"'>移除</span>"
                var remove =  "<span class='btn btn-danger btn-sm thumbnail_"+domId+"' style='float:right'>移除</span>"
                $(".show-"+domId).append(remove)
            }else{
                opt.setAttribute("class","thumbnail thumbnail_"+domId)
                opt.setAttribute("controls","controls")
                opt.setAttribute("width",400)
                //opt.setAttribute("poster","{{asset('images/avatar/nandini_m@2x.jpg')}}")
            }
            $(".thumbnail_"+domId).on('click',function(){_this.del(domId, fileType, buttenName)})
        });

        // 文件上传失败，显示上传出错。
        up.on( 'uploadError', function( file ) {
            alert("上传失败");
            $("#imgPicker-"+domId).css({"display":"block"});
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        up.on( 'uploadComplete', function( file ) {
            $("#"+domId+" .progress").css({"display":"none"});
        });
    },
    del:function(domId, fileType, buttenName){
        _this = this
        var typeText = fileType == 'img' ? '图片' : (fileType== 'audio' ? '音乐' : '视频')
        layer.confirm('你确认删除'+typeText+'么？', {
            offset:'100px',
            btn: ['确认','取消']
        },function(index){
            layer.close(index)
            $(".inputMap-"+domId).val(""); //filename -- input
            $(".show-"+domId).empty()      //展示图片
            $("#picker-"+domId).css({"display":"block"}).empty();//上传按钮及控件
            _this.uploadBase(domId, fileType ,buttenName) //初始化
        },function(){
            layer.close()
        });
    }
}