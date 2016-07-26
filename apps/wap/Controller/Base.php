<?php
/*
 * Created on 2012-3-13
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Controller_Base extends FLEA_Controller_Action
{
    /**
     * 构造函数
     */
    function __construct() {
        // 加载系统配置信息
        $this->loadOptions();
    }
    
    
    /**
     * 载入系统配置信息
     *
     * @param boolean $reload
     * @access public
     */
    public function loadOptions($reload = false)
    {
        // 设置超时时间
        $lifetime = FLEA::getAppInf('lifetime');
        if ($reload) {
            $lifetime = 0;
        }
        // 缓存配置信息
        $cacheid = 'options.wap';
        $options = FLEA::getCache($cacheid, $lifetime, true, true);
        if (!is_array($options)) {
            $modelOptions = FLEA::getSingleton('Model_Options');
            $options = $modelOptions->getOption();
            FLEA::writeCache($cacheid, $options, true);
            unset($modelOptions);
        }
        FLEA::setAppInf('options', $options);
    }
    
    
    
    public function _executeView($tmp, $data=null)
    {
    	$data['language'] = getLanguage();
        $data['user'] = $this->_dispatcher->getUser();
        $data['pageindex'] = 0;
        if($_GET['column']=='products'){
        	$data['pageindex'] = 1;
        	if($_GET['do']=='brand')$data['pageindex'] = 2;
        }
        if($_GET['column']=='download'){
        	$data['pageindex']==3;
        }
    	parent::_executeView($tmp, $data);
    }
    
    public function _error($msg = null, $title = null, $url = null, $status='400 Bad Request') {
		header('Status: '.$status);
		
		if(!$msg)$msg='请求处理错误,自动返回<a href="/">首页</a>';
		if(!$title)$title='错误';
		if(!$url)$url=url('Home','Index');
		
		$data=array();
		$data['message']=$msg;
		$data['title']=$title;
		$data['url']=$url;
		
		$this->_executeView('tips.xhtml', $data);
	}
}
?>
