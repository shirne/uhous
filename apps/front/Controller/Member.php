<?php


/**
 * 会员信息控制器 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 */
class Controller_Member extends Controller_Base {
	/**
	 * 信息提示 
	 * 
	 * @var array
	 * @access private
	 */
	private $tips = array (
		'title' => null,
		'description' => null,
		'url' => null,
	);
	/**
	 * 当前会员信息 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $member;
	/**
	 * 会员模型 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $modelMembers;
	private $modelProducts;
	
	/**
	 * 验证信息的sessionkey
	 */
	private $sessioncode='createcheckcode';
	private $sessionemail='createemail';
	private $sessionuser='checkuserid';
	
	/**
	 * 构造函数 
	 * 
	 * @access protected
	 * @return void
	 */
	function __construct() {
		parent :: __construct();
		/**
		 * 初始化信息提示 
		 */
		$this->tips['title'] = '系统信息';
		/**
		 * 实例化会员模型 
		 */
		$this->modelMembers = & FLEA :: getSingleton('Model_Members');

		$this->modelProducts = & FLEA :: getSingleton('Model_Products');
		
		
	}
	
	/**
     * 获取已登陆用户信息 
     */
	function getUser(){
	    $this->member=$this->_dispatcher->getUser();
	}

	/**
	 * 信息相关功能 
	 * --------------------------------------------------------- */

	/**
	 * 会员中心面板 
	 * 
	 * @access public
	 * @return void
	 */
	function actionIndex() {
		$this->getUser();
		/**
		 * 已登陆
		 */
		if (!empty ($this->member)) {

			$where = array (
				array (
					'col_key',
					'member'
				),
				array (
					'lang',
					getLanguage()
				),
				array (
					'member_id',
					$this->member['id']
				)
			);

			$data['member'] = $this->modelMembers->getOne($where, null, '*');

			//如果用户密码为空且openID不为空则判定用户资料未完善
			if (empty ($data['member']['password']) && !empty ($data['member']['openID'])) {
				$_SESSION['notperf'] = true;
			}else{
			    unset($_SESSION['notperf']);
			}

			$tblOrders = & FLEA :: getSingleton('Table_Orders');

			$data['order_num'] = $tblOrders->findCount(array (
				array (
					'member_id',
					$this->member['id']
				)
			));

			$this->_executeView('member.html', $data);

		} else {

			header("Location:" . url('Member', 'Login'));
		}
	}
	
	/**
	 * 获取邀请码(发送到指定邮箱)
	 */
	function actionInviteCode(){
		$_SESSION[$this->sessioncode]='';
		$_SESSION[$this->sessionemail]='';
		
		$email=strtolower($_POST['email']);
		$data=array('status'=>1);
		if(preg_match('/^[\w-]+@{1}[\w-]+\.{1}\w{2,4}(\.{0,1}\w{2}){0,1}$/',$email)){
			
			//检查邮箱是否已经注册
			$hasinfo=$this->modelMembers->checkData($email,'email');
			if(empty($hasinfo)){
				
				//生成4-6位随机验证码
				$_SESSION[$this->sessioncode] =$this->_getRandCode(4,6);
	
				$_SESSION[$this->sessionemail]=$email;
				
				$invidedata=array(
				    'randcode'=>$_SESSION[$this->sessioncode],
				    'email'=>$email,
				    'hash'=>md5(time()).$this->_getRandCode(5,20)
				);
				$invider=& FLEA :: getSingleton('Model_Invidecode');
		        $invider->del($email);
		        $invider->save($invidedata);
				
				$configs['sendTo'] = $_POST['email'];
		
				$configs['subject'] = '您在有好事家居申请的注册邀请码--';
		
				$configs['body']  = '亲：<br /><br />';
				$configs['body'] .= '<div style="padding-left: 3%;">';
				$configs['body'] .= '您即将在我们的网站<a href="http://www.uhous.com">有好事家居商城</a>注册帐户<br />';
				$configs['body'] .= '下面是您注册帐户所需要的邀请码<br />';
				$configs['body'] .= $_SESSION['createcheckcode'];
				$configs['body'] .= '<br />注意：一旦您关闭了浏览器或很长时间没有响应本次注册请求，邀请码会自动过期，您需要重新接收验证码<br />';
				$configs['body'] .= '所以，请尽快完成注册，享受我们的服务!<br />';
				$configs['body'] .= '以下是我们的注册页面<br /><a href="http://'.$_SERVER['SERVER_NAME'];
				$configs['body'] .= url('member','login',array('invidecode'=>$invidedata['hash'])).'#reg';
				$configs['body'] .= '" target="_blank">注册有好事家居</a></div>';
		
				if ($info = $this->_sendEmail(& $configs)) {
		
					if ($info['return']) {
						$data['status']=0;
						$data['message']='验证码已发送';
					} else {
						$data['message']='发送失败，请检查您的邮箱或稍后再次发送';
					}
				}
			}else{
				unset($_SESSION[$this->sessioncode]);
				unset($_SESSION[$this->sessionemail]);
				$data['message']='该邮箱已经注册过了,您可以使用该邮箱找回密码';
			}
		}else{
			unset($_SESSION[$this->sessioncode]);
			unset($_SESSION[$this->sessionemail]);
			$data['message']='邮箱格式不正确!';
		}
		
		echo json_encode($data);
	}
	
