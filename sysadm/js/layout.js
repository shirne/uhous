/**
 * 载入框架布局
 *
 */
function initLayout () {
    $('body').layout({
        // Default Options
        defaults: {
            scrollToBookmarkOnLoad: false,
            fxName:                 'drop',
            fxSpeed:                'slow'
        },

        // Header Options
        north: {
            paneSelector:           '#header',
            size:                   'auto',
            spacing_open:           0,
            closable:               false,
            resizable:              false
        },

        // Sidebar Options
        west: {
            paneSelector:           '#sidebar',
            size:                   200,
            minSize:                180,
            maxSize:                280,
            sliderTip:              '弹开',
            togglerTip_open:        '折叠',
            togglerTip_closed:      '展开',
            resizerTip:             '改变宽度'
        },

        // Content Options
        center: {
            paneSelector:           '#content',
            contentSelector:        '#inner-content'
        },

        // Footer Options
        south: {
            paneSelector:           '#footer',
            size:                   'auto',
            spacing_open:           0,
            closable:               false,
            resizable:              false
        }

    });
}

/**
 * 载入侧边栏折叠
 *
 */
function initSidebar () {
    var icons = {
        header: "navdot-off",
        headerSelected: "navdot-on"
    };
    $(function() {
        $("#sidebar .sidebar").accordion({ fillSpace: true });
        $("#sidebar .sub-nav").accordion({ autoHeight: false, collapsible: true });
    });
}

/**
 * 载入提示信息事件控制
 *
 */
function initPurr () {
    if ($('#tip').html() != null) {
        var tip = $('#tip');
        tip.css('display', 'none');
        purrMsg(tip.attr('title'), tip.html());
        return false;
    }
}

/**
 * purr消息
 *
 * @param title $title
 * @param content $content
 * @access public
 * @return void
 */
function purrMsg (title, content) {
    var notice = '<div class="notice">'
                + '<div class="notice-body">'
                + '<img src="../themes/sysadm/img/info.png" alt="" />'
                + '<h3>' + title + '</h3>'
                + '<p>' + content + '</p>'
                + '</div>'
                + '<div class="notice-bottom"></div>'
                + '</div>';
    $( notice ).purr({
        usingTransparentPNG: true
    });

}

/**
 * 载入表格数据特效
 *
 */
function initTableDataExt() {
    if ($('.table-data').html() != null) {
        // 设置表格斑马线
        $('.table-data tr:even').each(function(){
                $(this).addClass('even');
                });
        // 设置当前行高亮显示
        $('.table-data tr').hover(function(){
                $(this).addClass('hover');
                }, function(){
                $(this).removeClass('hover');
                });
        // 设置全选及反选操作
        $('#checkall').click(function(){
                var b = false;
                if ($(this).attr('checked')) {
                    b = true;
                }
                $("[name='check[]']").each(function(){
                    $(this).attr('checked', b);
                    });
                });
    }
}

/**
 * 载入树状目录效果器
 *
 */
function initTreeview() {
    $("#tree-data").treeview({
        persist: "location",
        collapsed: true,
        unique: true
    });
}

/**
 * 载入语言跳转
 *
 */
function initLanguage() {
    if ($('#lang-jump').html() != null) {
        $('#lang-jump').change(function(o){
            window.location.href = url + '&lang=' + $('#lang-jump option:selected').val();
        });
    }
}

/**
 * 载入区域折叠
 *
 */
function initFold() {
    if ($('fieldset.fold').html() != null) {
        $('fieldset.fold legend').each(function(){
            $(this).attr('title', '显示/折叠');
            $(this).click(function(){
                $(this).next('div').slideToggle('slow');
            });
        });
    }
}

/**
 * 载入栏目管理交互
 *
 */
function initColManage() {
    $('.colbox').hover(function(){
        $(this).addClass('hover');
    }, function(){
        $(this).removeClass('hover');
    });
    $('.colbox-top').each(function(){
        $(this).children('input["type"="checkbox"]').click(function(){
            var checked = false;
            if ($(this).attr('checked')) {
                checked = true;
            }
            $(this).next('ul').find('li input').each(function(){
                $(this).attr('checked', checked);
            });
        });
    });
}

function dump(m){
    console.log(m);
}

$(document).ready(function(){
    if ($('#inner-content').html() != null) {
        initLayout();
    }
    if ($('.tree-data').html() != null) {
        initTreeview();
    }
    initSidebar();
    initPurr();
    initTableDataExt();
    initLanguage();
    initFold();
    initColManage();
});

$(function(){
if($.browser.msie&&$.browser.version=="6.0" && $("html")[0].scrollHeight>$("html").height())
$("html").css("overflowY","scroll");
});
