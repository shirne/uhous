<?php
/**
 * 后台管理员控制器
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/
class Controller_Admin extends Controller_Base
{
    /**
     * 管理员管理模型
     * 
     * @var Model_Admin
     * @access private
     */
    private $modelAdmin = null;

    /**
     * 管理员角色管理模型
     * 
     * @var Model_Roles
     * @access private
     */
    private $modelRole = null;

    /**
     * 构造函数
     */
    function __construct()
    {
        // 执行父类构造函数
        parent::__construct();
        // 实例化管理员管理模型
        $this->modelAdmin =& FLEA::getSingleton('Model_Admin');
        // 实例化管理员角色管理模型
        $this->modelRole =& FLEA::getSingleton('Model_Roles');
    }

    /**
     * 管理员登录视图
     */
    function actionIndex()
    {
        /**
         * 检查用户是否登录，已登录则跳转至控制台视图
         */
        $this->modelAdmin->check('Dashboard');
        // 显示登录视图
        $this->_executeView('core/login.tpl');
    }

    /**
     * 管理员密码修改
     */
    function actionProfile()
    {
        /**
         * 实例化 Rbac 角色访问控制器类
         */
        $rbac =& FLEA::getSingleton('FLEA_Rbac');
        /**
         * 获得用户登录数据
         */
        $data['user'] = $rbac->getUser();
        /**
         * 设置当前视图为返回页面
         */
        $this->_setBack();
        // 显示登录视图
        $this->_executeView('core/user-profile.tpl', $data);
    }

    /**
     * 管理员登录方法
     */
    function actionLogin()
    {
        /**
         * 检查用户是否登录，已登录则跳转至控制台视图
         */
        $this->modelAdmin->check('Dashboard');
        // 实例化图形验证码助手类
        $imgcode =& FLEA::getSingleton('FLEA_Helper_ImgCode');
        if (!$imgcode->check(trim($_POST['imgcode']))) {
            // 清空图形验证码
            $imgcode->clear();
            js_alert('验证码错误!', 'history.back(-1)');
        }
        // 验证管理员
        if ($this->modelAdmin->login(trim($_POST['username']), trim($_POST['password']))) {
            js_alert('登录成功!', 0, url('Dashboard'));
        }
        // 清空图形验证码
        $imgcode->clear();
        js_alert('用户名或用户密码错误!', 'history.back(-1)');
    }

    /**
     * 注销登录
     */
    function actionLogout()
    {
        /**
         * 注销登录
         */
        $this->modelAdmin->logout();
    }

    /**
     * 管理员列表视图
     */
    function actionUsers()
    {
        /**
         * 获得所有管理员数据
         */
        $data['users'] = $this->modelAdmin->findAll(
            null,
            null,
            null,
            'admin_id, username, last_login, last_login_ip, login_count'
        );
        /**
         * 设置当前视图为返回页面
         */
        $this->_setBack();
        /**
         * 输出管理员列表视图
         */
        $this->_executeView('core/user-list.tpl', $data);
    }

    /**
     * 添加管理员视图
     */
    function actionNewUser()
    {
        /**
         * 获得管理员资料表的元信息
         */
        $data['user'] = $this->_prepareData($this->modelAdmin->meta);
        /**
         * 实例化角色管理模型
         */
        $modelRoles =& FLEA::getSingleton('Model_Roles');
        /**
         * 获得所有管理角色
         */
        $roles = $modelRoles->findAll(null, null, null, 'role_id, label');
        /**
         * 转换角色列表为哈希表
         */
        if ($roles) {
            $data['roles'] = array_to_hashmap($roles, 'label', 'role_id');
        }
        /**
         * 输出管理员资料编辑视图
         */
        $this->_executeView('core/user-modify.tpl', $data);
    }

    /**
     * 编辑管理员资料视图
     */
    function actionModifyUser()
    {
        /**
         * 获得管理员的详细资料
         */
        $data['user'] = $this->modelAdmin->find(
            (int)$_GET['id'],
            null,
            'admin_id, username'
        );
        /**
         * 实例化角色管理模型
         */
        $modelRoles =& FLEA::getSingleton('Model_Roles');
        /**
         * 获得所有管理角色
         */
        $roles = $modelRoles->findAll(null, null, null, 'role_id, label');
        /**
         * 转换角色列表为哈希表
         */
        if ($roles) {
            $data['roles'] = array_to_hashmap($roles, 'label', 'role_id');
        }
        /**
         * 输出管理员资料编辑视图
         */
        $this->_executeView('core/user-modify.tpl', $data);
    }

    /**
     * 创建管理员
     */
    /**
     * 创建管理员
     * 
     * @param $&row
     * @access public
     */
    function createUser(& $row)
    {
        /**
         * 必填数据
         */
        $row['email'] = $row['username'] . '@domain.com';
        $time = explode(' ', microtime());
        $row['last_login'] = $time[1];
        $row['roles'] = array(
            array(
                'role_id' => $_POST['roles']
            )
        );
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 创建新管理员
         */
        $this->modelAdmin->create($row);
        /**
         * 获取抛出的异常
         */
        $ex = __CATCH();
        /**
         * 判断是否是一个异常
         */
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), 0, $this->_getBack());
        }
        /**
         * 返回上一页面
         */
        $this->_goBack();
    }

    /**
     * 修改管理员密码
     */
    function actionChangePassword()
    {
        $row =& $_POST;
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 更改密码
         */
        if ($row['password']) {
            $this->modelAdmin->updatePasswordById($row['admin_id'], $row['password']);
        }
        /**
         * 获取抛出的异常
         */
        $ex = __CATCH();
        /**
         * 判断是否是一个异常
         */
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), 0, $this->_getBack());
        }
        /**
         * 返回上一页面
         */
        $this->_goBack();
    }

    /**
     * 保存管理员资料
     */
    function actionSaveProfile()
    {
        /**
         * 创建新管理员
         */
        if (!$_POST['admin_id']) {
            $this->createUser(&$_POST);
            exit();
        }
        /**
         * 处理角色
         */
        $row =& $_POST;
        $row['roles'] = array(
            array(
                'role_id' => $_POST['roles']
            )
        );
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 更改密码
         */
        if ($row['password']) {
            $this->modelAdmin->updatePasswordById($row['admin_id'], $row['password']);
        }
        /**
         * 更新管理员资料，不会更新密码
         */
        $this->modelAdmin->update($row);
        /**
         * 获取抛出的异常
         */
        $ex = __CATCH();
        /**
         * 判断是否是一个异常
         */
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), 0, $this->_getBack());
        }
        /**
         * 返回上一页面
         */
        $this->_goBack();
    }

    /**
     * 删除管理员
     */
    function actionRemove()
    {
        /**
         * 按主键删除单个管理员
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个管理员
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 按主键(集)删除管理员
         */
        $this->modelAdmin->removeUsersByPkvs($pkvs);
        /**
         * 获取抛出的异常
         */
        $ex = __CATCH();
        /**
         * 判断是否是一个异常
         */
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), 0, $this->_getBack());
        }
        /**
         * 返回上一页面
         */
        $this->_goBack();
    }

    /**
     * 管理员角色列表视图
     */
    function actionRoles()
    {
        /**
         * 获得所有角色数据
         */
        $data['roles'] = $this->modelRole->findAll(
            null,
            null,
            null,
            'role_id, label, name'
        );
        /**
         * 设置当前视图为返回页面
         */
        $this->_setBack();
        /**
         * 输出管理员角色列表视图
         */
        $this->_executeView('core/role-list.tpl', $data);
    }

    /**
     * 创建新角色
     */
    function actionNewRole()
    {
        /**
         * 获得角色的元信息
         */
        $data['role'] = $this->_prepareData($this->modelRole->meta);
        /**
         * 获得一个新的角色识别名称
         */
        $data['role']['name'] = $this->modelRole->newRoleName();
        /**
         * 输出角色编辑视图
         */
        $this->_executeView('core/role-modify.tpl', $data);
    }

    /**
     * 修改角色资料
     */
    function actionModifyRole()
    {
        /**
         * 获得角色资料
         */
        $data['role'] = $this->modelRole->find(
            (int)$_GET['id'],
            null,
            'role_id, label, name'
        );
        /**
         * 获得应用该角色的管理员
         */
        $data['users'] = $this->modelAdmin->findAll(
            array(
                array('roles.role_id', (int)$_GET['id'])
            ),
            null,
            null,
            'admin_id, username',
            false
        );
        /**
         * 输出角色编辑视图
         */
        $this->_executeView('core/role-modify.tpl', $data);
    }

    /**
     * 保存角色
     */
    function actionSaveRole()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存角色数据
         */
        $this->modelRole->save($_POST);
        /**
         * 获取抛出的异常
         */
        $ex = __CATCH();
        /**
         * 判断是否是一个异常
         */
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), 0, $this->_getBack());
        }
        /**
         * 返回上一页面
         */
        $this->_goBack();
    }

    /**
     * 删除角色
     */
    function actionRemoveRole()
    {
        /**
         * 按主键删除单个角色
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个角色
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 按主键(集)删除角色
         */
        $this->modelRole->removeRolesByPkvs($pkvs);
        /**
         * 获取抛出的异常
         */
        $ex = __CATCH();
        /**
         * 判断是否是一个异常
         */
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), 0, $this->_getBack());
        }
        /**
         * 返回上一页面
         */
        $this->_goBack();
    }

    /**
     * 角色权限设置
     */
    function actionCompetence()
    {
        /**
         * 实例化栏目管理模型
         */
        $modelColumn =& FLEA::getSingleton('Model_Columns');
        /**
         * 获得整站栏目树
         */
        $data['columns'] = $modelColumn->getTree();
        /**
         * 设置关联栏目查询字段
         */
        $columnLink = $this->modelRole->getLink('columns');
        $columnLink->fields = array('col_id');
        /**
         * 获得角色资料
         */
        $data['role'] = $this->modelRole->find(
            (int)$_GET['id'],
            null,
            'role_id, label, name'
        );
        if ($data['role']['columns']) {
            $data['role']['columns'] = array_col_values($data['role']['columns'], 'col_id');
        }
        /**
         * 获得整站语言版本
         */
        $data['languages'] = FLEA::getAppInf('languages');
        $data['languagesCount'] = count($data['languages']);
        /**
         * 输出角色权限设置视图
         */
        $this->_executeView('core/role-competence.tpl', $data);
    }

    /**
     * 保存权限设置
     */
    function actionSaveCompetence()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存权限设置
         */
        $this->modelRole->saveCompetence(&$_POST);
        /**
         * 获取抛出的异常
         */
        $ex = __CATCH();
        /**
         * 判断是否是一个异常
         */
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), 0, $this->_getBack());
        }
        /**
         * 返回上一页面
         */
        $this->_goBack();
    }

    /**
     * 输出图形验证码
     */
    function actionImgCode()
    {
        // 实例化图形验证码助手类
        $imgcode =& FLEA::getSingleton('FLEA_Helper_ImgCode');
        // 生成验证码图片
        $imgcode->image(2);
    }
    
    //后台任务统一调度器
    function actionbackRun(){
        if(!isset($_GET['job'])){
            die('没有任务');
        }else{
            $job='_job'.$_GET['job'];
        }
        $option=&FLEA::getSingleton('Model_Options');
        $pass=$option->getOption('jobencrypt');
        if(empty($_GET['pass']) || $pass['jobencrypt']['value'] != $_GET['pass']){
            die('Access Dined');
        }
        $rc=new ReflectionClass(__CLASS__);
        if($rc->hasMethod($job)){
            $this->$job();
        }else{
            die('Job not found');
        }
    }
    
    private function _jobText(){
        echo 'success';
    }
    
    private function _jobsendemail(){
        set_time_limit(0);
        ignore_user_abort(true);
        $modelUser=&FLEA::getSingleton('Model_Members');
        $modelUser->getTable()->updateField(array(array('email','')),'email',null);
        $where=array(
            array('email',NULL,'IS NOT'),
            array('receivemail',1)
        );
        $users=$modelUser->getAll($where,null,'username,realname,email',null,false);
        
        //获取smtp配置
        $cfg=array();
        $setting= & FLEA :: getSingleton('Model_Options');
		$cfg['user'] = $setting->getOption('email');
		$cfg['pass'] = $setting->getOption('pass');
		$cfg['smtp'] = $setting->getOption('smtp');
		$cfg['port'] = $setting->getOption('port');
		$cfg['site'] = $setting->getOption('sitename');
		$cfg['user'] = $cfg['user']['email']['value'];
		$cfg['pass'] = $cfg['pass']['pass']['value'];
		$cfg['smtp'] = $cfg['smtp']['smtp']['value'];
		$cfg['port'] = $cfg['port']['port']['value'];
		$cfg['site'] = $cfg['site']['sitename']['value'];
        
        //获取页面内容
        $cfg['sbody']=file_get_contents(str_replace('sysadm/','','http://'.$_SERVER['SERVER_NAME'].url('products','newprodcontent')));
        $cfg['subject']='新品发布';
        
        //{{ 载入类
		FLEA :: loadClass('Helper_Phpmailer');
		//}}
		
        foreach($users as $u){
            $cfg['sendTo'] = $u['email'];
            $cfg['body'] = str_replace('$email$',$cfg['sendTo'],$cfg['sbody']);
            $cfg['name'] = empty($u['realname'])?$u['username']:$u['realname'];
            $this->sendemail($cfg);
            usleep(10);
        }
        
    }
    
    private function sendemail($cfg){
        
		$mail = new Helper_Phpmailer();
		$mail->CharSet = 'utf-8';
		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host = $cfg['smtp']; // specify main and backup server
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->Username = $cfg['user']; // SMTP username
		$mail->Password = $cfg['pass']; // SMTP password

		$mail->From = $cfg['user'];
		$mail->FromName = "车水马龙公司";
		$mail->AddAddress("{$cfg['sendTo']}", $cfg['name']);

		$mail->IsHTML(true); // set email format to HTML

		$mail->Subject = $cfg['subject'] . $cfg['site'];
		$mail->Body = $cfg['body'];
		
		return $mail->Send();

    }
}