	/**
	 * 会员注册 
	 * 
	 * @access public
	 * @return void
	 */
	function actionRegister() {
		if (!empty ($_POST)) {

			$profile = $_POST;
			
			//将参数转换成小写
			$profile['email']=strtolower($profile['email']);
			$profile['imgcode']=strtolower($profile['imgcode']);
			

			$data['tips']['title']=$this->tips['title'];
			
			//是否通过检测,不通过的提示信息
			$pass=true;
			$msg="未知原因，注册失败，请稍后再试！";
			
			if(!preg_match('/^[\w-]+@{1}[\w-]+\.{1}\w{2,4}(\.{0,1}\w{2}){0,1}$/',$profile['email'])){
				$msg="邮箱格式不正确";
				$pass=false;
			}
			
			//生成8-14位随机密码
			$password = $this->_getRandCode(8,14);
			$profile['password'] = $password;
			
			//根据邮箱地址填写用户名
			$username=explode('@',$profile['email']);
			$profile['username']=$username[0];
			//如果用户名重复，附加随机字符
			while($this->modelMembers->check($profile['username'])){
				$profile['username'].=$this->_getRandCode(1,1);
			}
			
			
			if($profile['email']=='' || $profile['imgcode']==''){
				$msg="请从邮箱获取验证码后再来注册";
				$pass=false;
			}
			
			if($profile['email']!=$_SESSION[$this->sessionemail] || $profile['imgcode']!=$_SESSION[$this->sessioncode]){
				$msg="请从邮箱获取验证码后再来注册";
				$pass=false;
			}
			
			//设定为已经通过邮箱验证
			$profile['email_check']=1;
			
			if ($pass && $member = $this->modelMembers->getTable()->create($profile)) {
				
				unset($_SESSION[$this->sessioncode]);
				unset($_SESSION[$this->sessionemail]);
				
				$invider=& FLEA :: getSingleton('Model_Invidecode');
				$invider->setok($profile['email']);
				$idata=$invider->getOneByEmail($profile['email'],1);
				
				/**
				 * 构造角色数据
				 */
				$user = array (
					'id' => $member,
					'name' => $profile['username']
				);
				/**
				 * 记录角色
				 */
				$this->_dispatcher->setUser($user);
				/**
				 * 保存登陆时间
				 */
				$this->modelMembers->getTable()->updateField(array (
					array (
						'member_id',
						$member
					)
				), 'lasttime', time());
				
				/**
				 * 赠送优惠卡
				 */
				$coupon=&FLEA:: getSingleton('Model_Coupons');
				$coupon->send($idata['userid']==0?9:8,$member);

				
				/**
				 * 设置提示信息 
				 */
				$data['tips']['description'] = "亲！{$profile['username']} 恭喜您 注册成功";
				if ($_POST['carts'] == 'no') {
					$data['tips']['url'] = $this->_getBack();
				} else {
					$data['tips']['url'] = url("Member");
				}
				
				/**
				 * 发送注册邮件
				 */
				$configs['sendTo'] = $_POST['email'];
	
				$configs['subject'] = '亲!欢迎注册有好事家居商城--';
		
				$configs['body'] = file_getcontents('http://'.$_SERVER['SERVER_NAME'].url('products','emailreg',array('username'=>$profile['username'],'password'=>$password)));
				/*$configs['body'] .= '亲：<br /><br />';
				$configs['body'] .= '<div style="padding-left: 3%;">';
				$configs['body'] .= '恭喜您成功注册<a href="http://www.uhous.com">有好事家居商城</a><br />';
				$configs['body'] .= '下面是您的帐户资料<br />';
				$configs['body'] .= '我们根据您的邮箱将用户名设定为:'.$profile['username'];
				$configs['body'] .= '<br />随机密码为:'.$password;
				$configs['body'] .= '<br />您可以随时登陆网站修改您的个人信息<br />';
				$configs['body'] .= '欢迎再次光临!</div>';*/
		
				if ($info = $this->_sendEmail(& $configs)) {
		
					if ($info['return']) {
						$data['tips']['description'] .= '<br />您的注册信息已发送至邮箱，请注意查收';
					} else {
						//不作自动跳转
						unset($data['tips']['url']);
						$data['tips']['description'] .= '<br />由于邮件发送失败<br />您需要手动记录您的用户资料以便下次使用<br/>我们根据您的邮箱将用户名设定为:'.$profile['username'].
									'<br />随机密码为:'.$password;
					}
				}
				
			}
			else{
				$data['tips']['description'] = $msg;
				$data['tips']['url'] = url('Member', "Login").'#reg';
			}

		} else {

			$data['tips']['description'] = "您提交的数据有误！";
			$data['tips']['url'] = url('Member', "Login").'#reg';
		}

		$this->_executeView('tips.html', $data);
	}
	/**
	 * 登陆功能 
	 * 
	 * @access public
	 * @return void
	 */
	function actionLogin() {
	    $this->getUser();
	    $user = $this->member;
	    
	    //已登陆用户自动跳转到用户中心
	    if(!empty($user) && $user['id']){
	        $this->_error('您已经登陆过了',url('member'));
	    }
	    
		if(!empty($_POST['username']) && !empty($_POST['password'])){
			/**
			 * 查找用户信息 
			 */
			$member = $this->modelMembers->check($_POST['username'], $_POST['password']);

			if (!empty ($member)) {
				/**
				 * 构造角色数据
				 */
				$user = array (
					'id' => $member['member_id'],
					'name' => empty($member['realname'])?$member['username']:$member['realname']
				);
				/**
				 * 保存用户信息 
				 */
				$this->_dispatcher->setUser($user);
				/**
				 * 保存登陆时间
				 */
				$this->modelMembers->getTable()->updateField(array (
					array (
						'member_id',
						$member['member_id']
					)
				), 'lasttime', time());


				$json_data = array (
					'loginStatus' => 1,
					'backurl' => $this->_getBack()
				);

			} else {

				$json_data = array (
					'loginStatus' => 0
				);
			}

			$json_data = json_encode($json_data);
			echo $json_data;

		} else {
		    //从数据库读取已经存在的邀请码
		    if(isset($_GET['invidecode'])){
		        $invider=& FLEA :: getSingleton('Model_Invidecode');
		        $invider->clear();
		        $coder=$invider->getOneByHash($_GET['invidecode']);
		        if(empty($coder)){
		            $this->_error('邀请信息不存在或已过期!您可以在此注册',url('member','login').'#reg');
		        }else if($coder['stat']==1){
		            $this->_error('您已经注册过了，请先登陆',url('member','login'));
		        }else{
		            $_SESSION[$this->sessioncode]=$coder['randcode'];
		            $_SESSION[$this->sessionemail]=$coder['email'];
		        }
		    }
		    
			if(!empty($_SESSION[$this->sessioncode]) &&
				!empty($_SESSION[$this->sessionemail])){
				$data['email']=$_SESSION[$this->sessionemail];
				$data['sendedcode']=1;
			}
			if(empty($data['email']) && isset($_POST['email'])){
			    $data['email']=$_POST['email'];
			}
			$data['col_key'] = 'member';
			$data['lang'] = getLanguage();
			$this->_executeView('reg.html', $data);
		}
	}

	/**
	 * QQ注册用户完善用户信息
	 */
	function actionQQreg() {
	    
		if (empty ($_SESSION['notperf'])) {
			$data['tips']['title'] = $this->tips['title'];
			$data['tips']['description'] = '您的帐户资料已经完善过了！';
			$data['tips']['url'] = url('Member');
			$this->_executeView('tips.html', $data);
		}
		
		$this->getUser();
		
		/**
		 * 已登陆 
		 */
		if (!empty ($this->member)) {
			/**
			 * 条件 
			 */
			$where = array (
				array (
					'member_id',
					$this->member['id']
				),
				array (
					'lang',
					getLanguage()
				),
				array (
					'col_key',
					'member'
				)
			);
			/**
			 * 排序 
			 */
			$sortby = 'member_id ASC';

			$data['memberInfo'] = $this->modelMembers->getOne($where, $sortby, '*', false);
			/**
			 * 处理数据 
			 */
			$data['memberInfo']['date'] = $data['memberInfo']['year'] . '-' . $data['memberInfo']['month'] . '-' . $data['memberInfo']['day'];
			$data['memberInfo']['params'] = unserialize($data['memberInfo']['params']);
			
			$this->_executeView('qqreg.html', $data);

		} else {

			$this->_errorAction(url("Member", "Login"));
		}
	}
	/**
	 * QQ登陆注册相关
	 */
	function actionQQLogin() {
		$qqconfig=FLEA::loadFile('Helper_qqconfig.php');
		
		
		$_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
        $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
            . $qqconfig['appid'] . "&redirect_uri=" . urlencode($qqconfig["callback"])
            . "&state=" . $_SESSION['state']
            . "&scope=".$qqconfig["scope"];
        header("Location:$login_url");
	}

