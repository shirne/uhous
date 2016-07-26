<?php
/**
 * 分页显示控件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/
function _ctlPagenav($name, $attribs)
{
    $opts = array('pager', 'controller', 'action', 'length', 'slider', 'prevLabel', 'nextLabel');
    $data = FLEA_WebControls::extractAttribs($attribs, $opts);

    FLEA_WebControls::mergeAttribs($attribs);

    if ($data['slider'] <= 0) { $data['slider'] = 2; }
    if ($data['length'] <= 0) { $data['length'] = 9; }
    if ($data['prevLabel'] == '') { $data['prevLabel'] = 'prev'; }
    if ($data['nextLabel'] == '') { $data['nextLabel'] = 'next'; }

    $output = "<div id=\"pagenav\">\n<ul";
    if ($name) {
        $name = h($name);
        $output .= " id=\"{$name}\"";
    }
    $output .= ">\n";

    if ($data['pager']['currentPage'] == $data['pager']['firstPage']) {
        $output .= "<li class=\"disabled\">&#171; {$data['prevLabel']}</li>\n";
    } else {
        $attribs['page'] = $data['pager']['prevPage'];
        $url = url($data['controller'], $data['action'], $attribs);
        $output .= "<li><a href=\"{$url}\">&#171; {$data['prevLabel']}</a></li>\n";
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
            $output .= "<li class=\"none\">...</li>\n";
        }
    }

    for ($i = $begin; $i <= $end; $i++) {
        $attribs['page'] = $i;
        $in = $i + 1 - $base;
        if ($i == $data['pager']['currentPage']) {
            $output .= "<li class=\"current\">{$in}</li>\n";
        } else {
            $url = url($data['controller'], $data['action'], $attribs);
            $output .= "<li><a href=\"{$url}\">{$in}</a></li>\n";
        }
    }

    if ($data['pager']['lastPage'] - $end > $data['slider']) {
        $output .= "<li class=\"none\">...</li>\n";
        $end = $data['pager']['lastPage'] - $data['slider'];
    }

    for ($i = $end + 1; $i <= $data['pager']['lastPage']; $i++) {
        $attribs['page'] = $i;
        $in = $i + 1 - $base;
        $url = url($data['controller'], $data['action'], $attribs);
        $output .= "<li><a href=\"{$url}\">{$in}</a></li>\n";
    }

    if ($data['pager']['currentPage'] == $data['pager']['lastPage']) {
        $output .= "<li class=\"disabled\">{$data['nextLabel']} &#187;</li>\n";
    } else {
        $attribs['page'] = $data['pager']['nextPage'];
        $url = url($data['controller'], $data['action'], $attribs);
        $output .= "<li><a href=\"{$url}\">{$data['nextLabel']} &#187;</a></li>\n";
    }

    $output .= "</ul></div>\n";

    return $output;
}

