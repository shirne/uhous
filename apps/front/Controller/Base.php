<?php
/**
 * 后台控制器基类
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/
class Controller_Base extends FLEA_Controller_Action
{
    /**
	 * 购物车
	 */
	protected $modelCart;
    /**
     * 构造函数
     * 
     * @access public
     */
    function __construct() {
        // 加载系统配置信息
        $this->loadOptions();
        if(!isset($_SESSION['www']))$_SESSION['www']=true;
        
        $this->modelCart = & FLEA :: getSingleton('Model_Cart');
      
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
        $cacheid = 'options.system';
        $options = FLEA::getCache($cacheid, $lifetime, true, true);
        if (!is_array($options)) {
            $modelOptions = FLEA::getSingleton('Model_Options');
            $options = $modelOptions->getOption();
            FLEA::writeCache($cacheid, $options, true);
            unset($modelOptions);
        }
        FLEA::setAppInf('options', $options);
    }

    /**
     * 获取Seo信息
     */
    protected function _loadSeoInfo($configs = null)
    {
        $data['seo_title'] = '';
        $data['keyword'] = _getOption('keyword');
        $data['description'] = _getOption('description');

        if ($configs) {

            if ($configs['model']) {
                $model =& FLEA::getSingleton($configs['model']);
            }

            if ($configs['column']) {

                switch ($configs['column']) {
                    case 'product':

                        if ($configs['id']) {

                            $proInfo = $model->getOne(array(array('pro_id', $configs['id'])), null, 'name, pro_id, seo_title, keyword, description');

                            if ($proInfo) {
                                $data['seo_title'] .= $proInfo['name'];
                                $data['seo_title'] .= ' - '.$proInfo['category']['name'];
                                if ($proInfo['seo_title']) {
                                    $data['seo_title'] .= ' - '.$proInfo['seo_title'];
                                }
                                if ($proInfo['keyword']) {
                                    $data['keyword'] = $proInfo['keyword'];
                                }
                                $data['description'] = $proInfo['description'] ? $proInfo['description'] : $data['description'];
                                    
                            }
                        } else {

                            if ($configs['cate_id']) {

                                $modelCategories =& FLEA::getSingleton('Model_Categories');
                                $cateInfo = $modelCategories->getOne(array(array('cate_id', $configs['cate_id'])), null, 'cate_id, name', false);

                                $data['seo_title'] .= $cateInfo['name'];
                                $title = _getOption('title');
                                if ($title) {
                                    $data['seo_title'] .= ' - ' . $title;
                                }
                            }
                        }

                        break;
                    
                    default:

                        break;
                }
            }

            return $data;

        } else {

            return;
        }
    }
    /**
     * 根据数据表的元数据返回一个数组，这个数组包含所有需要初始化的数据，可以用于界面显示
     * 
     * @param & $&meta
     * @access protected
     * @return array
     */
    protected function _prepareData(& $meta) {
        $data = array();
        foreach ($meta as $m) {
            if (isset($_POST[$m ['name']])) {
                $data[$m['name']] = $_POST[$m['name']];
            } else {
                if (isset($m['defaultValue'])) {
                    $data[$m['name']] = $m['defaultValue'];
                } else {
                    $data[$m['name']] = null;
                }
            }
        }
        return $data;
    }
    /**
     * 返回用 _setBack() 设置的 URL
     * 
     * @access protected
     */
    protected function _goBack() {
        $url = $this->_getBack();
        unset($_SESSION['BACKURL']);
        redirect ($url);
    }

    /**
     * 设置返回点 URL，稍后可以用 _goBack() 返回
     * 
     * @access protected
     */
    protected function _setBack() {
        //$_SESSION['BACKURL'] = $_SERVER['QUERY_STRING'];
        $_SESSION['BACKURL'] = $this->_url();#$_SERVER['PATH_INFO'];
    }

    /**
     * 获取返回点 URL
     * 
     * @access protected
     * @return string
     */
    protected function _getBack() {
        if (isset($_SESSION['BACKURL'])) {
            return $_SESSION['BACKURL'];
            #$url = $this->rawurl($_SESSION['BACKURL']);
        } else {
            $url = $this->_url();
        }
        return $url;
    }

    /**
     * 直接提供查询字符串，生成 URL 地址
     * 
     * @param mixed $queryString 
     * @access protected
     * @return string
     */
    protected function rawurl($queryString) {
        if (substr($queryString, 0, 1) == '/') {
            $queryString = substr($queryString, 1);
        }
        return $_SERVER['SCRIPT_NAME'] . '/' . $queryString;
    }
    
    function _error($desc='未知错误',$url='',$title='系统信息'){
        if(empty($url))$url=url('home');
        
        $data['tips']['title'] = $title;
		$data['tips']['description'] = $desc;
		$data['tips']['url'] = $url;
        
        $this->_executeView('tips.html',$data);
    }

    /**
     * 调用视图
     * 
     * @param mixed $tplname
     * @param mixed $viewdata
     * @access public
     */
    function _executeView($tplname, $viewdata = null)
    {
        /**
         * 设置系统变量
         */
        $viewdata['language'] = getLanguage();
        $viewdata['user'] = $this->_dispatcher->getUser();
        $viewdata['cartnum']=$this->modelCart->count();
        /**
         * 输出模板视图
         */
        parent::_executeView($tplname, $viewdata);
    }
    
    function sendSysEmail($config){
        include ('../../front/Helper/Phpmailer.php');
		$options = array ();
		$optrow = mysql_query("SELECT * FROM {$db_config['dbTablePrefix']}options ORDER BY opt_id ASC");

		while ($row = mysql_fetch_array($optrow)) {
			$options[$row['name']] = $row['value'];
		}

		if (empty ($options['tipemail'])) {
			return true;
		}

		$mail = new Helper_Phpmailer();
		$mail->CharSet = 'utf-8';
		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host = $options['smtp']; // specify main and backup server
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->Username = $options['email']; // SMTP username
		$mail->Password = $options['pass']; // SMTP password

		$mail->From = $options['email'];
		$mail->FromName = "系统消息";
		$mail->AddAddress("{$options['tipemail']}", "");
		$mail->IsHTML(true); // set email format to HTML

		$mail->Subject = '订单提醒:订单号为:' . $order_no . '的订单已付款,请及时处理';
		$mail->Body = '订单提醒:订单号为:' . $order_no . '的订单已付款,请及时处理';

		$mail->Send();
    }
}

function _getOption($key)
{
    $modelOptions =& FLEA::getSingleton('Model_Options');
    $opt = $modelOptions->getOption($key);
    return $opt[$key]['value'];
}