	function actionQQCallback() {
		$qqconfig=FLEA::loadFile('Helper_qqconfig.php');
		FLEA::loadFile('Helper_qqcallback.php');
		
		$acctok=getAccessTocken($_REQUEST['state'],$qqconfig);
		$opid=getOpenid($acctok,$qqconfig);
		
		if( !empty($opid) ){

	        $user=$this->modelMembers->checkData($opid,'openID');
	
	        $hasuser = true;
	        //未绑定用户,注册并绑定
	        if(empty($user)){
		        $userinfo = getUserInfo($qqconfig,$opid,$acctok);
		        
		        //判断用户名是否已经存在,存在则在用户名后附加随机字符
		        while($this->modelMembers->check($userinfo['nickname'])){
		            $userinfo['nickname'].=$this->_getRandCode(1,1);
		        }
		        
		        $row=array(
		            'username'=>$userinfo['nickname'],
		            'sex'=>$userinfo['gender']=='女'?2:1,
		            'openID'=>$opid,
		            'col_key'=>'member',
		            'lang'=>getLanguage()
		        );
		
		        if(!$this->modelMembers->save($row)){
		            $hasuser = false;
		        }
		        
	        }
	        //登陆用户
	        if($hasuser){
		        $user=$this->modelMembers->checkData($opid,'openID');
		        $this->_dispatcher->setUser( array(
			        "id"=>$user['member_id'],
			        "name"=>empty($user['realname'])?$user['username']:$user['realname']
		        ));
		        $this->modelMembers->getTable()->updateField(array (
					array (
						'member_id',
						$user['member_id']
					)
				), 'lasttime', time());
		        
	        }
	        
        }

        echo "<script>window.opener.location.href='".url('member')."';window.close();</script>";
	}
	/**
	 * 邮箱验证
	 * Change At 2012-04-19 17:05:45 
	 * 修改为与注册时邮箱验证一致
	 */
	function actionCheckEmail() {
        $this->getUser();
		if ($this->member) {

			$userId = $this->member['id'];

			$where = array (
				array (
					'col_key',
					'member'
				),
				array (
					'lang',
					getLanguage()
				),
				array (
					'member_id',
					$userId
				)
			);

			$data = $this->modelMembers->getOne($where, null, 'email,email_check', false);
			
			//生成验证码并保存到数据库
			$rowcode=array(
			    'randcode'=>$this->_getRandCode(4,6),
			    'email'=>$data['email'],
			    'hash'=>md5(time()).$this->_getRandCode(5,20),
			    'stat'=>1
			);
			
			$invider=& FLEA :: getSingleton('Model_Invidecode');
	        $invider->del($data['email']);
	        

			if ($data && $data['email_check']==0 && $invider->save($rowcode)) {
			    
				$configs['sendTo'] = $data['email'];
				$configs['user'] = $this->member['name'];
				$configs['member_id'] = $this->member['id'];

				$configs['subject'] = "邮箱认证--";

				$configs['body'] = "亲爱的用户 {$configs['user']}：您好！<br /><br />";
				$configs['body'] .= "<div style='padding-left: 3%;'>";
				$configs['body'] .= "感谢您注册有好事家居，您只需要点击下面链接，激活您的帐户，您便可以享受UHOUS提供的各项服务。<br />";
				$code = $this->_getEmailCheckCode();
				$link = "http://" . $_SERVER['SERVER_NAME'] . url("Member", "Activation", array (
					'check' => $rowcode['hash']
				));
				$configs['body'] .= "<br /><a href=\"{$link}\" title=\"点击此链接激活\">{$link}</a><br /><br />";
				$configs['body'] .= "(如果无法点击该URL链接地址，请将它复制并粘帖到浏览器的地址输入框，然后单击回车即可)<br /><br />";
				$configs['body'] .= "我们将一如既往、热忱的为您服务！<br />";
				$configs['body'] .= "<p><img src=\"http://{$_SERVER['SERVER_NAME']}/themes/default/images/logo.jpg\" /></p>";
				$configs['body'] .= "</div>";

				if ($info = $this->_sendEmail(& $configs)) {

					if ($info['return']) {

						$this->_saveCheckCode($code);

						$json_data = array (
							'success' => 1,
							'email' => $data['email']
						);

					} else {

						$json_data = array (
							'success' => 0,
							'email' => $data['email'],
							'description' => $info['description'],
							'error' => $info['error']
						);
					}

				}

			}
		}
		if(empty($json_data))

			$json_data = array (
				'success' => 0
			);

		echo json_encode($json_data);
	}
	/**
	 * 邮件激活 
	 * 
	 * @access public
	 * @return void
	 */
	function actionActivation() {
		
		$check=$_GET['check'];
		$this->getUser();

		if (!empty($check) && $this->member) {

			$modelCheckCode = & FLEA :: getSingleton('Model_Invidecode');

			if ($tmp = $modelCheckCode->getOneByHash($check)) {

				$where = array (
					array (
						'email',
						$tmp['email']
					)
				);

				if ($userdata = $this->modelMembers->getOne($where, null, 'member_id,username,email_check', false)) {

					if ($userdata['email_check'] == 1) {

						$data['tips']['description'] = '您已经激活过了，无需再次激活。您可以尽情享受UHOUS提供的各种服务。';
						$data['tips']['url'] = url('Member');

					} else {

						if ($this->modelMembers->getTable()->updateField($where, 'email_check', 1)) {

							$user = array (
								'id' => $userdata['member_id'],
								'name' => $userdata['username'],
                            );

							$this->_dispatcher->setUser($user);
							
							//激活成功赠送优惠券
							$ucou=& FLEA :: getSingleton('Table_Membercoupon');
				            $time=time();
				            $rowcou=array(
				                'member_id'=>$userdata['member_id'],
				                'sn'=>md5($time),
				                'created'=>$time,
				                'invaluetime'=>$time,
				                'cou_id'=>9,
				                'value'=>200
				            );
				            $ucou->create($rowcou);

							$data['tips']['description'] = $user['name'] . ' 您好，恭喜您已经成功完成了激活，请尽情享受UHOUS提供的各种服务。';
							$data['tips']['url'] = url('Member');
						}
					} 

				}

			}
		}

		$data['tips']['title'] = '系统信息';
		if(empty($data['tips']['description']))
		    $data['tips']['description'] = '很抱歉，您的激活码不正确或已失效，请重新认证:' . "<a href=" . $_SERVER['SERVER_NAME'] . url("Member") . ">" . url("member") . "</a>";
		if(empty($data['tips']['url']))
		    $data['tips']['url'] = url('Member');
		$data['tips']['timeout'] = 10;

		$this->_executeView("tips.html", $data);
	}
	/**
	 * 忘记密码 
	 * @Modify At 2012-04-19 15:08:24
	 * 略过输入用户名步骤，直接使用邮箱找回
	 * @access public
	 * @return void
	 */
	function actionForgetPass() {
	    $this->getUser();
	    if($this->member){
	        $this->_error('您已经在登陆状态了,如果要找回其它帐户的密码，请先退出!',url('member'));
	    }
	    
		$step = isset ($_POST['step']) ? (int) $_POST['step'] : 2;

		switch ($step) {
			case 1 :

				$data['step'] = $step;
				break;

			case 2 :

				#$data = $this->modelMembers->getTable()->findByField('username', $_POST['username'], null, 'member_id, email');
				$data['step'] = $step;
				#$data['username'] = $_POST['username'];
				break;

			case 3 :

				#$data = $this->modelMembers->getTable()->findByField('username', $_POST['username'], null, 'member_id, email');
				//检测邮箱参数
				$email=strtolower($_POST['email']);
				if(empty($email)){
				    $this->_error('请填写您 注册时的邮箱地址',url('member','forgetpass'));
				}
				if(!preg_match('/^[\w-]+@{1}[\w-]+\.{1}\w{2,4}(\.{0,1}\w{2}){0,1}$/',$email)){
				    $this->_error('请填正确的邮箱地址',url('member','forgetpass'));
				}
				//检测是否已注册用户
				$datauser=$this->modelMembers->checkData($email,'email');
				if(empty($datauser) || $datauser['email']!=$email){
				    $this->_error('该邮箱尚未注册为本站会员，您可以现在去注册',url('member','login').'#reg');
				}

				#if (trim($data['email']) == ($_POST['email'])) {
				
				$time = time();
				
				//生成申请记录
				$rowcode=array(
				    'userid'=>$datauser['member_id'],
				    'randid'=>$this->_getRandCode(4,6),
				    'hash'=>md5($time).$this->_getRandCode(5,20),
				    'stat'=>0,
				    'email'=>$datauser['email']
				);
				$changetbl =& FLEA :: getSingleton('Table_Changecode');
				if( !$changetbl->create($rowcode) ){
				    $this->_error('系统错误，申请失败，您可以稍后再次申请',url('member','forgetpass'));
				}

				$configs['sendTo'] = $email;
				$configs['subject'] = "忘记密码--";

				$configs['user'] = $datauser['username'];
				$configs['member_id'] = $datauser['member_id'];

				
				$configs['code'] = md5($configs['member_id'] . $configs['user'] . $time);
				$link = "http://" . $_SERVER['SERVER_NAME'] . url('Member', 'GetPass', array (
					'change' => $rowcode['hash']
				));

				$configs['body'] .= $datauser['username'] . "，您好：<br />";
				$configs['body'] .= '您在有好事(www.uhous.com)申请了取回密码，以下是您的验证码:<br />';
				$configs['body'] .= $rowcode['randid'];
				$configs['body'] .= "<br /><div style='padding-left: 3%'>请点击下面链接，按照步骤完成密码修改：<br />";
				$configs['body'] .= $link;
				$configs['body'] .= "</div><br />";
				$configs['body'] .= '如果上面链接不可点击，请手动复制到浏览器地址栏打开链接';

				if ($this->_sendEmail(& $configs)) {

					$this->_saveCheckCode($configs['code']);

					$data['tips']['title'] = "系统信息";
					$data['tips']['description'] = "已向 $email 发送了一封邮件，请查收邮件并按步骤完成操作！";
					$data['tips']['url'] = null;

					return $this->_executeView("tips.html", $data);
				}
				#}
				break;

			default :
				break;
		}

		$this->_executeView('forgetpass.html', $data);
	}

