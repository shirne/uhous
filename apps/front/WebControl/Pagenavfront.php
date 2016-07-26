<?php
/**
 * 前台分页显示控件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/
function _ctlPagenavfront($name, $attribs)
{
    $opts = array('pager', 'controller', 'action', 'length', 'slider', 'prevLabel', 'nextLabel');
    $data = FLEA_WebControls::extractAttribs($attribs, $opts);

    FLEA_WebControls::mergeAttribs($attribs);

    if ($data['slider'] <= 0) { $data['slider'] = 1; }
    if ($data['length'] <= 0) { $data['length'] = 4; }
    if ($data['prevLabel'] == '') { $data['prevLabel'] = '上一页'; }
    if ($data['nextLabel'] == '') { $data['nextLabel'] = '下一页'; }
    if ($data['pager']['pageCount'] <= 1) { return; }

    $output = "<div id=\"pagenav\">\n<ul";
    if ($name) {
        $name = h($name);
        $output .= " id=\"{$name}\" class=\"{$name}\"";
    }
    $output .= ">\n";

    if ($data['pager']['currentPage'] == $data['pager']['firstPage']) {
        $output .= "<li class=\"disabled\"><a href=\"#\">{$data['prevLabel']}</a></li>\n";
    } else {
        $attribs['page'] = $data['pager']['prevPage'];
        $url = url($data['controller'], $data['action'], $attribs);
        $output .= "<li><a href=\"{$url}\">{$data['prevLabel']}</a></li>\n";
    }

    $base = $data['pager']['firstPage'];
    $currentPage = $data['pager']['currentPage'];

    $mid = intval($data['length'] / 2);
    if ($currentPage < $data['pager']['firstPage']) {
        $currentPage = $data['pager']['firstPage'];
    }
    if ($currentPage > $data['pager']['lastPage']) {
        $currentPage = $data['pager']['lastPage'];
    }

    //$output .= "<li class=\"page\">" . ($currentPage+1) . ' / ' . $data['pager']['pageCount'] . "</li>";

    $begin = $currentPage - $mid;
    if ($begin < $data['pager']['firstPage']) {
        $begin = $data['pager']['firstPage'];
    }
    $end = $begin + $data['length'] - 1;
    if ($end >= $data['pager']['lastPage']) {
        $end = $data['pager']['lastPage'];
        $begin = $end - $data['length'] + 1;
        if ($begin < $data['pager']['firstPage']) {
            $begin = $data['pager']['firstPage'];
        }
    }

    if ($begin > $data['pager']['firstPage']) {
        for ($i = $data['pager']['firstPage']; $i < $data['pager']['firstPage'] + $data['slider'] && $i < $begin; $i++) {
            $attribs['page'] = $i;
            $in = $i + 1 - $base;
            $url = url($data['controller'], $data['action'], $attribs);
            $output .= "<li><a href=\"{$url}\">{$in}</a></li>\n";
        }

        if ($i < $begin) {
            $output .= "<li class=\"none\" style=\"text-align:center\">...</li>\n";
        }
    }

    for ($i = $begin; $i <= $end; $i++) {
        $attribs['page'] = $i;
        $in = $i + 1 - $base;
        if ($i == $data['pager']['currentPage']) {
            $output .= "<li class=\"pagecurrent\"><a href=\"#\">{$in}</a></li>\n";
        } else {
            $url = url($data['controller'], $data['action'], $attribs);
            $output .= "<li><a href=\"{$url}\">{$in}</a></li>\n";
        }
    }

    if ($data['pager']['lastPage'] - $end > $data['slider']) {
        $output .= "<li class=\"none\" style=\"text-align:center\"><a href=\"#\">...</a></li>\n";
        $end = $data['pager']['lastPage'] - $data['slider'];
    }

    for ($i = $end + 1; $i <= $data['pager']['lastPage']; $i++) {
        $attribs['page'] = $i;
        $in = $i + 1 - $base;
        $url = url($data['controller'], $data['action'], $attribs);
        $output .= "<li><a href=\"{$url}\">{$in}</a></li>\n";
    }

    if ($data['pager']['currentPage'] == $data['pager']['lastPage']) {
        $output .= "<li class=\"disabled\"><a href=\"#\">{$data['nextLabel']}</a></li>\n";
    } else {
        $attribs['page'] = $data['pager']['nextPage'];
        $url = url($data['controller'], $data['action'], $attribs);
        $output .= "<li><a href=\"{$url}\">{$data['nextLabel']}</a></li>\n";
    }

    $output .= "</ul></div>\n";

    return $output;
}

