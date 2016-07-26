// 删除确认
function remove_confirm(form, link)
{
    if (confirm('您确定要删除这些数据吗?') == true) {
        if (link != '') {
            window.location.href = link.href;
        } else {
            $(form).submit();
        }
    }
}

function ctl_submit(form, link)
{
    $(form).attr('action', link);
    $(form).submit();
}