	function actionGetPass() {
		$hashcode = $_GET['change'];

		if (!empty($hashcode)) {
		    
		    $changetbl =& FLEA :: getSingleton('Model_Changecode');
		    $codedata=$changetbl->getOneByHash($hashcode);

			if (!empty($codedata)) {
                //将验证信息记录入session
                $_SESSION[$this->sessioncode]=$codedata['randid'];
                $_SESSION[$this->sessionemail]=$codedata['email'];
                $_SESSION[$this->sessionuser]=$codedata['userid'];
                
                
                $data['email']=$codedata['email'];
				return $this->_executeView("pass.html", $data);
			}
		}

		$data['tips']['title'] = "系统信息";
		$data['tips']['description'] = "您的链接不正确或已失效，请重新激活。&nbsp;&nbsp;<a href=\"" . url("member", "ForgetPass") . "\">忘记密码?</a>";
		$data['tips']['url'] = url("Member", "Login");
		$this->_executeView("tips.html", $data);
	}
	/**
	 * 登出 
	 * 
	 * @access public
	 * @return void
	 */
	function actionLogout() {
		$this->_dispatcher->clearUser();
		$data['tips']['title'] = $this->tips['title'];
		$data['tips']['description'] = '您已经成功的退出了！';
		$data['tips']['url'] = url('Home');
		unset ($_SESSION['orders']);
		unset ($_SESSION['notperf']);

		$this->_executeView('tips.html', $data);
	}
	/**
	 * 修改基本会员信息 
	 * 
	 * @access public
	 * @return void
	 */
	function actionInfo() {
		$this->getUser();
		/**
		 * 已登陆 
		 */
		if (!empty ($this->member)) {
			/**
			 * 条件 
			 */
			$where = array (
				array (
					'member_id',
					$this->member['id']
				),
				array (
					'lang',
					getLanguage()
				),
				array (
					'col_key',
					'member'
				)
			);
			/**
			 * 排序 
			 */
			$sortby = 'member_id ASC';

			$data['memberInfo'] = $this->modelMembers->getOne($where, $sortby, '*', false);
			/**
			 * 处理数据 
			 */
			$data['memberInfo']['date'] = $data['memberInfo']['year'] . '-' . $data['memberInfo']['month'] . '-' . $data['memberInfo']['day'];
			$data['memberInfo']['params'] = unserialize($data['memberInfo']['params']);

			$this->_executeView('member_edit.html', $data);

		} else {

			$this->_errorAction(url("Member", "Login"));
		}
	}
	/**
	 * 保存基本资料 
	 * 
	 * @access public
	 * @return void
	 */
	function actionSaveInfo() {
	    $this->getUser();
		if ($_POST['submit'] && $this->member) {

			$info = $_POST;

			//从session中获取用户ID用以更新
			$user = $this->member;
			$info['member_id'] = $user['id'];
			
			//e-mail转换成小写
			//$info['email']=strtolower($info['email']);
			//清空不允许在此处修改的字段.Add-On 2012-04-18
			$noallow=array('email','username','password','created','lasttime',
			    'openID','email_check','points','lang','col_key','level_id');
			foreach($noallow as $key){
			    if(isset($info[$key]))unset($info[$key]);
			}
			
			$info['lang']=getLanguage();
			$info['col_key']='member';

			/**
			 * 处理出生日期 
			 */
			list ($info['year'], $info['month'], $info['day']) = explode('-', $info['date']);
			/**
			 * 保存会员基本资料 
			 */
			if ($this->modelMembers->save($info)) {

				$data['tips']['title'] = $this->tips['title'];
				$data['tips']['description'] = '您的个人资料已经成功修改！';
				$data['tips']['url'] = url('Member');

				$this->_executeView('tips.html', $data);
			}
		}
	}
	/**
	 * 保存帐户资料,用于QQ注册用户的帐户信息完善 
	 * 
	 * @access public
	 * @return void
	 */
	function actionSaveInfoAcc() {
	    $this->getUser();
		if ($_POST['submit'] && $this->member) {

			//取出需要的数据,过滤不需要的
			$info = array_intersect_key($_POST,array('username'=>'','pass'=>'','email'=>''));

			$user = $this->member;
			if(!$user){
				$this->_errorAction(url("Member", "qqreg"));
			}
			$info['member_id'] = $user['id'];

			if (empty ($info['username'])) {
				$this->_errorAction(url("Member", "qqreg"),'用户名不能为空');
			}
			if (empty ($info['pass'])) {
				$this->_errorAction(url("Member", "qqreg"),'密码不能为空');
			}
			if (empty ($info['email'])) {
				$this->_errorAction(url("Member", "qqreg"),'邮箱不能为空');
			}
			//是否通过检测,不通过的提示信息
			$pass=true;
			$msg='未知原因，更新失败，请稍后再试！';
			
			if(!preg_match('/^[\w\d_\-]{5,}$/',$info['username'])){
				$msg="用户名格式不正确";
				$pass=false;
			}
			if($this->modelMembers->checkExceptID($info['username'],$info['member_id'])){
				$msg="用户名已经存在";
				$pass=false;
			}
			if(!preg_match('/^[\w-]+@{1}[\w-]+\.{1}\w{2,4}(\.{0,1}\w{2}){0,1}$/',$info['email'])){
				$msg="邮箱格式不正确";
				$pass=false;
			}
			if($this->modelMembers->checkDataExceptID($info['email'],'email',$info['member_id'])){
				$msg="邮箱已经存在";
				$pass=false;
			}
			
			//将e-mail转换成小写
			$info['email'] = strtolower($info['email']);
			$info['password'] = $info['pass'];
			$info['lang']=getLanguage();
			$info['col_key']='member';

			/**
			 * 保存会员基本资料 
			 */
			if ($pass && $this->modelMembers->save($info)) {

				//更新SESSION中的用户信息
				$this->_dispatcher->setUser(array (
					"id" => $user['id'],
					"name" => empty($info['realname'])?$info['username']:$info['realname']
				));
				//已完善
				unset ($_SESSION['notperf']);

				$data['tips']['title'] = $this->tips['title'];
				$data['tips']['description'] = '您的帐户信息已保存！';
				$data['tips']['url'] = url('Member');

				$this->_executeView('tips.html', $data);
			}else{
				$this->_errorAction(url("Member", "qqreg"),$msg);
			}
		}
	}
	/**
	 * 修改密码 
	 * @changed at 2012-04-18 14:02:20 
	 * 漏洞 : 直接伪造用户ID与密码数据，就可以成功修改对应用户密码
	 * @access public
	 * @return void
	 */
	function actionPass2() {
		
		if (isset($_POST['password']) && isset($_SESSION[$this->sessionuser])) {
            
            
            
            $tbl = $this->modelMembers->getTable();

			if ($tbl->updateField(array (
					array (
						'member_id',
						$_SESSION[$this->sessionuser]
					)
				), 'password', md5($_POST['password']))) {

				$data['tips']['title'] = $this->tips['title'];
				$data['tips']['description'] = '修改成功！请登陆';
				$data['tips']['url'] = url("Member",'login');
				
				unset($_SESSION[$this->sessioncode]);
                unset($_SESSION[$this->sessionemail]);
                unset($_SESSION[$this->sessionuser]);

				$this->_executeView("tips.html", $data);

			}
			$this->_error("更新失败，请稍后重试");
		}
		$this->_error("链接信息丢失，请重试一次");
	}
	/**
	 * 修改密码 
	 * 
	 * @access public
	 * @return void
	 */
	function actionPass() {
		$this->getUser();
		/**
		 * 修改密码 
		 */
		if ($_POST && $this->member) {

			$tbl = $this->modelMembers->getTable();

			$pass = $tbl->findByField('member_id', $this->member['id'], null, 'password');

			if ($pass['password'] == md5($_POST['pwd'])) {

				if ($tbl->updateField(array (
						array (
							'member_id',
							$this->member['id']
						)
					), 'password', md5($_POST['password']))) {

					$data['tips']['title'] = $this->tips['title'];
					$data['tips']['description'] = '修改成功！';
					$data['tips']['url'] = url("Member");

					$this->_executeView("tips.html", $data);

				} else {

					$this->_errorAction(url("Member", "Login"));
				}

			} else {

				$data['tips']['title'] = $this->tips['title'];
				$data['tips']['description'] = '原密码不正确！';
				$data['tips']['url'] = url("Member", "Pass");

				$this->_executeView("tips.html", $data);
			}

		} else {
			/**
			 * 已登陆 
			 */
			if ($this->member) {

				$data['member_id'] = $this->member['id'];
				$this->_executeView("member_pass.html", $data);

			} else {

				$this->_errorAction(url("Member", "Login"));
			}
		}
	}
	/**
	 * 收货地址 
	 * 
	 * @access public
	 * @return void
	 */
	function actionAddress() {
		$this->getUser();
		/**
		 * 已登陆 
		 */
		if ($this->member) {
			/**
			 * 查找当前用户所有收获地址 
			 */
			$data = $this->modelMembers->getOne(array (
				array (
					'col_key',
					'member'
				),
				array (
					'lang',
					getLanguage()
				),
				array (
					'member_id',
					$this->member['id']
				)
			), 'member_id ASC', 'member_id');

			if ($data['addresses']) {

				foreach ($data['addresses'] as $k => $v) {
					$data['addresses'][$k]['address'] = unserialize($v['address']);
				}

			}

			/**
			 * 编辑收货地址
			 */
			if ($_GET['add_id']) {
				/**
				 * 实例化地址模型 
				 */
				$modelAddress = & FLEA :: getSingleton('Model_Address');
				/**
				 * 查找当前编辑的地址信息 
				 */
				$data['address'] = $modelAddress->getOne(array (
					array (
						'col_key',
						'member'
					),
					array (
						'lang',
						getLanguage()
					),
					array (
						'add_id',
						(int) $_GET['add_id']
					)
				), 'add_id ASC', '*', false);
				$data['address']['address'] = unserialize($data['address']['address']);
			}

		} else {

			$this->_errorAction(url("Member", "Login"));
		}

		$data['col_key'] = 'member';
		$data['lang'] = getLanguage();
		$data['member_id'] = $this->member['id'];

		if ($_GET['back'] == 'yes') {
			$this->_setBack();
		}

		if (($_GET['new'] == 'yes') || ($_GET['check'] == 'yes')) {

			$data['new'] = 'yes';
			$this->_executeView('adress.html', $data);
		} else {
			$this->_executeView('member_address.html', $data);
		}
	}
	/**
	 * 保存新增收货地址 
	 * 
	 * @access public
	 * @return void
	 */
	function actionAddAdress() {
	    $this->getUser();
		/**
		 * 提交数据 
		 */
		if ($_POST && $this->member) {
			/**
			 * 实例化地址管理模型 
			 */
			$modelAddress = & FLEA :: getSingleton('Model_Address');
			/**
			 * 清除其他地址的默认标志 
			 */
			if (isset($_POST['default']) && $_POST['default']) {
				$modelAddress->getTable()->updateField(array (
					array (
						'member_id',
						$_POST['member_id']
					)
				), 'default', 0);
			}

			$row = $_POST;
			
			$row['member_id']=$this->member['id'];

			$address['address']=$row['address'];
			$address['province'] = $row['province'];
			$address['city'] = $row['city'];
			$address['division'] = $row['division'];
			unset($row['address']);
			unset ($row['province']);
			unset ($row['city']);
			unset ($row['division']);
			
			$row['address'] = serialize($address);
			
			if(empty($row['lang']))$row['lang']='zh-cn';
			if(empty($row['col_key']))$row['col_key']='address';
			/**
			 * 保存新地址 
			 */
			if ($modelAddress->save(& $row)) {

				$json_data = array (
					'success' => 1,
					'url' => $this->_getBack()
				);
				echo json_encode($json_data);
			}
		}
	}
	/**
	 * 删除收货地址
	 * 
	 * @access public
	 * @return void
	 */
	function actionDelAddress() {
	    $this->getUser();
		if ($_GET['add_id'] && $this->member) {

			$modelAddress = & FLEA :: getSingleton('Model_Address');

			$pkv = array (
				($_GET['add_id'])
			);

			if ($modelAddress->removeAll($pkv)) {

				$json_data = array (
					'success' => 1
				);
				echo json_encode($json_data);
			}
		}
	}
	/**
	 * 联系相关 
	 * -----------------------------------------------*/

