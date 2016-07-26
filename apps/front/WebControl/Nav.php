<?php
/**
 * 地址控件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     jayzone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

function _ctlNav($name, $attribs)
{
    $opts = array('column');
    $data = FLEA_WebControls::extractAttribs($attribs, $opts);
    FLEA_WebControls::mergeAttribs( $attribs );

    $output = array();
    $output[] = '<ul class="nav-location fl clearfix">';
    $output[] = '<li class="path home"><a href="/">首页</a></li>';

    switch ($data['column']) {
        case 'products':
            if ($_GET['id']) {
                $output[] = _product((int)$_GET['id']);

            } else {
                $output[] = _categories();
            }
            break;

        default:
            break;
    }

    $output[] = '</ul>';

    return implode('',$output);
}

/**
 * 输出当前产品导航 
 * 
 * @param mixed $pro_id 
 * @access protected
 * @return void
 */
function _product($pro_id)
{
    $modelProducts =& FLEA::getSingleton('Model_Products');   
    $modelCategories =& FLEA::getSingleton('Model_Categories');

    $product = $modelProducts->getProById($pro_id, 'pro_id, cate_id, name', null, false);
    $cates = $modelCategories->getOne(
        array(
            array('cate_id', $product['cate_id']),
            array('col_key', 'products'),
            array('lang', getLanguage())
        ), 
        null, 
        'cate_id, parent_id, name', 
        false
    );

    $parentCate = $modelCategories->getOne(
        array(
            array('cate_id', $cates['parent_id']),
            array('col_key', 'products'),
            array('lang', getLanguage())
        ), 
        null, 
        'cate_id, name', 
        false
    );

    $output .= '<li class="path"><a href="' . url('Products', 'Index', array('cate_id' => $parentCate['cate_id'])) . '">' . $parentCate['name'] . '</a></li>';
    $output .= '<li class="path"><a href="' . url('Products', 'Index', array('cate_id' => $cates['cate_id'])) . '">' . $cates['name'] . '</a></li>';
    $output .= '<li class="current"><a href="' . url('Products', 'View', array('id' => $product['pro_id'])) . '" onclick="return false">' . $product['name'] . '</a></li>';

    return $output;
}
/**
 * 输出分类导航 
 * 
 * @access protected
 * @return void
 */
function _categories()
{
    /**
     * 实例化分类模型 
     */
    $modelCategories =& FLEA::getSingleton('Model_Categories');
    /**
     * 获得当前分类ID 
     */
    $currentCateId = (int)$_GET['cate_id'];
    /**
     * 设置条件 
     */
    $where[] = array('col_key', 'products');
    $where[] = array('lang', getLanguage());

    $consident = $where;
    $consident[] = array('cate_id', $currentCateId);

    $sortby = 'sort_id ASC, cate_id DESC';
    /**
     * 找出当前分类名称 
     */
    $currentCate = $modelCategories->getOne($consident, $sortby, 'cate_id, parent_id, name', false);
    if(!$currentCate){
    	$currentCate=array(
    		'cate_id'=>0,
    		'parent_id'=>0,
    		'name'=>'所有产品'
    	);
    }
    
    /**
     * 当前分类为子分类时 
     */
    if ($currentCate['parent_id'] != 0) {

        unset($consident);
        $consident = $where;
        //通过当前分类的父类ID，查找父类id信息  
        $consident[] = array('cate_id', $currentCate['parent_id']);
        $parentCate = $modelCategories->getOne( $consident, $sortby, 'cate_id, parent_id, name', false);

        $currentCateId = $currentCate['parent_id'];
        $currentCate = $parentCate;
    }
    
    
    
    $output .= '<li class="path"><a href="' . url('Products', 'Index', array('cate_id' => $currentCateId)) . '">' . $currentCate['name'] . '</a></li>';

    $where[] = array('parent_id', $currentCateId);

    /**
     * 查找出当前分类的子分类 
     */
    $subCates = $modelCategories->getAll( $where, $sortby, 'cate_id, parent_id, name, sort_id', null, false);

    if ($subCates) {

        foreach ($subCates as $key) {
            $output .= '<li class="cate';
            if ($_GET['cate_id'] == $key['cate_id']) {
                $output .= ' current';
            }
            $output .= '"><a href="' . url('Products', 'Index', array('cate_id' => $key['cate_id'])) . '">' . $key['name'] . '</a></li>';   
        }
    }


    return $output;
} 
