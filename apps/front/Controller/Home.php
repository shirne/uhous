<?php
/**
 * 首页页面控制器
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

class Controller_Home extends Controller_Base
{
    /**
     * 产品模型 
     * 
     * @var mixed
     * @access private
     */
    private $modelProducts;
    /**
     * 广告模型 
     * 
     * @var mixed
     * @access private
     */
    private $modelAdvertise;
    /**
     * 构造函数 
     * 
     * @access protected
     * @return void
     */
    function __construct()
    {
        parent::__construct();
        /**
         * 实例化产品模型 
         */
        $this->modelProducts =& FLEA::getSingleton('Model_Products');
        /**
         * 实例化广告模型 
         */
        $this->modelAdvertise =& FLEA::getSingleton('Model_Advertises');
    }
    /**
     * 首页视图 
     * 
     * @access public
     * @return void
     */
    function actionIndex()
    {
        $where = array(
            array('col_key', 'focus'),
            array('lang', getLanguage())
        );

        $data['ads'] = $this->modelAdvertise->getAll($where, 'sort_id DESC', 'title, url, pic' ,null);
        
        $where = array(
            array('col_key', 'products'),
            array('lang', getLanguage()),
            array('display', 1)
        );

        $data['newprod'] = $this->modelProducts->getAll($where, 'selled DESC', 'name,discount, pro_id, pic, price, retail, cate_id, selled', 9, false);

        $where = array(
            array('col_key', 'products'),
            array('lang', getLanguage()),
            array('display', 1)
        );

        $data['products'] = $this->modelProducts->getAll($where, 'selled DESC', 'name, pro_id, pic, price, retail, cate_id, selled', 7, false);

        $this->_executeView('home.html', $data);
    }
    
    //重新裁剪图片,使用时加上前缀action
    function ViewPhoto(){
    	
    	$uploadfolder='uploads/';
    	
    	
    	$data=$this->modelProducts->getAll();
    	foreach($data as $key=>$val){
    		echo $val['pic'].'	';
    		echo $this->resizeImage($val['pic'],210,158,true);
    		echo '<br />';
    	}
    	echo 'over<br />';
    	
    	$modelPhoto=& FLEA::getSingleton('Model_Photos');
    	$data=$modelPhoto->getAll();
    	foreach($data as $key=>$val){
    		echo $val['pic'].'	';
    		echo $this->resizeImage($val['pic'],92,52,true);
    		echo '<br />';
    	}
    	echo 'over';
    	exit;
    }
    
    function resizeImage($file,$width,$height,$nocut=true){
    	$uploadfolder='uploads/';
    	FLEA::loadHelper('image');
    	$image =& FLEA_Helper_Image::createFromFile($uploadfolder.$file, 'jpg');
        /**
         * 开始裁剪图片 
         */
        if ($nocut) {
            $image->crop($width, $height, true, true);
        } else {
            $image->crop($width, $height, true);
        }
        /**
         * 获得文件名
         */
        $filename = 'thumb_'.$file;
        /**
         * 保存文件 
         */
        $image->saveAsJpeg($uploadfolder . $filename);
        /**
         * 删除原图
         */
        $image->destory();
    	return $filename;
    }
    
    /**
     * 错误页
     */
    function actionError()
    {
    	header('Status: 404 Not Found');
    	$data['tips']['title'] = '页面没有找到';
		$data['tips']['description'] = '您访问的页面不存在或已经删除！';
		$data['tips']['url'] = url('Home');

		$this->_executeView('tips.html', $data);
    }
}