	/**
	 * 分享 
	 * 
	 * @access public
	 * @return void
	 */
	function actionAward() {

	}
	/**
	 * 邀请朋友 
	 * 
	 * @access public
	 * @return void
	 */
	function actionInvite() {
	    $this->getUser();
		$member = $this->member;

		$modelSetting = & FLEA :: getSingleton('Model_Options');
		$data = $modelSetting->getOption('invitation');
		#$data['url'] = ;
		#"http://" . $_SERVER['SERVER_NAME'] . url("Member", 'Login') . "/id/" . $member['id'] . '/name/' . $member['name'];

		$where = array (
			array (
				'info_id',
				20
			),
			array (
				'col_key',
				'help'
			)
		);

		$modelInfo = & FLEA :: getSingleton('Model_Information');

		$data['info'] = $modelInfo->getOne($where);

		$this->_setBack();
		$this->_executeView('award.html', $data);
	}
	/**
	 * 发送邀请
	 */
	function actionSendInvitation($email = null, $body = null, $code = null) {
		$this->getUser();
		$urlemail=strtolower($_POST['email']);
		if(!empty($urlemail)){
			if(empty($this->member['name']))return;
			$hasinfo=$this->modelMembers->checkData($_POST['email'],'email');
		}
		$data['tips']['title'] = "系统信息";
		$data['tips']['url'] = url("Member", "Invite");
		if(!empty($hasinfo)){
			$data['tips']['description'] = "对不起，您这位好友已经是我们的会员了。<br />您可以再试试其它好友";

			$this->_executeView("tips.html", $data);
		}else{
		    $invidedata=array(
			    'randcode'=>$this->_getRandCode(4,6),
			    'email'=>$urlemail ? $urlemail : $email,
			    'hash'=>md5(time()).$this->_getRandCode(5,20)
			);
			$invider=& FLEA :: getSingleton('Model_Invidecode');
	        $invider->del($urlemail);
	        $invider->save($invidedata);
	        
			$configs['sendTo'] = $urlemail ? $urlemail : $email;
			$configs['user'] = $this->member['name'] ? $this->member['name'] : '有好事家居商城';
			$configs['member_id'] = $this->member['id'];
	
			$configs['subject'] = "来自" . $configs['user'] . "注册邀请--";
	
			$configs['body'] = $_POST['content'] ? $_POST['content'] : $body;
			$configs['body'] .= '请点击下面的链接并使用此邮箱完成注册<br />';
			$configs['body'] .= '<a href="http://' . $_SERVER['SERVER_NAME'] . url("Member", 'Login',array('invidecode',$invidedata['hash'])) . '#reg" target="_blank">注册链接</a>';
			$configs['code'] = $code ? $code : $_POST['code'];
	
			if ($info = $this->_sendEmail(& $configs)) {
	
				if ($info['return']) {
	
					$this->_saveCheckCode($configs['code']);
	
					if ($email) {
						js_alert("邮件已发送至{$email}！", null, url("Member", "Invite"));
					} else {
						$data['tips']['description'] = "邮件已成功发送至" . $configs['sendTo'];
					}
	
				}else{
					$data['tips']['description'] = "邮件发送失败，请确认邮箱正确";
				}
			}else{
				$data['tips']['description'] = "邮件发送失败，请确认邮箱正确";
			}
			$this->_executeView("tips.html", $data);
		}
	}
	/**
	 * Sys发送邀请
	 */
	function actionSendInvitationFromSys() {
		$modelSetting = & FLEA :: getSingleton('Model_Options');
		$body = $modelSetting->getOption('invitation');

		$code = md5(time());
		$url = "http://" . $_SERVER['SERVER_NAME'] . url("Member", 'Login') . "/key/" . $code;

		$body['invitation']['value'] .= $url;

		if ($_POST['email'] && $_POST['email'] != '输入您的E-mail') {

			$email = $_POST['email'];

			$mode = '/([\w\.\_]{2,6})@(\w{1,}).([a-z]{2,10})/';
			if (preg_match($mode, $email)) {
			} else {
				return js_alert("邮箱地址格式不正确", "history.back();");
			}

		} else {
			return js_alert("邮箱地址必须填写", "history.back();");
		}

		$this->actionSendInvitation($email, $body['invitation']['value'], $code);
	}
	/**
	 * 我的优惠券 
	 * 
	 * @access public
	 * @return void
	 */
	function actionCoupon() {
		$this->getUser();
		/**
		 * 已登陆 
		 */
		if ($this->member) {
			/**
			 * 查找当前用户所有优惠卡 
			 */
			$modelMemberCoupon=FLEA::getSingleton('Table_Membercoupon');
			
			$where=array(
			    array('member_id',$this->member['id'])
			);
			$data['coupons']=$modelMemberCoupon->findAll($where);

			$this->_executeView("member_coupon.html", $data);

		} else {

			$this->_errorAction(url("Member", "Login"));
		}
	}

