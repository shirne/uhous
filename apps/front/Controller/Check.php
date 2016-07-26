<?php


/**
 * 购买流程页面控制器
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

class Controller_Check extends Controller_Base {
	/**
	 * 产品模型 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $modelProducts;
	/**
	 * 会员模型 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $modelMembers;
	/**
	 *
	 * 地址模型 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $modelAddress;
	/**
	 *
	 * 订单模型 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $modelOrders;
	/**
	 *
	 * 设置模型 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $modelSetup;
	/**
	 *
	 * 参类模型 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $modelCategories;
	
	private $member=null;
	
	/**
	 * 构造函数 
	 * 
	 * @access protected
	 * @return void
	 */
	function __construct() {
		parent :: __construct();
		/**
		 * 实例化产品模型 
		 */
		$this->modelProducts = & FLEA :: getSingleton('Model_Products');
		/**
		 * 实例化地址模型
		 */
		$this->modelAddress = & FLEA :: getSingleton('Model_Address');
		/**
		 * 实例化订单模型
		 */
		$this->modelOrders = & FLEA :: getSingleton('Model_Orders');
		/**
		 * 实例化设置模型 
		 */
		$this->modelSetup = & FLEA :: getSingleton('Model_Setup');
		/**
		 * 实例化分类模型 
		 */
		$this->modelCategories = & FLEA :: getSingleton('Model_Categories');
		
	}
	
	function getUser(){
	    $this->member=$this->_dispatcher->getUser();
	}
	/**
	 * 设定订单信息
	 * 
	 * @access public
	 * @return void
	 */
	function actionSelectDelivery() {
		$this->getUser();
		$orderid=isset($_GET['orderId'])?(int)$_GET['orderId']:0;
		/**
		 * 未登陆
		 */
		if (empty($this->member)) {
		    $this->_error('必须登陆才能进行此操作',url('member','login'));
		}
		
		$where=array(
		    array ('member_id',$this->member['id']),
		    array ('order_id',$orderid)
		);
		$order_row=$this->modelOrders->getOne($where,null,'*',false);

		if (!empty($order_row)) {
		
		    if($order_row['state']!=0){
		        $this->_error('该订单状态不是待付款，请检查',url('member','orderlist'));
		    }
		
		    $data['step']=2;
		    
		    //注册订单信息
		    $data['order']=$order_row;
            
            //选出产品信息
            $where=array(
                array ('order_id',$orderid)
            );
            $modelOrderProducts=& FLEA::getSingleton('Table_Orderproduct');
            $data['products']=$modelOrderProducts->findAll($where);
            
            //选出会员地址
			$where = array (
				array ('member_id',$this->member['id'])
			);
			$sortby = "created DESC, add_id ASC";
			
			$data['address']=$this->modelAddress->getAll($where,$sortby);
			foreach($data['address'] as $key=>$val){
			    $data['address'][$key]['address']=unserialize($data['address'][$key]['address']);
			    if($order_row['add_id']==$val['add_id'] || ($order_row['add_id']==0 && $val['default']==1)){
			        $data['address'][$key]['selected']=1;
			    }
			}
			
			//选出优惠券信息
			$where=array(
			    array('member_id',$this->member['id']),
			    array('invaluetime',time(),'>'),     //未过期
			);
			$modelMemberCoupon=& FLEA::getSingleton('Table_Membercoupon');
			$data['coupon']=$modelMemberCoupon->findAll($where);
			#dump($data['coupon']);
			foreach($data['coupon'] as $key=>$val){
			    if($order_row['coupon_id']==$val['id']){
			        $data['coupon'][$key]['selected']=1;
			    
			    //清除已使用或订单限额之外的优惠券
			    }else if($data['coupon'][$key]['status']!=0 || $data['coupon'][$key]['coupon']['minprice']>$order_row['total']){
			        unset($data['coupon'][$key]);
			    }
			}
			//重置数组索引，以便在section中使用
			$data['coupon']=array_values($data['coupon']);
			
			$this->_setBack();
			
			return $this->_executeView("cart_delivery.html", $data);


		} else { // 订单不存在,转至订单列表页
			$this->_error('订单不存在',url('member','orderlist'));
		}
	}
	/**
	 * 添加/修改收货地址
	 * 保存动作: @see Member.AddAddress
	 * shirne
	 */
	function actionModifyAddress(){
	    if(isset($_GET['id']) && !empty($_GET['id'])){
	        $data['address']=$this->modelAddress->getOne($_GET['id']);
	        if(!empty($data['address'])){
	            $data['address']['address']=unserialize($data['address']['address']);
	        }
	    }else{
	        $data['address']=array();
	    }
	    
	    return $this->_executeView('cart_address.html', $data);
	}
	
	/**
	 * 确认订单
	 * 
	 * @access public
	 * @return void
	 */
	function actionCheckOut() {
		/**
		 * 获取已登陆数据 
		 */
		$member = $this->_dispatcher->getUser();
		/**
		 * 已登陆 
		 */
		if (!$member) {
			$this->_errorAction(url('Member', 'Login'));
		}
		
		$data['step']=3;

		$order_id=isset($_POST['order_id'])?$_POST['order_id']:'';
		$ordercode=isset($_POST['ordercode'])?$_POST['ordercode']:'';
		if(empty($order_id) || empty($ordercode)){
		    $this->_error('请选择正确的订单号',url('member','orderlist'));
		}
		if(empty($_POST['add_id'])){
		    $this->_error('请选择收货地址',$this->_getBack());
		}
		
		//选出订单,并判断订单状态
		$where=array(
		    array('order_id',$order_id),
		    array('ordercode',$ordercode),
		    array('member_id',$member['id'])
		);
		$order=$this->modelOrders->getOne($where);
		if(empty($order)){
		    $this->_error('订单不存在，请检查',url('member','orderlist'));
		}
		if($order['state']!=0){
		    $this->_error('该订单状态不是待付款，请检查',url('member','orderlist'));
		}
		
		$order['add_id']=$_POST['add_id'];
		
		//选出地址
		$where = array (
				array ('lang',getLanguage()),
				array ('add_id',$order['add_id'])
			);
		$data['address'] = $this->modelAddress->getOne($where);
		if(empty($data['address'])){
		    $this->_error('选择的地址不存在',$this->_getBack());
		}
		$data['address']['address']=unserialize($data['address']['address']);
		
		//处理优惠券
		$ocou_id=$order['coupon_id'];
		
		$coupon_id=$_POST['coupon'];
        
        $modelMemberCoupon=&FLEA::getSingleton('Table_Membercoupon');
        if(!empty($coupon_id)){
            //选出新优惠券信息
	        $coupon=$modelMemberCoupon->find(array(array('id',$coupon_id),array('member_id',$member['id'])));
	        if(empty($coupon)){
	            $this->_error('优惠券不存在',$this->_getBack());
	        }
	        if($coupon['coupon']['minprice']>$order['total']){
	            $this->_error('该优惠券限制在订单金额大于<font color="red">'.$coupon['coupon']['minprice'].'</font>的订单中使用',$this->_getBack());
	        }
        }
		//取消已经使用的优惠券
		if($ocou_id != 0 && $coupon_id!=$ocou_id){
		    //先判断要更改的优惠券是否使用过
		    if($coupon && $coupon['status']!=0){
	            $this->_error('您选择的优惠券已经使用过了',$this->_getBack());
	        }
	        
	        //选出旧优惠券的信息
	        $ocoupon=$modelMemberCoupon->find(array(array('id',$ocou_id),array('member_id',$member['id'])));
	        if(!empty($ocoupon)){
	            $ocoupon['status']=0;
	        }
	        $order['coupon_id']=0;
		    $modelMemberCoupon->update($ocoupon , false);
		}
		
		//更新优惠券信息
		if(!empty($coupon_id) && $coupon_id!=$ocou_id){

	        $coupon['status']=1;
	        $order['coupon_id']=$coupon['id'];
	        $modelMemberCoupon->update($coupon , false);
		}
		unset($order['products']);
		$this->modelOrders->save($order);
		$order=$this->modelOrders->getOne(array(
		    array('order_id',$order_id),
		    array('ordercode',$ordercode),
		    array('member_id',$member['id'])
		));
		$data['order']=$order;
		
		
		//选出订单中的产品
		foreach($order['products'] as $prorow){
		    $in[]=$prorow['pro_id'];
		    $nums[$prorow['pro_id']]=$prorow['num'];
		}
		$where = array (
			array ('col_key','products'),
			array ('lang',getLanguage()),
			'in()' => array ('pro_id' => $in)
		);
		$data['products']['rows'] = $this->modelProducts->getAll($where, 'sort_id DESC, pro_id ASC', 'pro_id, name, price, retail, color, size', null, false);
		foreach($data['products']['rows'] as $key=>$val){
		    $data['products']['rows'][$key]['num']=$nums[$val['pro_id']];
		    $total += $val['price']*$nums[$val['pro_id']];
		    $retail += $val['retail']*$nums[$val['pro_id']];
		}
		$data['products']['total']=$total;
		$data['products']['retail']=$retail;
		$data['products']['sub']=$retail-$total;
		if(!empty($order['coupon_id'])){
		    $data['coupon']=$modelMemberCoupon->find(array(array('id',$order['coupon_id']),array('member_id',$member['id'])));
		    $data['products']['suball']=$data['products']['total']-$data['coupon']['coupon']['value'];
		}
		
		
		$data['payment'] = $this->_getSetup('payment');
		$data['delivery'] = $this->_getSetup('delivery');

		$this->_setBack();
		/**
		 * 订单确认 
		 */
		$this->_executeView("cart_check.html", $data);
	}

	/**
	 * 生成订单
	 */
	function actionCreateOrder() {
		$member = $this->_dispatcher->getUser();
		$json_data=array(
		    'success'=>0
		);

		if ($member && $this->modelCart->count()>0) {
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
		    
		    if(empty($rows)){
		        $json_data['description']='订单中的商品不存在';
		        $this->modelCart->clear();
		    }else{
		        
		        /**
		         * 构造订单信息
		         */
		        $order_row['member_id']=$member['id'];
		        $order_row['state']=0;
		        $order_row['col_key'] = 'order';
		        $order_row['lang'] = getLanguage();
		        $order_row['ordercode'] = date('YmdHis') . $member['id'];
		        $order_row['total'] = 0;
		        foreach($rows as $key=>$val){
			        $rowSet[$key]['pro_id'] = $val['pro_id'];
			        $rowSet[$key]['num'] = $prods[$val['pro_id']];
		            $order_row['total'] += $prods[$val['pro_id']]*$val['price'];
		        }
		        
		        /**
		         * 创建订单
		         */
			    if ($order_id = $this->modelOrders->getTable()->create(& $order_row)) {
		            /**
			         * 创建订单产品关系表 
			         */
			        foreach ($rowSet as $key => $val) {
			            $rowSet[$key]['order_id'] = $order_id;
				        #$rowSet[$key]['params'] = serialize($value['params']);
			        }

			        if ($rowSet) {
				        $tblOrderHasProduct = & FLEA :: getSingleton('Table_Orderproduct');
				        if ($tblOrderHasProduct->createRowset(& $rowSet)) {
					        // 生成成功处理...
				        } else {
					        // 生成不成功处理...
				        }
			        }
			        $this->modelCart->clear();
			        $json_data['success']=1;
			        $json_data['orderid']=$order_id;
		        
		        }else{
		            $json_data['description']='订单生成失败';
		        }
		    }
		    
		}else{
		    if(!$member){
		        $json_data['description']='您尚未登陆';
		    }else{
		        $json_data['description']='您的购物车没有商品';
		    }
		}
		echo json_encode($json_data);

	}
	/**
	 * 现在支付 
	 * 
	 * @access public
	 * @return void
	 */
	function actionPayNow() {
		$this->member = $this->_dispatcher->getUser();

		if (!$this->member) {
			$this->_errorAction(url('Member', 'Login'));
		}
		
		$order_id=isset($_POST['order_id'])?$_POST['order_id']:'';
		if(empty($order_id)){
		    $this->_error('请选择正确的订单号',url('member','orderlist'));
		}
		
		$params=$this->getOrderParam($order_id);

		// 支付接口这里开始...
		$this->_goPay($_POST['payment']['select'], $params);
	}
	
	//内部调用，获取订单信息(金额为优惠后的金额)
	private function getOrderParam($order_id,$type='order_id'){
	    if(empty($order_id)){
		    $this->_error('订单号不正确，请检查',url('member','orderlist'));
		    exit;
		}
	    //选出订单,并判断订单状态
		$where=array(
		    array($type,$order_id),
		    array('member_id',$this->member['id'])
		);
		$order=$this->modelOrders->getOne($where);
		if(empty($order)){
		    $this->_error('订单不存在，请检查',url('member','orderlist'));
		    exit;
		}
		if($order['state']!=0){
		    $this->_error('该订单状态不是待付款，请检查',url('member','orderlist'));
		    exit;
		}
		$addr=unserialize($order['address']['address']);
		
		if($order['coupon_id']!=0){
		    //选出优惠券信息
		    $modelCoupon=&FLEA::getSingleton('Table_Membercoupon');
		    $coupon=$modelCoupon->find(array(array('id'=>$order['coupon_id'])));
		    
		    if(!empty($coupon) && $coupon['coupon']['minprice']<=$order['total'] && $coupon['invaluetime']>time()){
		        $order['total']=$order['total']-$coupon['coupon']['value'];
		        $params['coupon']=$coupon;
		    }
		}

		/**
		 * 构造支付宝参数
		 */
		$params['receive_name'] = $order['address']['username'];
		$params['receive_address'] = $addr['province'].' '.$addr['city'].' '.$addr['division'].' '.$addr['address'];
		$params['receive_phone'] = $order['address']['phone'];

		$params['receive_mobile'] = $order['address']['phone'];
		$params['receive_zip'] = $order['address']['post'];

		$params['besttime'] = $order['address']['besttime'];
		$params['default'] = $order['address']['default'];
		$params['email'] = $order['address']['email'];
		$params['building'] = $order['address']['building'];
		$params['order_id'] = $order['order_id'];
		$params['order_no'] = $order['ordercode'];
		$params['order_total'] = $order['total'];
		
		return $params;
	}
	

	/**
	 * 支付接口 
	 * 
	 * @param mixed $type 
	 * @access protected
	 * @return void
	 */
	function _goPay($type = null, $data) {
		switch ($type) {

			case '1' : // 支付宝

				$this->_executeView("alipayment.html", $data);

				break;

			case '2' : // 银联

				$this->_executeView("chinapay.html", $data);

				break;

			case '3' : // 银联无卡
				$data['nocard'] = 1;
				$this->_executeView("chinapay.html", $data);

				break;

			case '4' : // 网付通

				$this->_executeView("unionpay.html", $data);

				break;

			default :

				break;
		}
	}
	
	//支付宝
	function actionAlipay(){
	    $this->member = $this->_dispatcher->getUser();

		if (!$this->member) {
			$this->_errorAction(url('Member', 'Login'));
		}
		
	    //引入必要文件
	    $config=FLEA::loadFile('Helper_alipayconfig.php');
	    FLEA::loadFile('Helper_alipaycore.php');
	    FLEA::loadFile('Helper_alipaysubmit.php');
	    FLEA::loadFile('Helper_alipayserver.php');
	    
	    $orderno=isset($_POST['order_no'])?$_POST['order_no']:'';
	    if(empty($orderno)){
	        $this->_error('请选择订单号',url('member','orderlist'));
	    }
	    
	    //获取订单信息,信息不正确会在获取内部处理
	    $row=$this->getOrderParam($orderno,'ordercode');
	    
	    $out_trade_no		= $orderno;		//请与贵网站订单系统中的唯一订单号匹配
        $subject			= "订单号：".$orderno;	//订单名称，显示在支付宝收银台里的“商品名称”里，显示在支付宝的交易管理的“商品名称”的列表里。
        $body				= "-";	//订单描述、订单详细、订单备注，显示在支付宝收银台里的“商品描述”里
        if(isset($row['coupon'])){
            $body .= '已优惠金额：'.$row['coupon']['coupon']['value'];
        }
        //订单总金额，显示在支付宝收银台里的“应付总额”里
        //$total_fee    = $_POST['order_total'];

        $total_fee	= $row['order_total'];

        //扩展功能参数——默认支付方式//

        //默认支付方式，取值见“即时到帐接口”技术文档中的请求参数列表
        $paymethod    = '';
        //默认网银代号，代号列表见“即时到帐接口”技术文档“附录”→“银行列表”
        $defaultbank  = '';


        //扩展功能参数——防钓鱼//

        //防钓鱼时间戳
        $anti_phishing_key  = '';
        //获取客户端的IP地址，建议：编写获取客户端IP地址的程序
        $exter_invoke_ip = '';
        //注意：
        //1.请慎重选择是否开启防钓鱼功能
        //2.exter_invoke_ip、anti_phishing_key一旦被使用过，那么它们就会成为必填参数
        //3.开启防钓鱼功能后，服务器、本机电脑必须支持SSL，请配置好该环境。
        //示例：
        //$exter_invoke_ip = '202.1.1.1';
        //$ali_service_timestamp = new AlipayService($aliapy_config);
        //$anti_phishing_key = $ali_service_timestamp->query_timestamp();//获取防钓鱼时间戳函数


        //扩展功能参数——其他//

        //商品展示地址，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
        $show_url			= 'http://'.$_SERVER['SERVER_NAME'].url('member','orderlist');
        #'http://www.uhous.com/index.php/member/orderlist/lang/zh-cn';
        //自定义参数，可存放任何内容（除=、&等特殊字符外），不会显示在页面上
        $extra_common_param = '';

        //扩展功能参数——分润(若要使用，请按照注释要求的格式赋值)
        $royalty_type		= "";			//提成类型，该值为固定值：10，不需要修改
        $royalty_parameters	= "";
        //注意：
        //提成信息集，与需要结合商户网站自身情况动态获取每笔交易的各分润收款账号、各分润金额、各分润说明。最多只能设置10条
        //各分润金额的总和须小于等于total_fee
        //提成信息集格式为：收款方Email_1^金额1^备注1|收款方Email_2^金额2^备注2
        //示例：
        //royalty_type 		= "10"
        //royalty_parameters= "111@126.com^0.01^分润备注一|222@126.com^0.01^分润备注二"

        /************************************************************/

        //构造要请求的参数数组
        $parameter = array(
		        "service"			=> "create_direct_pay_by_user",
		        "payment_type"		=> "1",
		
		        "partner"			=> trim($config['partner']),
		        "_input_charset"	=> trim(strtolower($config['input_charset'])),
                "seller_email"		=> trim($config['seller_email']),
                "return_url"		=> trim($config['return_url']),
                "notify_url"		=> trim($config['notify_url']),
		
		        "out_trade_no"		=> $out_trade_no,
		        "subject"			=> $subject,
		        "body"				=> $body,
		        "total_fee"			=> $total_fee,
		
		        "paymethod"			=> $paymethod,
		        "defaultbank"		=> $defaultbank,
		
		        "anti_phishing_key"	=> $anti_phishing_key,
		        "exter_invoke_ip"	=> $exter_invoke_ip,
		
		        "show_url"			=> $show_url,
		        "extra_common_param"=> $extra_common_param,
		
		        "royalty_type"		=> $royalty_type,
		        "royalty_parameters"=> $royalty_parameters
        );

        //构造即时到帐接口
        $alipayService = new AlipayService($config);
        $html_text = $alipayService->create_direct_pay_by_user($parameter);
        echo $html_text;
	}
	//支付宝返回
	function actionAlipayBack(){
	    //引入必要文件
	    $config=FLEA::loadFile('Helper_alipayconfig.php');
	    FLEA::loadFile('Helper_alipaycore.php');
	    FLEA::loadFile('Helper_alipaynotify.php');
	    
	    //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($config);
        $verify_result = $alipayNotify->verifyNotify();

        if ($verify_result) { //验证成功
	        //请在这里加上商户的业务逻辑程序代

	        //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	        //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
	        $out_trade_no = $_POST['out_trade_no']; //获取订单号
	        $trade_no = $_POST['trade_no']; //获取支付宝交易号
	        $total = $_POST['total_fee']; //获取总价格

	        $msg = $out_trade_no . "\t" . $trade_no . "\t" . $total . "\t";

	        if ($_POST['trade_status'] == 'TRADE_FINISHED') {
		        //判断该笔订单是否在商户网站中已经做过处理
		        //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
		        //如果有做过处理，不执行商户的业务程序

		        //注意：
		        //该种交易状态只在两种情况下出现
		        //1、开通了普通即时到账，买家付款成功后。
		        //2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。

		        echo "success"; //请不要修改或删除

		        $this->updateOrder($out_trade_no, $total, 1);

		        //调试用，写文本函数记录程序运行情况是否正常
		        logResult("$msg TRADE_FINISHED");
	        } else
		        if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
			        //判断该笔订单是否在商户网站中已经做过处理
			        //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			        //如果有做过处理，不执行商户的业务程序

			        //注意：
			        //该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。

			        echo "success"; //请不要修改或删除

			        $this->updateOrder($out_trade_no, $total, 1);

			        //调试用，写文本函数记录程序运行情况是否正常
			        logResult("$msg TRADE_SUCCESS");
		        } else {
			        //其他状态判断
			        echo "success";

			        //调试用，写文本函数记录程序运行情况是否正常
			        logResult($msg . $_POST['trade_status']);
		        }

	        //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        } else {
	        //验证失败
	        echo "fail";

	        //调试用，写文本函数记录程序运行情况是否正常
	        logResult("$msg 验证失败");
        }
	}
	//支付宝返回
	function actionAlipayFront(){
	    //引入必要文件
	    $config=FLEA::loadFile('Helper_alipayconfig.php');
	    FLEA::loadFile('Helper_alipaycore.php');
	    FLEA::loadFile('Helper_alipaynotify.php');
	    //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($config);
        $verify_result = $alipayNotify->verifyReturn();
        if($verify_result) {//验证成功
	        //请在这里加上商户的业务逻辑程序代码
	
	        //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            $out_trade_no	= $_GET['out_trade_no'];	//获取订单号
            $trade_no		= $_GET['trade_no'];		//获取支付宝交易号
            $total_fee		= $_GET['total_fee'];		//获取总价格

            if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		        //判断该笔订单是否在商户网站中已经做过处理（可参考“集成教程”中“3.4返回数据处理”）
			    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			    //如果有做过处理，不执行商户的业务程序
                
                if ($_GET['is_success']=='T') {
                    $this->_errorAction(url('member','orderlist'),'订单:'.trim($out_trade_no).'付款成功!');
                	
                }else{
                	$this->_errorAction(url('member','orderlist'),'系统验证失败，请检查');
                	
                }
            }
            else {
                $this->_errorAction(url('member','orderlist'),'系统验证失败，请检查');
            }
        }
        else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数，比对sign和mysign的值是否相等，或者检查$responseTxt有没有返回true
            //echo "验证失败";
            $this->_errorAction(url('member','orderlist'),'系统验证失败，请检查');
        }
	}
	
	//银联
	function actionChinapay(){
	    $this->member = $this->_dispatcher->getUser();

		if (!$this->member) {
			$this->_errorAction(url('Member', 'Login'));
		}
	    FLEA::loadFile('Helper_chinapay.php');
        /*
        $npc = new COM("CPNPC.NPC");


        $chkvalue = $npc->sign(
	        "808080290000001",	#商户号，长度为15个字节的数字串，由ChinaPay或清算银行分配。
	        "0000000010000001",	#订单号，长度为16个字节的数字串，由商户系统生成，失败的订单号允许重复支付。 
	        "000000000001",		#交易金额，长度为12个字节的数字串，例如：数字串"000000001234"表示12.34元。 
	        "156",				#货币代码, 长度为3个字节的数字串，目前只支持人民币，取值为"156" 。
	        "20080813",			#交易日期，长度为8个字节的数字串，表示格式为：YYYYMMDD。
	        "0001"				#交易类型，长度为4个字节的数字串，取值范围为："0001"和"0002"， 其中"0001"表示消费交易，"0002"表示退货交易。
        );
        */

        $order_row = $this->getOrderParam($_POST['order_no'],'ordercode');
        

        $pay = new ChinaPay();
        
        $pay->load($order_row['order_no'], $order_row['order_total'], url('check','chinapayfront') , $order_row['order_id']);
	}
	//银联返回
	function actionChinapayBack(){
	    FLEA::loadFile('Helper_chinapay.php');

        $status=$_POST['status'];
        
        if($status === '1001'){
	        $cp=new chinapay();
	        $rtn = $cp->check($_POST);
	
	        //记录日志
	        $f=fopen('chinapaylog.txt','a');
	        fwrite($f, "\n\r".$rtn);
	        fclose($f);
	        if($rtn===true){
	            $this->updateOrder(intval($_POST['Priv1']), $_POST['amount'],$cp->ctype($_POST['merid']),'order_id');
	        }
        }
	}
	//银联
	function actionChinapayFront(){
	    FLEA::loadFile('Helper_chinapay.php');

        $status=$_POST['status'];
        $OrderNo=$_POST['Priv1'];
        if($status === '1001'){
            $cp=new chinapay();
	        
            if($cp->check($_POST)){
                $order=$this->modelOrders->getOne(array(array('order_id',$OrderNo)));
                $this->_errorAction(url('member','orderlist'),'订单号：'.$order['ordercode'].' 付款成功');
            }else{
                $this->_errorAction(url('member','orderlist','验证失败,请检查'));
            }
            
        }else{
	        $this->_errorAction(url('member','orderlist','验证失败,请检查'));
        }
	}
	
	//网付通,暂时只能设定一个前端返回页面，所以要在前端返回页面处理订单
	function actionUnionpay(){
	    $this->member = $this->_dispatcher->getUser();

		if (!$this->member) {
			$this->_errorAction(url('Member', 'Login'));
		}
		$config=FLEA::loadFile('Helper_alipayconfig.php');
		$config=FLEA::loadFile('Helper_unoinpayconfig.php');
		FLEA::loadFile('Helper_NetTran.php');
		
		
		$OrderNo = $_POST['order_no'];
		
		$row=$this->getOrderParam($OrderNo,'ordercode');
		
		$OrderAmount = $row['order_total'];
        $ret = false;
        
        $MerId       = "WF8";  //商户ID参数
        
        $CurrCode	= "CNY";		//货币代码，值为：CNY
        
        $ResultMode  = "0";	
        $BankCode="";
        $Reserved01="";
        $Reserved02="";
			
        $SourceText = "MerId=" . $MerId . "&" .
			          "OrderNo=". $OrderNo . "&" .
			          "OrderAmount=" . $OrderAmount . "&" .
			          "CurrCode=" . $CurrCode . "&" .
			          "CallBackUrl=" . $config['callbackurl'] . "&" .
			          "BankCode=" . $BankCode ."&" .
			          "ResultMode=" . $ResultMode . "&" .
			          "Reserved01=" . $Reserved01 . "&" .
			          "Reserved02=" . $Reserved02;
        $obj=new NetTran();
	          
        //对原始信息进行加密			  
       $ret=$obj->EncryptMsg($SourceText,$config['certfile']);			  
       if($ret==true){
       		$EncryptedMsg=$obj->getLastResult();
       }
       else{
           print($obj->getLastErrMsg()."<br>");
           exit;
       }
       //对原始信息进行签名
       $ret=$obj->SignMsg($SourceText,$config['keyfile'],$config['password']);   
       if($ret==true){
       		$SignedMsg=$obj->getLastResult();
       }
       else{
           print($obj->getLastErrMsg()."<br>");
           exit;
       }
       print("正在转跳中...");
       echo '<form method="post" name="SendOrderForm" action="https://www.gnete.com/bin/scripts/OpenVendor/gnete/V34/GetOvOrder.asp">
<input type="hidden" name="EncodeMsg" value="'.$EncryptedMsg.'">

<input type="hidden" name="SignMsg" value="'.$SignedMsg.'">
</form>
<input id="sub" type="button" value="提 交" onclick="javascript:document.SendOrderForm.submit();">
<script type="text/javascript">document.SendOrderForm.submit();</script>';
	
	}
	//网付通返回
	function actionUnionpayBack(){
	
	}
	//网付通前端返回
	function actionUnionpayFront(){
	    $config=FLEA::loadFile('Helper_unoinpayconfig.php');
		FLEA::loadFile('Helper_NetTran.php');
		//接收页面变量
        $EncodeMsg = $_REQUEST["EncodeMsg"];
        $SignMsg = $_REQUEST["SignMsg"];
        $DecryptedMsg = "";
        $ret = false;
        $obj = new NetTran();

        //解密数据
        $ret = $obj->DecryptMsg($EncodeMsg, $config['keyfile'], $config['password']);
        if ($ret == false) {
	        //解密失败
	        print ($obj->getLastErrMsg());
        } else {
	        $DecryptedMsg = $obj->getLastResult();
	        $ret = $obj->VerifyMsg($SignMsg, $DecryptedMsg, $config['certfile']);
	        if ($ret == false) {
	            $this->_errorAction(url('member','orderlist'),'验证失败!请检查<br />'.$obj->getLastErrMsg());
		        //验签失败
		    } else {
		        //取出明文中各数据域
		        //商户订单号
		        $OrderNo = getContent($DecryptedMsg, "OrderNo");
		        //支付单号
		        $PayNo = getContent($DecryptedMsg, "PayNo");
		        //支付金额
		        $PayAmount = getContent($DecryptedMsg, "PayAmount");
		        //货币代码
		        $CurrCode = getContent($DecryptedMsg, "CurrCode");
		        //系统参考号
		        $SystemSSN = getContent($DecryptedMsg, "SystemSSN");
		        //响应码
		        $RespCode = getContent($DecryptedMsg, "RespCode");
		        //清算日期
		        $SettDate = getContent($DecryptedMsg, "SettDate");
		        //保留域1
		        $Reserved01 = getContent($DecryptedMsg, "Reserved01");
		        //保留域2
		        $Reserved02 = getContent($DecryptedMsg, "Reserved02");
		        
		        //响应码为"00"表示交易成功，具体的响应码对照表请查阅《开放商户支付接口V34.doc》
		        if ($RespCode == "00") {
			        $this->updateOrder($OrderNo, $PayAmount, 4);
			        
			        $this->_errorAction(url('member','orderlist'),'订单：'.$OrderNo.'支付成功');

			        
			        //支付成功
		        } else {
		            $this->_errorAction(url('member','orderlist'),'支付失败!请检查');
			        //支付不成功

		        }

	        }

        }
	}
	
	//网付通接口函数
	function getContent($input, $para) {
	    if ($input == "" || $para == "") {
		    return "";
	    }
	    $vv = "";
	    $st = explode("&", $input);
	    foreach ($st as $vv) {
		    //$vv = $st->nextToken(); 

		    if ((strpos($vv, $para) !== FALSE) and (substr($vv, 0, strpos($vv, "=")) == $para)) {
			    $vv = substr($vv, strpos($vv, "=") + 1, strlen($vv));
			    return $vv;
		    }
	    }
	    return "";
    }
	
	//更新订单状态，并发送邮件到系统邮箱，说明已付款订单，内部调用
	private function updateOrder($orderno, $total, $payment ,$type='ordercode'){
	    //更新
	    $where=array(
	        array($type,$orderno)
	    );
	    
	    
	    if ($this->modelOrders->getTable()->updateByConditions($where,array('state'=>1,'payment'=>$payment,'amount'=>$total))) {
		    //echo 'success';	
		    FLEA::loadFile('Helper_Phpmailer.php');
		    $modelOption =& FLEA::getSingleton('Model_Options');
		    $options = $modelOption->getOption();
		    #mysql_query("SELECT * FROM {$db_config['dbTablePrefix']}options ORDER BY opt_id ASC");

#		    while ($row = mysql_fetch_array($optrow)) {
#			    $options[$row['name']] = $row['value'];
#		    }

		    if (empty ($options['tipemail'])) {
			    return true;
		    }

		    $mail = new Helper_Phpmailer();
		    $mail->CharSet = 'utf-8';
		    $mail->IsSMTP(); // set mailer to use SMTP
		    $mail->Host = $options['smtp']['value']; // specify main and backup server
		    $mail->SMTPAuth = true; // turn on SMTP authentication
		    $mail->Username = $options['email']['value']; // SMTP username
		    $mail->Password = $options['pass']['value']; // SMTP password

		    $mail->From = $options['email']['value'];
		    $mail->FromName = "系统消息";
		    $mail->AddAddress("{$options['tipemail']['value']}", "");
		    $mail->IsHTML(true); // set email format to HTML

		    $mail->Subject = '订单提醒:订单号为:' . $orderno . '的订单已付款,请及时处理';
		    $mail->Body = '订单提醒:订单号为:' . $orderno . '的订单已付款,请及时处理';

		    $mail->Send();
	    } else {
		    //echo 'faild';
	    }
	}
	
	/**
	 * 错误操作提示 
	 * 
	 * @param mixed $url 
	 * @access protected
	 * @return void
	 */
	function _errorAction($url,$msg='您尚未登录或超时登陆，请登录！',$title='系统信息') {
		$data['tips']['title'] = $title;
		$data['tips']['description'] = $msg;
		$data['tips']['url'] = $url;

		$this->_executeView("tips.html", $data);
	}
	/**
	 * 获得系统设置信息工具 
	 * 
	 * @access protected
	 * @return void
	 */
	function _getSetup($col_key = null) {
		$where = array (
			array (
				'col_key',
				$col_key
			),
			array (
				'lang',
				getLanguage()
			)
		);

		$data = $this->modelSetup->getAll($where, 'sort_id', 'set_id, name, memo, cost');

		return $data;
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

			$options = $this->modelCategories->getAll($where, 'sort_id ASC, created DESC', 'cate_id, parent_id, name');

			$html = '';
			foreach ($options as $key => $opt) {
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
	 * 支付宝返回处理 
	 * 
	 * @access public
	 * @return void
	 */
	function actionTrade() {
		$trade_no = isset ($_GET['trade_no']) ? $_GET['trade_no'] : null;
		$trade_id = isset ($_GET['trade_id']) ? $_GET['trade_id'] : null;
		$modelOrders = & FLEA :: getSingleton("Model_Orders");
		if ($trade_id) {
			$row = $modelOrders->getOne(array (
				array (
					'order_id',
					$trade_id
				)
			));
			$trade_no = $row['ordercode'];
		}
		if ($trade_no) {

			$member = $this->_dispatcher->getUser();
			if ($member) {
				$where = array (
					array (
						'ordercode',
						$trade_no
					),
					array (
						'member_id',
						$member['id']
					)
				);

				//if ($modelOrders->getTable()->updateField($where, 'state', 1)) {

				$data['tips']['title'] = "系统信息";
				$data['tips']['description'] = "订单号：" . $trade_no . " 付款成功！";
				$data['tips']['url'] = url("Member");
				$this->_executeView("tips.html", $data);

				//}
			} else {

				$this->_errorAction(url("Member", "Login"));

			}
		}
	}
}
