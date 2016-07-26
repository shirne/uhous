<?php

/**
 * 管理员管理模型
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Model
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

//{{ 载入 RBAC 用户管理基类
FLEA :: loadClass('FLEA_Rbac_UsersManager');
//}}

class Model_Admin extends FLEA_Rbac_UsersManager {
	/**
	 * 表名
	 *
	 * @var string
	 * @access public
	 */
	public $tableName = 'admin';
	/**
	 * 主键
	 *
	 * @var string
	 * @access public
	 */
	public $primaryKey = 'admin_id';
	/**
	 * 用户名字段名
	 * 
	 * @var string
	 * @access public
	 */
	public $usernameField = 'username';
	/**
	 * 用户密码字段名
	 * 
	 * @var string
	 * @access public
	 */
	public $passwordField = 'password';
	/**
	 * E-mail 字段名
	 * 
	 * @var string
	 * @access public
	 */
	public $emailField = 'email';
	/**
	 * 角色字段名
	 * 
	 * @var string
	 * @access public
	 */
	public $rolesField = 'roles';
	/**
	 * 用户密码加密方式
	 * 
	 * @var string
	 * @access public
	 */
	public $encodeMethod = PWD_MD5;
	/**
	 * 用户登录数据字段名
	 * 
	 * @var array
	 * @access public
	 */
	public $functionFields = array (
		'registerIpField' => 'register_ip',
		'lastLoginField' => 'last_login',
		'lastLoginIpField' => 'last_login_ip',
		'loginCountField' => 'login_count'
	);
	/**
	 * 多对多关系，一个管理员拥有多个角色
	 * 
	 * @var array
	 * @access public
	 */
	public $manyToMany = array (
		array (
			'tableClass' => 'Model_Roles',
			'mappingName' => 'roles',
			'joinTable' => 'admin_has_roles',
			'fields' => array (
				'role_id',
				'label',
				'name'
			)
		)
	);
	/**
	 * 检查超时状态
	 * 
	 * @param mixed $redirect 跳转视图
	 * @access public
	 */
	function checkout($redirect = null) {
		/**
		 * 实例化 RBAC 角色访问控制器
		 */
		$rbac = & FLEA :: getSingleton('FLEA_Rbac');
		/**
		 * 没有角色时跳转至指定视图
		 */
		if (!$rbac->getUser()) {
			js_alert('登录超时!', 0, url($redirect));
		}
	}
	/**
	 * 检查登录状态
	 * 
	 * @param mixed $redirect 跳转视图
	 * @access public
	 */
	function check($redirect = null) {
		/**
		 * 实例化 RBAC 角色访问控制器
		 */
		$rbac = & FLEA :: getSingleton('FLEA_Rbac');
		/**
		 * 拥有角色时跳转至指定视图
		 */
		if ($rbac->getUser()) {
			redirect(url($redirect));
		}
	}
	/**
	 * 登录用户
	 * 
	 * @param string $username 登录账号
	 * @param string $password 登录密码
	 * @access public
	 * @return array|boolean
	 */
	function login($username, $password) {
		// 验证用户信息
		$userData = $this->validateUser($username, $password, true);
		// 验证成功
		if ($userData) {
			// 获得管理员的角色信息
			$role = $this->fetchRoles($userData);
			$rbacUser = array (
				'id' => $userData[$this->primaryKey],
				'username' => $userData[$this->usernameField],
				'roles' => $role
			);
			// 实例化 Rbac 访问控制类
			$rbac = FLEA :: getSingleton('FLEA_Rbac');
			// 设置访问权限
			$rbac->setUser($rbacUser, $role);
			/**
			 * 返回登录成功
			 */
			return true;
		} else { // 验证失败
			return false;
		}
	}
	/**
	 * 按主键(集)删除用户
	 * 
	 * @param array $pkvs 主键/集
	 * @access public
	 * @return void
	 */
	function removeUsersByPkvs($pkvs) {
		if (!$pkvs) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_PkvsNotFound');
			//}}
			// 抛出异常
			__THROW(new Exception_PkvsNotFound('管理员'));
			return;
		} else {
			/**
			 * 查询用户
			 */
			$users = $this->findAll(array (
				'in()' => $pkvs
			), null, null, 'admin_id', false);
		}
		/**
		 * 没找到用户并抛出异常
		 */
		if (!$users) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_UsersNotFound');
			//}}
			// 抛出异常
			__THROW(new Exception_UsersNotFound($pkvs));
			return;
		}
		/**
		 * 返回删除结果
		 */
		return $this->removeByPkvs($pkvs);
	}
	/**
	 * 注销登录
	 * 
	 * @access public
	 */
	function logout() {
		/**
		 * 实例化 RBAC 角色访问控制器
		 */
		$rbac = & FLEA :: getSingleton('FLEA_Rbac');
		// 清除登录状态
		$rbac->clearUser();
		js_alert('注销成功!', 0, url());
	}
	/**
	 * 构造角色管理的栏目
	 * 
	 * @param mixed $role 角色
	 * @access protected
	 * @return array
	 */
	function buildColumns($role) {
		/**
		 * 管理员管理所有栏目
		 */
		if (in_array('ADMIN', $role)) {
			/**
			 * 实例化栏目管理模型
			 */
			$modelColumns = & FLEA :: getSingleton('Model_Columns');
			/**
			 * 返回栏目树
			 */
			return $modelColumns->getTree();
		} else {
			/**
			 * 实例化角色管理模型
			 */
			$modelRole = & FLEA :: getSingleton('Model_Roles');
			/**
			 * 读取角色所管理的栏目树
			 */
			return $modelRole->findRolesColumns($role);
		}
	}
}