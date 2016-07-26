<?php
/**
 * SEO页面控件
 * @TODO 更加完善的SEO控制
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: Seo.php 17 2010-04-13 06:56:59Z allen $
 **/

function _ctlSeo( $name, $attribs )
{
    $opts = array('info');
    $data = FLEA_WebControls::extractAttribs( $attribs, $opts );
    FLEA_WebControls::mergeAttribs( $attribs );

    $title = '';
    $keyword = getOption('keyword');
    $description = getOption('description');

    if ($data['info']) {
        if ($data['info']['seo_title']) {
            $title = $data['info']['seo_title'] . ' - ';
        }
        if ($data['info']['keyword']) {
            $keyword = $data['info']['keyword'] . ' - ';
        }
        if ($data['info']['description']) {
            $description = $data['info']['description'] . ' - ';
        }
    }

    $title .= getOption('sitename');

    $output = '';

    $output .= '<title>' . $title . '</title>';

    $output .= '<!-- SEO Park -->';
    $output .= '<meta name="keywords" content="' . $keyword . '" />';
    $output .= '<meta name="description" content="' . $description . '" />';
    $output .= '<link rel="canonical" href="' . getOption('domain') . '" />';
    //$output .= '<link rel="index" title="Title" href="href" />';
    //$output .= '<link rel="start" title="Title" href="href" />';
    //$output .= '<link rel="prev" title="Title" href="href" />';
    //$output .= '<link rel="next" title="Title" href="href" />';

    $output .= '<meta name="generator" content="SixHorses CMS 0.1.0" />';
    $output .= '<!-- /SEO Park -->';

    return $output;
}