	/**
	 * 购物相关功能
	 * -----------------------------------------------*/

	/**
	 * 购物车 
	 * 
	 * @access public
	 * @return void
	 */
	function actionCarts() {
		

		if ($this->modelCart->count()>0) {
			
			$where = array (
				array (
					'col_key',
					'products'
				),
				array (
					'lang',
					getLanguage()
				),
				'in()' => array (
					'pro_id' => $this->modelCart->getIds()
				)
			);

			$sortby = 'pro_id ASC';

			/**
			 * 获取表实例 
			 */
			$tbl = & FLEA :: getSingleton('Model_Products')->getTable();
			
			$rows=$tbl->findAll($where,$sortby,null,'pro_id, name, size, color, pic, price, retail, delivery_cost');
			$prods=$this->modelCart->getProducts();
			
			/**
			 * 构造跟登录以后一样的数组 
			 */
			foreach ($rows as $key => $value) {
				$data['rows'][$key]['products'] = $value;
				$data['rows'][$key]['products']['num'] = $prods[$value['pro_id']];
			}
		}
		
		$data['step']=1;

		$this->_setBack();

		$this->_executeView('cart_car.html', $data);
	}
	/**
	 * 加入购物车 
	 * 
	 * @access public
	 * @return void
	 */
	function actionAddCar() {
		
		$this->modelCart->add(intval($_GET['pro_id']));
		$this->modelCart->flush();
		
		$json_data = array (
			'success' => 1
		);
		echo json_encode($json_data);
    }
	/**
	 * 删除购物车中的商品 
	 * 
	 * @access public
	 * @return void
	 */
	function actionCartRemove() {
		$pro_id = isset ($_GET['id']) ? (int) $_GET['id'] : null;
		$this->modelCart->del($pro_id);
		$this->modelCart->flush();
		
		$this->actionCarts();
	}
	/**
	 * 已购买的商品
	 */
	function actionOrderList($condition = null) {
        $this->getUser();
		if ($this->member) {

			$modelOrders = & FLEA :: getSingleton('Model_Orders');

			if ($condition['where']) {
				$where = $condition['where'];
			}

			$where[] = array (
				'member_id',
				$this->member['id']
			);
			$where[]=array('state',7,'<>');

			$data['orders'] = $modelOrders->getAll($where, 'created ASC', 'order_id, state, total, delivery_cost, delivery_way, ordercode, created');

			$modelProducts = & FLEA :: getSingleton('Model_Products');

			foreach ($data['orders'] as $key => $order) {

				if ($order['products']) {
				    

					foreach ($order['products'] as $k => $value) {

						$ids[]=$value['pro_id'];
						
					}
				}
				if ($order['delivery_way']) {
					$data['orders'][$key]['delivery_way'] = unserialize($order['delivery_way']);
				}
			}
			if(isset($ids)){
				$products= $modelProducts->getAll($ids, null, 'pro_id, name, color, size, price, pic',100,false);

                foreach($products as $val){
                    $pro[$val['pro_id']]=$val;
                }
                #dump($products);
                unset($products);
                foreach($data['orders'] as $key=>$val){
                    foreach($val['products'] as $k=>$v){
                        $data['orders'][$key]['prds'][$k]=$pro[$v['pro_id']];
                        $data['orders'][$key]['prds'][$k]['num']=$v['num'];
                        $data['orders'][$key]['prds'][$k]['commented']=$v['commented'];
                    }
                }
				
			}
			//dump($data['orders']);

		} else {

			return $this->_errorAction(url('Member', 'Login'));

		}

		$this->_setBack();

		if ($condition['view'] == 'refund') {
			$this->_executeView('member_refund.html', $data);
		} else {
			$this->_executeView('member_buy.html', $data);
		}
	}
	/**
	 * 取消订单
	 */
	function actionCancelOrder() {
		$order_id = isset ($_GET['order_id']) ? (int) $_GET['order_id'] : null;
        $this->getUser();
		if ($order_id && $this->member) {
			$modelOrder = & FLEA :: getSingleton("Model_Orders");

			if($modelOrder->cancel($order_id)){
				js_alert("已取消订单", null, url("Member", "OrderList"));
				exit;
			}
		}
		js_alert("订单未能取消", null, url("Member", "OrderList"));
		exit;
	}
	/**
	 * 确认收货
	 * 
	 * @access public
	 * @return void
	 */
	function actionConfirmDelivery() {
		$order_id = isset ($_GET['order_id']) ? (int) $_GET['order_id'] : null;
        $this->getUser();
		if ($order_id & $this->member) {

			$where = array (
				array (
					'order_id',
					$order_id
				)
			);

			$modelOrders = & FLEA :: getSingleton('Model_Orders');

			$data = $modelOrders->getOne($where);

			if ($data['products']) {

				foreach ($data['products'] as $key => $value) {

					$condition = array (
						array (
							'pro_id',
							$value['pro_id']
						)
					);

					$row = $this->modelProducts->getOne($condition, null, 'selled', false);

					$selled = $value['num'] + $row['selled'];

					if ($this->modelProducts->getTable()->updateField($condition, 'selled', $selled)) {

					}
				}
			}

			if ($modelOrders->getTable()->updateField($where, 'state', 3)) {

				$this->_goBack();
			}
		}
	}
	/**
	 * 删除订单中的商品 
	 * 
	 * @access public
	 * @return void
	 */
	function actionRemoveProFromOrder() {
	    $this->getUser();
		if ($_GET['pro_id'] && $this->member) {

			$pkv = (int) $_GET['pro_id'];
			$order_id = (int) $_GET['order_id'];

			$modelOrderproduct = & FLEA :: getSingleton('Table_Orderproduct');
			$modelOrders = & FLEA :: getSingleton('Model_Orders');
			$where = array (
				array (
					'order_id',
					$order_id
				),
				array (
					'pro_id',
					$pkv
				)
			);

			if ($orderpro = $modelOrderproduct->find($where, null, 'num, order_id')) {

				if ($row = $modelOrders->getOne(array (
						array (
							'order_id',
							$order_id
						)
					), null, 'total', false)) {
					$total = $row['total'] - ((int) $orderpro['num'] * (int) $orderpro['product']['price']);
					if ($modelOrders->getTable()->updateField(array (
							array (
								'order_id',
								$order_id
							)
						), 'total', $total)) {
						//订单改变时取消优惠券的使用
						$modelOrders->getTable()->updateField(array (
							array (
								'order_id',
								$order_id
							)
						), 'coupon_id', 0);
                        
						if ($modelOrderproduct->removeByConditions($where)) {

							$count = $modelOrderproduct->findCount(array (
								array (
									'order_id',
									$order_id
								)
							));
							
							//没有商品时取消该订单
							if ($count == 0) {
							    $modelOrders->cancel($order_id);

							}
						}
					}
				}
			}
		}

		header("Location:" . url('Member', 'OrderList'));
		exit;
	}
	/**
	 * 退货管理 
	 * 
	 * @access public
	 * @return void
	 */
	function actionRefund() {
		$condition = array (
			'where' => array (
				'in()' => array (
					'state' => array (
						4,
						5
					)
				)
			),
			'view' => 'refund'
		);

		$this->actionOrderList($condition);
	}

