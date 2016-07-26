<?php


/**
 * 产品页面控制器
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

class Controller_Products extends Controller_Base {
	/**
	 * 产品模型 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $modelProducts;
	/**
	 * 品牌模型 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $modelBrand;
	/**
	 * 分类模型 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $modeCategories;
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
		 * 实例化品牌模型 
		 */
		$this->modelBrand = & FLEA :: getSingleton('Model_Brands');
		/**
		 * 实例化分类模型 
		 */
		$this->modelCategories = & FLEA :: getSingleton('Model_Categories');
	}

	/**
	 * 产品首页
	 */
	function actionaIndex() {
		//if (!$_GET['brand_id']) {
		$cate_id = isset ($_GET['cate_id']) ? (int) $_GET['cate_id'] : null;
		//}
		/**
		 * SEO部分
		 */
		$conf = array (
			'column' => 'product',
			'model' => 'Model_Products',
			'id' => $_GET['id'],
			'cate_id' => $_GET['cate_id']
		);
		$data['seo'] = $this->_loadSeoInfo($conf);

		$list = $this->modelBrand->getAll(null, 'sort_id ASC', 'brand_id, name, minpic');

		$extWhere[0] = array (
			'display',
			1
		);
		$extWhere[1] = array ();

		if ($cate_id) {
			/** * 获取所有子分类ID 
			 */
			$cates = $this->_getAllCate($cate_id);
			/**
			 * 判断是否存在 
			 */
			if (!empty ($cates)) {
				/**
				 * 判断是否有多个子分类 
				 */
				if (is_array($cates)) {
					/**
					 * 多个子分类使用In()查询 
					 */
					$extWhere['in()'] = array (
						'cate_id' => $cates
					);

				} else {
					/**
					 * 单个直接查询 
					 */
					$extWhere[] = array (
						'cate_id',
						$cates
					);
				}
			}
		}

		foreach ($list as $k => $ls) {
			$extWhere[1] = array (
				'brand_id',
				$ls['brand_id']
			);
			$list[$k]['products'] = $this->modelProducts->getAll($extWhere, 'sort_id DESC', 'pro_id, brand_id, cate_id, name, price, pic, discount, retail, selled', 4, false);
		}

		$data['list'] = $list;

		$this->_executeView('product_index.html', $data);
	}

	/**
	 * 产品列表页
	 */
	function actionIndex() {
		//if (!$_GET['brand_id']) {
		$cate_id = isset ($_GET['cate_id']) ? (int) $_GET['cate_id'] : null;
		//}
		/**
		 * SEO部分
		 */
		$conf = array (
			'column' => 'product',
			'model' => 'Model_Products',
			'id' => $_GET['id'],
			'cate_id' => $_GET['cate_id']
		);

		$data['seo'] = $this->_loadSeoInfo($conf);

		$keyword = isset ($_POST['keyword']) ? $_POST['keyword'] : $_GET['keyword'];
		if (!empty ($keyword)) {
			$extWhere[] = array (
				'name',
				"%{$keyword}%",
				'like'
			);
		}

		$price = isset ($_POST['price']) ? $_POST['price'] : $_GET['price'];
		if (!empty ($price)) {
			list ($min, $max) = explode('_', $price);
			$extWhere[] = array (
				'price',
				(int) $min,
				'>'
			);
			if ($max != 'max') {
				$extWhere[] = array (
					'price',
					(int) $max,
					'<'
				);
			}
		}

		$brand = isset ($_POST['brand_id']) ? $_POST['brand_id'] : $_GET['brand_id'];
		if (!empty ($brand)) {
			$extWhere[] = array (
				'brand_id',
				$brand
			);
		}

		$displayorder = isset ($_POST['displayorder']) ? $_POST['displayorder'] : $_GET['displayorder'];
		if (!empty ($displayorder)) {
			$extWhere[] = array (
				'displayorder',
				$displayorder
			);
		}

		$extWhere[] = array (
			'display',
			1
		);

		if ($cate_id) {
			/** * 获取所有子分类ID 
			 */
			$cates = $this->_getAllCate($cate_id);
			/**
			 * 判断是否存在 
			 */
			if (!empty ($cates)) {
				/**
				 * 判断是否有多个子分类 
				 */
				if (is_array($cates)) {
					/**
					 * 多个子分类使用In()查询 
					 */
					$extWhere['in()'] = array (
						'cate_id' => $cates
					);

				} else {
					/**
					 * 单个直接查询 
					 */
					$extWhere[] = array (
						'cate_id',
						$cates
					);
				}
			}
		}
		/**
		 * 排序 
		 */
		$sortby = 'sort_id ASC, pro_id DESC';

		if ($_GET['ordertype'] == 'price') {
			$sortby = 'price DESC';
		}

		if ($_GET['ordertype'] == 'selled') {
			$sortby = 'selled DESC';
		}

		/**
		 * 查看产品列表 
		 */
		/**
		 * 获取页码 
		 */
		$page = isset ($_GET['page']) ? (int) $_GET['page'] : 0;
		/**
		 * 设置分页大小 
		 */
		$pagesize = 16;
		/**
		 * 获取表实例 
		 */
		$tbl = $this->modelProducts->getTable();
		/**
		 * 载入分页助手 
		 */
		FLEA :: loadHelper('pager');
		/**
		 * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
		 */
		$pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $extWhere, $sortby);
		$data['pager'] = $pager->getPagerData();
		$data['rows'] = $pager->findAll('*', false);

		$data['brands'] = $this->modelBrand->getAll(null, 'sort_id ASC, created DESC', 'brand_id, name', null, false);
		$data['keyword'] = $keyword;
		/**
		 * 显示属性
		 */
		$data['displayType'] = array (
			0 => '',
			1 => '',
			2 => '<span class="flag new" style="color: #f90;">[新]</span>',
			3 => '<span class="flag hot" style="color: #f00;">[热]</span>',
			4 => '<span class="flag recom" style="color: #c90;">[荐]</span>'
		);

		$this->_setBack();
		/**
		 * 执行产品视图 
		 */
		$this->_executeView('product_list.html', $data);

	}

	/**
	 * 产品详细页
	 */
	function actionView($extWhere = null) {
		$viewId = isset ($_GET['id']) ? (int) $_GET['id'] : null;
		if (!$_GET['brand_id']) {
			$cate_id = isset ($_GET['cate_id']) ? (int) $_GET['cate_id'] : null;
		}
		/**
		 * SEO部分
		 */
		$conf = array (
			'column' => 'product',
			'model' => 'Model_Products',
			'id' => $_GET['id'],
			'cate_id' => $_GET['cate_id']
		);

		$data['seo'] = $this->_loadSeoInfo($conf);

		/**
		 * 判断是否存在关键id
		 */
		if (!empty ($viewId)) {
			/**
			 * 获取产品信息 
			 */
			$data['row'] = $this->modelProducts->getProById($viewId);
		}
		/**
		 * 信息不为空
		 */
		if ($data['row']) {
			/**
			 * 数据处理 
			 */
			$data['row']['brand']['memo'] = unserialize($data['row']['brand']['memo']);
			$data['row']['brand']['promise'] = unserialize($data['row']['brand']['promise']);
			$data['row']['brand']['book'] = unserialize($data['row']['brand']['book']);

			/**
			 * 属性分组
			 */
			if ($data['row']['attribute']) {
				$where=array(array ('col_key','attribute'),array ('lang',getLanguage()));
				$atts=$this->modelCategories->getAll($where);
				
				$attrcate=array();
				foreach($atts as $val){
					$attrcate[$val['cate_id']]=$val['enname'];
				}
				unset($atts);

				$rows=array();
				foreach($data['row']['attribute'] as $key){
					$rows[$attrcate[$key['cate_id']]][]=$key;
				}
				unset($data['row']['attribute']);
				$data['row']['attribute']=$rows;
				unset($rows);

			}
			
			/**
			 * 相关产品
			 */
			$where="cate_id={$data['row']['cate_id']} AND pro_id<>{$data['row']['pro_id']}";
			$orderby='created DESC';
			$fields='pro_id,name,price,retail,pic';
			$data['related']=$this->modelProducts->getAll($where, $orderby, $fields, 3, false);

			
			/**
			 * 查找评论 
			 */
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
					'pro_id',
					$viewId
				)
			);

			$sortby = 'created DESC, com_id ASC';
			//获取页码 
			$page = isset ($_GET['page']) ? (int) $_GET['page'] : 0;
			//设置分页大小 
			$pagesize = 5;
			//获取表实例 
			$tbl = $modelComments->getTable();
			//载入分页助手 
			FLEA :: loadHelper('pager');
			//实例化一个分页助手，并将所需数据读取出来存于$data数组中 
			$pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
			$data['pager'] = $pager->getPagerData();
			$data['comments'] = $pager->findAll('com_id, memo, created, points');

			$this->_setBack();
			$this->_executeView('product_view.html', $data);

		} else {
			
			$this->_error('出错了! 产品不存在哦~');

		}
	}
	
	function actionNewProdContent(){
	    $data=array();
	    
	    //服务器路径
	    $data['server']='http://'.$_SERVER['SERVER_NAME'];
	    
	    $data['email']=isset($_GET['email'])?htmlspecialchars($_GET['email']):'$email$';
	    
	    $modelOption=&FLEA::getSingleton('Model_Options');
	    $data['serveremail']=$modelOption->getOption('email');
	    $data['serveremail']=$data['serveremail']['email']['value'];

	    //取出最新产品
	    $where=array(
	        array('display',1),
	    );
	    $data['product']=$this->modelProducts->getAll($where,'created desc,pro_id desc','*',14,false);
	    
	    $this->_executeView('emailcontent.html',$data);
	}
	
	function actionEmailReg(){
	    $data=array();
	    
	    //服务器路径
	    $data['server']='http://'.$_SERVER['SERVER_NAME'];
	    
	    $data['email']=isset($_GET['email'])?htmlspecialchars($_GET['email']):'$email$';
	    
	    $modelOption=&FLEA::getSingleton('Model_Options');
	    $data['serveremail']=$modelOption->getOption('email');
	    $data['serveremail']=$data['serveremail']['email']['value'];
	    
	    $data['username']=htmlspecialchars($_GET['username']);
	    $data['password']=htmlspecialchars($_GET['password']);

	    //取出最新产品
	    $where=array(
	        array('display',1),
	    );
	    $data['product']=$this->modelProducts->getAll($where,'created desc,pro_id desc','*',6,false);
	    
	    $this->_executeView('emailreg.html',$data);
	}
	/**
	 * 递归获取所有子分类id 
	 * 
	 * @access protected
	 * @return void
	 */
	function _getAllCate($cate_id) {
		/**
		 * 分类ID不存在，则返回 
		 */
		if (empty ($cate_id)) {
			return;
		}
		/**
		 * 构造条件 
		 */
		$where = array (
			array (
				'col_key',
				'products'
			),
			array (
				'parent_id',
				$cate_id
			),
			array (
				'lang',
				getLanguage()
			)
		);
		/**
		 * 查找所有子分类ID 
		 */
		$subcates = $this->modelCategories->getAll($where, null, 'cate_id', null, false);
		/**
		 * 子分类ID容器 
		 */
		$cateids = array ();
		/**
		 * 是否有子分类 
		 */
		if (!empty ($subcates)) {
			/**
			 * 循环递归查找子分类 
			 */
			foreach ($subcates as $sub) {
				$cateids[] = $this->_getAllCate($sub['cate_id']);
			}

		} else {
			// 没有子分类则返回本身
			return $cate_id;
		}
		/**
		 * 返回子分类ID容器 
		 */
		return $cateids;
	}
	/**
	 * 添加评论 
	 * 
	 * @access public
	 * @return void
	 */
	function actionAddComment() {

		$member = $this->_dispatcher->getUser();

		if ($member) {

			$pro_id = isset ($_GET['id']) ? (int) $_GET['id'] : null;
			
			if($pro_id)$prorow = $this->modelProducts->getProById($pro_id);

			if ($prorow) {
			    list($id,$order_id)=$this->getUnCommentId($member['id'],$pro_id);
				$data['product'] = $prorow;
			}else{
				
				$this->_error('出错了! 产品不存在哦~',url('products'));
			}

		} else {
			
			$this->_error('您尚未登录或超时登陆，请登录！',url('Member', 'Login'));
			
		}

		$this->_setBack();
		$this->_executeView('products_comment.html', $data);
	}
	/**
	 * 保存评论 
	 * 
	 * @access public
	 * @return void
	 */
	function actionSaveComment() {
	    $this->member=$this->_dispatcher->getUser();
	    $pro_id=isset($_POST['pro_id'])?(int)$_POST['pro_id']:'';
	    
		if ($_POST && $this->member && !empty($pro_id)) {
		    
		    
		    list($id,$order_id)=$this->getUnCommentId($this->member['id'], $pro_id);

			$modelComment = & FLEA :: getSingleton('Model_Comments');

			$row = array_intersect_key($_POST,array('title'=>'','memo'=>'','points'=>''));
			$row['pro_id']=$pro_id;
			$row['col_key']='products';
			$row['lang']=getLanguage();
			$row['member_id']=$this->member['id'];
			$row['order_id']=$order_id;

			if ($modelComment->save($row)) {
			    //将对应订单的产品设为已评论
                $modelOrderproduct= &FLEA::getSingleton('Table_Orderproduct');
                $modelOrderproduct->updateField(array(array('id_key',$id)), 'commented', 1);
                
                //更新产品评分
                $product=$this->modelProducts->getOne(array(array('pro_id',$pro_id)));
                if ($product['comments']) {

					$num = 0;
					$totals = 0;
					foreach ($product['comments'] as $key => $value) {
						$totals += $value['points'];
						$num++;
					}
					if ($num != 0) {
						$product['points'] = $totals / $num;
					} else {
						$product['points'] = 0;
					}

					$this->modelProducts->getTable()->updateField($where, 'points', $product['points']);
				}
				
				$data['tips']['title'] = '系统信息';
				$data['tips']['description'] = '商品评论成功！';
				$data['tips']['url'] = url('Member', 'orderlist');

				$this->_executeView('tips.html', $data);
				
			}else{
			    $this->_error('评论失败');
			}
		}else{
		    $this->_error('参数有误');
		}
	}
	
	function getUnCommentId($mid, $pid){
	    //选出用户的所有订单
	    $modelOrder= &FLEA::getSingleton('Model_Orders');
	    $where=array(
	        array('member_id',$mid),
	        array('state',3)
	    );
	    $orders=$modelOrder->getAll($where);
	    if(empty($orders)){
	        $this->_error('您还没购买该产品，不能评论');
	        exit;
	    }
	    //选出第一个等待评论的产品
	    foreach($orders as $val){
	        foreach($val['products'] as $valp){
	            if($valp['pro_id']==$pid && $valp['commented']==0){
	                $id=$valp['id_key'];
	                $order_id=$val['order_id'];
	                break 2;
	            }
	        }
	    }
	    if(empty($id)){
	        $this->_error('您没有待评论的产品');
	        exit;
	    }else{
	        return array($id,$order_id);
	    }
	}
	/**
	 * 查看商品品牌 
	 * 
	 * @access public
	 * @return void
	 */
	function actionBrand() {
		/**
		 * 获得当前的id 
		 */
		$pkv = isset ($_GET['id']) ? (int) $_GET['id'] : null;
		/**
		 * 品牌模型 
		 */
		$modelBrand = & FLEA :: getSingleton('Model_Brands');

		$brdrow = $modelBrand->getOne("brand_id=$pkv");
		if ($brdrow) {
			/**
			 * 当前品牌 
			 */
			if ($pkv) {
				/**
				 * 条件 
				 */
				$where = array (
					array (
						'brand_id',
						$pkv
					),
					array (
						'col_key',
						'products'
					),
					array (
						'lang',
						getLanguage()
					)
				);

				$condition = $where;

				$where[] = array (
					'display',
					1
				);
				/**
				 * 排序 
				 */
				$sortby = 'sort_id DESC, pro_id ASC';
				/**
				 * 获取页码 
				 */
				$page = isset ($_GET['page']) ? (int) $_GET['page'] : 0;
				/**
				 * 设置分页大小 
				 */
				$pagesize = 16;
				/**
				 * 获取表实例 
				 */
				$tbl = $this->modelProducts->getTable();
				/**
				 * 载入分页助手 
				 */
				FLEA :: loadHelper('pager');
				/**
				 * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
				 */
				$pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
				$data['products']['rows'] = $pager->findAll('*');
				$data['products']['pager'] = $pager->getPagerData();
				/**
				 * 当前品牌 
				 */
				$data['brand'] = $modelBrand->getOne($condition);

			} else {
				/**
				 * 条件 
				 */
				$where = array (
					array (
						'col_key',
						'products'
					),
					array (
						'lang',
						getLanguage()
					)
				);
				/**
				 * 排序 
				 */
				$sortby = 'sort_id DESC, brand_id ASC';
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
				$tbl = $modelBrand->getTable();
				/**
				 * 载入分页助手 
				 */
				FLEA :: loadHelper('pager');
				/**
				 * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
				 */
				$pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
				$data['brands']['rows'] = $pager->findAll('brand_id, pic, name');
				$data['brands']['pager'] = $pager->getPagerData();
			}

			$this->_executeView("product_category.html", $data);
		} else {
			
			$this->_error('出错了! 品牌不存在哦~');
			
		}
	}
	/**
	 * 更多评论 
	 * 
	 * @access public
	 * @return void
	 */
	function actionMoreComments() {
		if ($_GET['id']) {
			$viewId = (int) $_GET['id'];
		}

		$where = array (
			array (
				'pro_id',
				$viewId
			)
		);

		$data['product'] = $this->modelProducts->getOne($where, null, 'pro_id, name, points', false);
		if($data['product']){

			$modelComments = & FLEA :: getSingleton('Model_Comments');
	
			$sortby = 'created DESC, com_id ASC';
			/**
			 * 获取页码 
			 */
			$page = isset ($_GET['page']) ? (int) $_GET['page'] : 0;
			/**
			 * 设置分页大小 
			 */
			$pagesize = 5;
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
			$data['rows'] = $pager->findAll('com_id, memo, points, reply, created');
	
			$this->_executeView('product_reply.html', $data);
		}else{
			
			$this->_error('出错了! 产品不存在哦~');
			
		}
	}
	
	/**
	 * 错误操作
	 */
	function _error($msg=null,$url=null,$title='系统信息'){
		
		if(!$msg)$msg='出错了!';
		if(!$url)$url=url('products','index');
		
		$data['tips']['title'] = $title;
		$data['tips']['description'] = $msg;
		$data['tips']['url'] = $url;

		return $this->_executeView('tips.html', $data);
	}
}
