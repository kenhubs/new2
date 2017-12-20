//弹出框
apiready = function(){
    api.parseTapmode();
}
var toast = new auiToast();
function showDefault(type){
    switch (type) {
        case "success":
            toast.success({
                title:"加载成功",
                duration:2000
            });
            break;
        case "fail":
            toast.fail({
                title:"暂无数据",
                duration:2000
            });
            break;
        case "custom":
            toast.custom({
                title:"提交成功",
                html:'<i class="aui-iconfont aui-icon-laud"></i>',
                duration:2000
            });
            break;
        case "loading":
            toast.loading({
                title:"加载中...",
                duration:2000
            },function(ret){
                console.log(ret);
                setTimeout(function(){
                     toast.hide();
                }, 3000)
            });
            break;
        default:
            // statements_def
            break;
    }
}
//文档高度
function getDocumentTop() {
    var scrollTop = 0, bodyScrollTop = 0, documentScrollTop = 0;
    if (document.body) {
        bodyScrollTop = document.body.scrollTop;
    }
    if (document.documentElement) {
        documentScrollTop = document.documentElement.scrollTop;
    }
    scrollTop = (bodyScrollTop - documentScrollTop > 0) ? bodyScrollTop : documentScrollTop;
    return scrollTop;
}
//可视窗口高度

function getWindowHeight() {
    var windowHeight = 0;
    if (document.compatMode == "CSS1Compat") {
        windowHeight = document.documentElement.clientHeight;
    } else {
        windowHeight = document.body.clientHeight;
    }
    return windowHeight;
}
//滚动条滚动高度
function getScrollHeight() {
    var scrollHeight = 0, bodyScrollHeight = 0, documentScrollHeight = 0;
    if (document.body) {
        bodyScrollHeight = document.body.scrollHeight;
    }
    if (document.documentElement) {
        documentScrollHeight = document.documentElement.scrollHeight;
    }
    scrollHeight = (bodyScrollHeight - documentScrollHeight > 0) ? bodyScrollHeight : documentScrollHeight;
    return scrollHeight;
}