	function actionRefundMoney() {
		$order_id = isset ($_GET['order_id']) ? (int) $_GET['order_id'] : null;
        $this->getUser();
		if ($order_id && $this->member) {
			$modelOrder = & FLEA :: getSingleton("Table_Orders");

			$where = array (
				array (
					"order_id",
					$order_id
				)
			);

			if ($modelOrder->updateField($where, 'state', 4)) {
				js_alert("已申请退款", null, url("Member", "OrderList"));
			}
		}
	}
	/**
	 * 我的收藏 
	 * 
	 * @access public
	 * @return void
	 */
	function actionFav() {
		
        $this->getUser();
		if ($this->member) {
			/**
			 * 收藏模型 
			 */
			$modelFav = & FLEA :: getSingleton('Table_Fav');
			/**
			 * 条件 
			 */
			$where = array (
				array (
					'member_id',
					$this->member['id']
				),
				array (
					'col_key',
					'member'
				),
				array (
					'lang',
					getLanguage()
				)
			);
			/**
			 * 获取页码 
			 */
			$page = isset ($_GET['page']) ? (int) $_GET['page'] : 0;
			/**
			 * 设置分页大小 
			 */
			$pagesize = 15;
			/**
			 * 获取表实例 
			 */
			$tbl = $modelFav;
			/**
			 * 载入分页助手 
			 */
			FLEA :: loadHelper('pager');
			/**
			 * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
			 */
			$pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, null);
			$data['pager'] = $pager->getPagerData();
			$data['rows'] = $pager->findAll('*');

			$this->_executeView('member_fav.html', $data);

		} else {

			$this->_errorAction(url("Member", "Login"));
		}

	}
	/**
	 * 加入收藏 
	 * 
	 * @access public
	 * @return void
	 */
	function actionAddFav() {
		$this->getUser();
		/**
		 * 已登陆 
		 */
		if ($this->member) {
			/**
			 * 实例化收藏表 
			 */
			$modelFav = & FLEA :: getSingleton('Table_Fav');
			/**
			 * 获得当前商品id 
			 */
			$pro_id = isset ($_GET['pro_id']) ? (int) $_GET['pro_id'] : null;

			if ($pro_id) {

				$where = array (
					array (
						'pro_id',
						$pro_id
					)
				);

				if (!$modelFav->findCount($where, 'pro_id')) {

					$row = array (
						'pro_id' => $pro_id,
						'member_id' => $this->member['id'],
						'col_key' => 'member',
						'lang' => getLanguage()
					);

					if ($modelFav->create(& $row)) {

						$json_data = array (
							'success' => 1
						);
						echo json_encode($json_data);

					} else {

						$json_data = array (
							'success' => 0
						);
						echo json_encode($json_data);

					}

				} else {

					$json_data = array (
						'success' => 1
					);
					echo json_encode($json_data);
				}
			}

		} else {

			$json_data = array (
				'success' => 0
			);
			echo json_encode($json_data);
			//$this->_errorAction(url("Member", "Login"));
		}
	}
	/**
	 * 删除收藏 
	 * 
	 * @access public
	 * @return void
	 */
	function actionRemoveFav() {
		if ($_GET['pro_id']) {
			$pkvs = (int) $_GET['pro_id'];
		}

		if ($_POST['pro_id']) {
			$pkvs = (int) $_POST['pro_id'];
		}

		$modelFav = & FLEA :: getSingleton('Table_Fav');

		if ($modelFav->removeByConditions(array (
				array (
					'pro_id',
					$pkvs
				)
			))) {

			$json_data = array (
				'success' => 1
			);
		} else {
			$json_data = array (
				'success' => 0
			);
		}

		echo json_encode($json_data);
	}
	/**
	 * 评价管理 
	 * 
	 * @access public
	 * @return void
	 */
	function actionComments() {
		$this->getUser();
		if ($this->member) {

			$modelComments = & FLEA :: getSingleton('Model_Comments');

			$where = array (
				array (
					'col_key',
					'products'
				),
				array (
					'lang',
					getLanguage()
				),
				array (
					'member_id',
					$this->member['id']
				)
			);

			$sortby = 'created DESC, com_id ASC';

			/**
			 * 获取页码 
			 */
			$page = isset ($_GET['page']) ? (int) $_GET['page'] : 0;
			/**
			 * 设置分页大小 
			 */
			$pagesize = 8;
			/**
			 * 获取表实例 
			 */
			$tbl = $modelComments->getTable();
			/**
			 * 载入分页助手 
			 */
			FLEA :: loadHelper('pager');
			/**
			 * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
			 */
			$pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
			$data['pager'] = $pager->getPagerData();
			$data['rows'] = $pager->findAll('com_id, memo, created');

			$this->_executeView('member_comments.html', $data);

		} else {

			$this->_errorAction(url('Member', 'Login'));

		}
	}
	/**
	 * 辅助功能 
	 * -----------------------------------------------------
	 */
	/**
	 * post请求的跳转函数 
	 * 
	 * @access public
	 * @return void
	 */
	function actionTips() {
		$data['tips']['title'] = $_POST['title'];
		$data['tips']['description'] = $_POST['description'];
		$data['tips']['url'] = $_POST['url'] ? $_POST['url'] : $_SESSION['BACKURL'];
		$this->_executeView('tips.html', $data);
	}
	/**
	 * 输出图形验证码
	 */
	function actionImgCode() {
		// 实例化图形验证码助手类
		$imgcode = & FLEA :: getSingleton('FLEA_Helper_ImgCode');
		// 生成验证码图片
		$imgcode->image(2);
	}
	/**
	 * 错误操作提示 
	 * 
	 * @param mixed $url 
	 * @access protected
	 * @return void
	 */
	function _errorAction($url,$msg='您尚未登录或超时登陆，请登录！') {
		$data['tips']['title'] = $this->tips['title'];
		$data['tips']['description'] = $msg;
		$data['tips']['url'] = $url;

		$this->_executeView("tips.html", $data);
	}
	/**
	 * 发送邮件 
	 * 
	 * @access protected
	 * @return void
	 */
	function _sendEmail($configs) {
		/**
		 * 获取邮箱配置 
		 */
		$setting = & FLEA :: getSingleton('Model_Options');
		$username = $setting->getOption('email');
		$pass = $setting->getOption('pass');
		$smtp = $setting->getOption('smtp');
		$port = $setting->getOption('port');
		$sitename = $setting->getOption('sitename');

		if ($username['email'] && $pass['pass'] && $smtp['smtp'] && $port['port']) {
			$configs['username'] = $username['email']['value'];
			$configs['password'] = $pass['pass']['value'];
			$configs['smtp'] = $smtp['smtp']['value'];
			$configs['port'] = $port['port']['value'];
			$configs['sitename'] = $sitename['sitename']['value'];

			//{{ 载入类
			FLEA :: loadClass('Helper_Phpmailer');
			//}}

			$mail = new Helper_Phpmailer();
			$mail->CharSet = 'utf-8';
			$mail->IsSMTP(); // set mailer to use SMTP
			$mail->Host = $configs['smtp']; // specify main and backup server
			$mail->SMTPAuth = true; // turn on SMTP authentication
			$mail->Username = $configs['username']; // SMTP username
			$mail->Password = $configs['password']; // SMTP password

			$mail->From = $configs['username'];
			$mail->FromName = "车水马龙公司";
			$mail->AddAddress("{$configs['sendTo']}", "");

			//$mail->WordWrap = 50; // set word wrap to 50 characters
			//$mail->AddAttachment("/var/tmp/file.tar.gz"); // add attachments
			//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
			$mail->IsHTML(true); // set email format to HTML

			$mail->Subject = $configs['subject'] . $configs['sitename'];
			$mail->Body = $configs['body'];
			//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

			if (!$mail->Send()) {
				$info = array (
					'return' => false,
					'description' => "Message could not be sent. <p>",
					'Error' => $mail->ErrorInfo
				);
			} else {
				if (empty ($code))
					$code = 0;
				$info = array (
					'code' => $code,
					'return' => true,
				);
			}

			return $info;
		}
	}
	/**
	 * 获得邮箱验证码 @drop
	 */
	private function _getEmailCheckCode($method = null) {
		$time = time();
		$user = $this->_dispatcher->getUser();
		switch ($method) {
			case 'id_name' :
				$data = md5($user['id'] . $user['name']);
				break;

			default :
				$data = md5($user['id'] . $user['name'] . $time);
				break;
		}
		return $data;
	}

	/**
	 * 保存验证码 @drop
	 */
	private function _saveCheckCode($code) {
		$tblCheckCode = & FLEA :: getSingleton('Table_Checkcode');

		$row = array (
			'code' => $code,
			'status' => 0
		);

		if ($tblCheckCode->save($row)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 生成指定长度范围的随机码
	 */
	private function _getRandCode($minl=4,$maxl=6){
		//生成4-6位随机验证码
		$words='abcdefghijklmnopqrstuvwxyz0123456789';
		$l=strlen($words)-1;
		$len=rand($minl,$maxl);
		$wd='';
		for($i=0;$i<$len;$i++){
			$wd .= $words[floor(rand(0,$l))];
		}
		return $wd;
	}
	
	/**
	 * Ajax_Function 
	 * -------------------------------------------------------- */

	/**
	 * 检验用户名是否已存在,用于注册
	 * 
	 * @access public
	 * @return void
	 */
	function actionAjaxCheckUsername() {
	    
		$member = $this->modelMembers->check($_POST['username']);
		if (!empty ($member)) {
			$json_data = array (
				'hasIt' => 1
			);
		} else {
			$json_data = array (
				'hasIt' => 0
			);
		}
		echo json_encode($json_data);
	}
	/**
	 * 检验用户名是否已存在,排除ID,用于重新设定用户名
	 * 
	 * @access public
	 * @return void
	 */
	function actionAjaxCheckUsernameExceptID() {
	    $this->getUser();
	    if($this->member){
	    
		$member = $this->modelMembers->checkExceptID($_POST['username'], $this->member['id']);
		if (!empty ($member)) {
			$json_data = array (
				'hasIt' => 1
			);
		} else {
			$json_data = array (
				'hasIt' => 0
			);
		}
		echo json_encode($json_data);
		
	    }
	}
	/**
	 * 检验邮箱是否使用过,用于注册,邮箱不区分大小写
	 * 
	 * @access public
	 * @return void
	 */
	function actionAjaxCheckMail() {
		$member = $this->modelMembers->checkData(strtolower($_POST['email']),'email');
		if (!empty ($member)) {
			$json_data = array (
				'hasIt' => 1
			);
		} else {
			$json_data = array (
				'hasIt' => 0
			);
		}
		echo json_encode($json_data);
	}
	/**
	 * 检验邮箱是否使用过,排除ID,用于用户修改邮箱时
	 * 
	 * @access public
	 * @return void
	 */
	function actionAjaxCheckMailExceptID() {
	    $this->getUser();
	    if($this->member){
	    
		$member = $this->modelMembers->checkDataExceptID(strtolower($_POST['email']),'email', $this->member['id']);
		if (!empty ($member)) {
			$json_data = array (
				'hasIt' => 1
			);
		} else {
			$json_data = array (
				'hasIt' => 0
			);
		}
		echo json_encode($json_data);
		
	    }
	}
	/**
	 * 检验邮箱是否正确
	 * 
	 * @access public
	 * @return void
	 */
	function actionAjaxCheckEmail() {
	    $this->getUser();
		$member = $this->modelMembers->checkData(strtolower($_POST['username']), 'username');
		if ($member) {
			if ($member['email'] == $_POST['email']) {
				$json_data = array (
					'success' => 1
				);
			} else {
				$json_data = array (
					'success' => 0
				);
			}
		} else {
			$json_data = array (
				'success' => 0
			);
		}
		echo json_encode($json_data);
	}
	/**
	 * 检验验证码是否正确 
	 * 
	 * @access public
	 * @return void
	 */
	function actionAjaxCheckImgCode() {
		// 实例化图形验证码助手类
		$imgcode = & FLEA :: getSingleton('FLEA_Helper_ImgCode');
		if (!$imgcode->check(trim($_POST['imgcode']))) {

			// 清空图形验证码
			$imgcode->clear();
			$json_data = array (
				'pass' => 0
			);

		} else {

			$json_data = array (
				'pass' => 1
			);
		}

		echo json_encode($json_data);
	}
	/**
	 * Ajax实现post请求检测是否已登陆 
	 * 
	 * @access public
	 * @return void
	 */
	function actionAjaxCheckLogin() {
		if ($this->_dispatcher->getUser()) {
			$json_data = array (
				'isNotLogin' => 0
			);
		} else {
			$json_data = array (
				'isNotLogin' => 1
			);
		}
		echo json_encode($json_data);
	}
	/**
	 * Ajax选择区域数据
	 *
	 * @return
	 */
	function actionAjaxSelectArea() {
		$prov_id = isset ($_POST['prov_id']) ? (int) $_POST['prov_id'] : null;

		if ($prov_id) {

			$where = array (
				array (
					'col_key',
					'area'
				),
				array (
					'lang',
					getLanguage()
				),
				array (
					'parent_id',
					$prov_id
				)
			);

			$modelCategories = & FLEA :: getSingleton('Model_Categories');

			$options = $modelCategories->getAll($where, 'sort_id ASC, created DESC', 'cate_id, parent_id, name');

			$html = '';
			foreach ($options as $key => $opt) {
				//$html .= '<option value="'.$opt['cate_id'].'">'.$opt['name'].'</option>';
				$html .= "<option ";

				if ($_POST['current_id'] == $opt['cate_id']) {
					$html .= 'selected="selected"';
				}
				$html .= " value=\"{$opt['cate_id']}\">{$opt['name']}</option>";
			}
			echo $html;
		}
	}
	/**
	 * 获得验证key
	 */
	function actionGetCheckCode() {
		$json_data = array (
			'code' => $this->_getEmailCheckCode('id_name')
		);
		echo json_encode($json_data);
	}
	/**
	 *
	 */
	function actionAjaxUpdateProNum() {
		$num = $_POST['nums'];
		$pro_id = isset ($_POST['pro_id']) ? (int) $_POST['pro_id'] : null;

		if($pro_id){
		    $this->modelCart->setNum($pro_id,intval($num));
		    $this->modelCart->flush();
		}
		
		#$_SESSION['carts'][$pro_id]['num'] = $num;
	}
}
