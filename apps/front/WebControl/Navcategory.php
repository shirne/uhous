<?php
/**
 * 产品分类控件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     jayzone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

function _ctlNavcategory($name, $attribs)
{
    $opts = array('cate_id');
    $data = FLEA_WebControls::extractAttribs($attribs, $opts);
    FLEA_WebControls::mergeAttribs( $attribs );

    /**
     * 实例化分类模型 
     */
    $modelCategories =& FLEA::getSingleton('Model_Categories');
    /**
     * 获得当前分类ID 
     */
    $currentFCateId = (int)$data['cate_id'];
    /**
     * 得到所有分类 
     */
    //$topCates = $modelCategories->getTopCates(0, 'cate_id, name, enname', 'products');
    $topCates = $modelCategories->getAll(array('col_key'=>'products'),'parent_id ASC,sort_id ASC,cate_id asc', 'cate_id,parent_id, name, enname');
    /**
     * 取出二级分类
     */
    $subcates=array();
    foreach($topCates as $key=>$cate){
    	if($cate['parent_id']>0){
    		if($currentFCateId==$cate['cate_id']){
    			$currentFCateId=$cate['parent_id'];
    			$currentCateId=$cate['cate_id'];
    		}
    		$subcates[$cate['parent_id']][]=$cate;
    		unset($topCates[$key]);
    	}
    }

    /**
     * 输出分类 
     */
    $output[] = "<ul class=\"nav-menu clearfix\">";
    $fcatestr='<li class="fmenu {$isactive}"><a class="fmenu" href="{$url}"><span class="ico {$ennamelower}"></span><br /><span class="en">{$ennameupper}</span><br />{$catename}</a>';
    $scatestr='<li {$isactive}><a href="{$url}">{$catename}&nbsp;&nbsp;|&nbsp;&nbsp;<span class="en">{$ennameupper}</span></a></li>';
    foreach ($topCates as $cate) {
    	$icoclass=strtolower($cate['enname']);
    	$catestr=strtoupper($cate['enname']);
        $output[] = str_replace(array(
		        '{$isactive}',
		        '{$url}',
		        '{$ennamelower}',
		        '{$catename}',
		        '{$ennameupper}'
	        ),array(
		        $currentFCateId == $cate['cate_id']?'active':'',
		        url('Products', 'Index', array('cate_id' => $cate['cate_id'])),
		        strtolower($cate['enname']),
		        $cate['name'],
		        strtoupper($cate['enname'])
	        ),$fcatestr
	    );
        
        /**
         * 输出子分类
         */
        if(isset($subcates[$cate['cate_id']])){
        	$output[] = '<div class="subcate"><span class="cor"></span><ul>';
        	foreach($subcates[$cate['cate_id']] as $subcate){
        		$output[] = str_replace(array(
				        '{$isactive}',
				        '{$url}',
				        '{$ennamelower}',
				        '{$catename}',
				        '{$ennameupper}'
			        ),array(
				        $currentCateId == $subcate['cate_id']?' class="active" ':'',
				        url('Products', 'Index', array('cate_id' => $subcate['cate_id'])),
				        strtolower($subcate['enname']),
				        $subcate['name'],
				        strtoupper($subcate['enname'])
			        ),$scatestr
			    );
        	}
        	$output[] = '</ul></div>';
        }
        $output[] = '</li>';
    }
    $output []= "</ul>";

    return implode('',$output);
}
