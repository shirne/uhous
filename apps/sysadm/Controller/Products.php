<?php

/**
 * 产品管理控制器
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

class Controller_Products extends Controller_Base {
	/**
	 * 产品分类管理模型实例
	 *
	 * @var Model_Categories
	 * @access private
	 */
	private $modelCate;

	/**
	 * 产品管理模型实例
	 *
	 * @var Model_Products
	 * @access private
	 */
	private $modelProduct;

	/**
	 * 产品品牌管理模型实例
	 *
	 * @var Model_Brands
	 * @access private
	 */
	private $modelBrand;

	/**
	 * 产品副图管理模型实例
	 *
	 * @var Model_Photos
	 * @access private
	 */
	private $modelPhoto;
	/**
	 * modelComments 
	 * 
	 * @var mixed
	 * @access private
	 */
	private $modelComments;
	/**
	 * modelAttribute 
	 * 
	 * @var mixed
	 * @access private
	 */
	#private $modelAttribute;

	/**
	 * 构造函数
	 */
	function __construct() {
		/**
		 * 执行父类构造函数
		 */
		parent :: __construct();
		/**
		 * 实例化产品分类管理模型
		 */
		$this->modelCate = & FLEA :: getSingleton('Model_Categories');
		/**
		 * 实例化产品品牌管理模型
		 */
		$this->modelBrand = & FLEA :: getSingleton('Model_Brands');
		/**
		 * 实例化产品管理模型
		 */
		$this->modelProduct = & FLEA :: getSingleton('Model_Products');
		/**
		 * 实例化产品副图管理模型
		 */
		$this->modelPhoto = & FLEA :: getSingleton('Model_Photos');
		/**
		 * 实例化产品评论模型 
		 */
		$this->modelComments = & FLEA :: getSingleton('Model_Comments');
		/**
		 * 实例化属性模型 
		 */
		#$this->modelAttribute = & FLEA :: getSingleton('Model_Attribute');
	}

	/**
	 * 产品列表视图
	 */
	function actionIndex() {
		/**
		 * 设置查询条件
		 */
		$where = array (
			array (
				'col_key',
				getColkey()
			),
			array (
				'lang',
				getLanguage()
			)
		);
		/**
		 * 搜索
		 */
		if ($_GET['search'] == 'yes') {
			/**
			 * 搜索标识符，用于分页控件
			 */
			$data['search'] = 'yes';

			/**
			 * 按分类搜索
			 */
			$cate_id = isset ($_POST['cate_id']) ? (int) $_POST['cate_id'] : (int) $_GET['cate_id'];
			if ($cate_id > 0) {
				$where[] = array (
					'cate_id',
					$cate_id
				);
				/**
				 * Pagenav 链接构造参数
				 */
				$data['cate_id'] = $cate_id;
			}

			/**
			 * 按品牌搜索
			 */
			$brand_id = isset ($_POST['brand_id']) ? (int) $_POST['brand_id'] : (int) $_GET['brand_id'];
			if ($brand_id > 0) {
				$where[] = array (
					'brand_id',
					$brand_id
				);
				/**
				 * Pagenav 链接构造参数
				 */
				$data['brand_id'] = $brand_id;
			}

			/**
			 * 按商品属性搜索
			 */
			$display = isset ($_POST['displayorder']) ? (int) $_POST['displayorder'] : (int) $_GET['displayorder'];
			if ($display > 0) {
				$where[] = array (
					'displayorder',
					$display
				);
				/**
				 * Pagenav 链接构造参数
				 */
				$data['displayorder'] = $display;
			}

			/**
			 * 按商品名称搜索
			 */
			$name = isset ($_POST['name']) ? h(trim($_POST['name'])) : urldecode(h(trim($_GET['name'])));
			if ($name) {
				$where[] = array (
					'name',
					"%{$name}%",
					'like'
				);
				/**
				 * Pagenav 链接构造参数
				 */
				$data['name'] = urlencode($name);
			}

			/**
			 * 按商品编号搜索
			 */
			$procode = isset ($_POST['procode']) ? h(trim($_POST['procode'])) : urldecode(h(trim($_GET['procode'])));
			if ($procode) {
				$where[] = array (
					'procode',
					"%{$procode}%",
					'like'
				);
				/**
				 * Pagenav 链接构造参数
				 */
				$data['procode'] = urlencode($procode);
			}

			/**
			 * 按商品规格搜索
			 */
			$specification = isset ($_POST['specification']) ? h(trim($_POST['specification'])) : urldecode(h(trim($_GET['specification'])));
			if ($specification) {
				$where[] = array (
					'specification',
					"%{$specification}%",
					'like'
				);
				/**
				 * Pagenav 链接构造参数
				 */
				$data['specification'] = urlencode($specification);
			}

			/**
			 * 按商品ID搜索
			 */
			$pro_id = isset ($_POST['pro_id']) ? (int) $_POST['pro_id'] : (int) $_GET['pro_id'];
			if ($pro_id > 0) {
				$where[] = array (
					'pro_id',
					$pro_id
				);
				/**
				 * Pagenav 链接构造参数
				 */
				$data['pro_id'] = $pro_id;
			}

		} else {
			/**
			 * 查询分类
			 */
			if ($_GET['cate_id']) {
				$where[] = array (
					'cate_id',
					(int) $_GET['cate_id']
				);
				/**
				 * Pagenav 链接构造参数
				 */
				$data['cate_id'] = (int) $_GET['cate_id'];
			}
			/**
			 * 查询品牌
			 */
			if ($_GET['brand_id']) {
				$where[] = array (
					'brand_id',
					(int) $_GET['brand_id']
				);
				/**
				 * Pagenav 链接构造参数
				 */
				$data['brand_id'] = (int) $_GET['brand_id'];
			}
		}
		/**
		 * 获取页码
		 */
		$page = isset ($_GET['page']) ? (int) $_GET['page'] : 0;
		/**
		 * 设置分页大小
		 */
		$pagesize = 15;
		/**
		 * 设置排序
		 */
		$sortby = 'sort_id ASC, pro_id DESC';
		/**
		 * 获取表实例
		 */
		$tbl = & $this->modelProduct->getTable();
		/**
		 * 载入分页助手
		 */
		FLEA :: loadHelper('pager');
		/**
		 * 实例化一个分页助手，并将所需数据读取出来存于$data数组中
		 */
		$pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
		$data['pager'] = $pager->getPagerData();
		$data['products'] = $pager->findAll('pro_id, brand_id, cate_id, displayorder, display, pic, price, name, created');
		/**
		 * 显示属性
		 */
		$data['displayType'] = array (
			0 => '',
			1 => '',
			2 => '<span style="color: #f90;">[新]</span>',
			3 => '<span style="color: #f00;">[热]</span>',
			4 => '<span style="color: #c90;">[荐]</span>'
		);
		/**
		 * Pagenav 链接构造参数
		 */
		$data['controller'] = 'Products';
		$data['action'] = 'Index';
		$data['colkey'] = getColkey();
		$data['lang'] = getLanguage();

		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出产品列表视图
		 */
		$this->_executeView('modules/products/list.tpl', $data);
	}
	/**
	 * 显示和隐藏商品 
	 * 
	 * @access public
	 * @return void
	 */
	function actionDisplay() {
		$pkv = isset ($_GET['id']) ? (int) $_GET['id'] : null;
		$display = isset ($_GET['display']) ? (int) $_GET['display'] : 1;

		$where = array (
			array (
				'pro_id',
				$pkv
			),
			
		);

		$tbl = $this->modelProduct->getTable();

		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 删除所选产品
		 */
		$tbl->updateField($where, 'display', $display);
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
	 * 添加产品视图
	 */
	function actionAddNew() {
		/**
		 * 获得产品表数据入口操作句柄
		 */
		$tbl = & $this->modelProduct->getTable();
		/**
		 * 获得产品表元数据
		 */
		$data['product'] = $this->_prepareData($tbl->meta);
		$data['product']['lang'] = getLanguage();
		$data['product']['col_key'] = getColkey();
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出产品编辑视图
		 */
		$this->_editProduct(& $data);
	}
	
	/**
	 * 复制一条产品,不复制图片
	 */
	function actionCopy(){
		/**
		 * 获得产品数据
		 */
		$data['product'] = $this->modelProduct->getOne((int) $_GET['id']);
		/**
		 * 反序列化产品参数
		 */
		$data['product']['params'] = unserialize($data['product']['params']);
		
		/**
		 * 去掉图片
		 */
		unset($data['product']['pro_id']);
		unset($data['product']['pic']);
		unset($data['product']['thumb_pic']);
		
		for($i=1;$i<5;$i++){
			if(isset($data['product']['params']['intro'][$i]['pic'])){
				unset($data['product']['params']['intro'][$i]['pic']);
			}
		}
		$this->_setBack();
		$this->_editProduct(& $data);
	}

	/**
	 * 编辑产品视图
	 */
	function actionModify() {
		/**
		 * 获得产品数据
		 */
		$data['product'] = $this->modelProduct->getOne((int) $_GET['id']);
		/**
		 * 反序列化产品参数 
		 */
		$data['product']['params'] = unserialize($data['product']['params']);
		
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出产品编辑视图
		 */
		$this->_editProduct(& $data);
	}

	/**
	 * 删除产品
	 */
	function actionRemove() {
		/**
		 * 按主键删除单个产品
		 */
		if ($_GET['id']) {
			$pkvs = array (
				(int) $_GET['id']
			);
		}
		/**
		 * 按主键删除多个产品
		 */
		if ($_POST['check']) {
			$pkvs = $_POST['check'];
		}

		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 删除所选产品
		 */
		$this->modelProduct->removeAll($pkvs);
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
	 * 删除商品图片
	 */
	function actionRemovePic() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 删除产品图片
		 */
		$this->modelProduct->removeProductPic((int) $_GET['id'], $_GET['witch']);
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
	 * 保存产品
	 */
	function actionSave() {
		
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 保存产品
		 */
		$this->modelProduct->save($_POST);
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
	 * 产品副图列表视图
	 */
	function actionPhotos() {
		/**
		 * 读出产品资料
		 */
		$data['product'] = $this->modelProduct->getOne((int) $_GET['id'], null, 'pro_id, name, col_key, lang');
		/**
		 * 修改副图
		 */
		$photo_id = isset ($_GET['photo_id']) ? (int) $_GET['photo_id'] : null;
		if ($photo_id) {
			$data['photo'] = $this->modelPhoto->getOne($photo_id);
		}
		/**
		 * 限制副图数量
		 */
		if (count($data['product']['photos']) >= 10 && !$photo_id) {
			$data['upload'] = 'no';
		}
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出产品副图列表视图
		 */
		$this->_executeView('modules/products/photos.tpl', $data);
	}

	/**
	 * 删除产品副图视图
	 */
	function actionRemovePhotoPic() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 删除产品副图图片
		 */
		$this->modelPhoto->removePhotoPic((int) $_GET['photo_id']);
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
	 * 删除产品副图视图
	 */
	function actionRemovePhoto() {
		/**
		 * 按主键删除
		 */
		if ($_GET['photo_id']) {
			$pkvs = array (
				(int) $_GET['photo_id']
			);
		}
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 删除所选产品副图
		 */
		$this->modelPhoto->removeAll($pkvs);
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
	 * 保存产品副图
	 */
	function actionSavePhoto() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 保存产品副图
		 */
		$this->modelPhoto->save($_POST);
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
	 * 产品排序
	 */
	function actionSort() {
		/**
		 * 获分类ID
		 */
		$cate_id = isset ($_GET['cate_id']) ? (int) $_GET['cate_id'] : 0;
		/**
		 * 获得产品列表
		 */
		$where = array (
			'lang' => getLanguage(),
			'col_key' => getColkey()
		);
		if ($cate_id > 0) {
			$where[] = array (
				'cate_id',
				$cate_id
			);
		}
		$data['products'] = $this->modelProduct->getAll($where, 'sort_id ASC, pro_id DESC', 'pro_id, name', null, false);
		/**
		 * 当没有产品数据时，给出提示并返回上一视图
		 */
		if (!$data['products']) {
			js_alert('没有可排序的产品', 0, $this->_getBack());
		}
		/**
		 * 获得分类树
		 */
		$data['categories'] = $this->modelCate->getTree();
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出产品排序视图
		 */
		$this->_executeView('modules/products/sort-products.tpl', $data);
	}

	/**
	 * 保存产品排序结果
	 */
	function actionSaveSort() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 保存排序
		 */
		$this->modelProduct->saveSort($_POST['seqNoList']);
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
	 * 搜索产品
	 */
	function actionSearch() {
		/**
		 * 获得分类树
		 */
		$data['categories'] = $this->modelCate->getTree();
		/**
		 * 获得品牌树
		 */
		$data['brands'] = $this->modelBrand->getAll(array (
			'col_key' => getColkey(),
			'lang' => getLanguage()
		), 'sort_id ASC, brand_id ASC', 'brand_id, name', null, false);
		/**
		 * 输出产品搜索视图
		 */
		$this->_executeView('modules/products/search-products.tpl', $data);
	}

	/**
	 * 编辑产品
	 *
	 * @param array $data
	 * @access private
	 * @return void
	 */
	private function _editProduct(& $data) {
		/**
		 * 获得分类树
		 */
		$data['categories'] = $this->modelCate->getTree();
		/**
		 * 获得品牌树
		 */
		$data['brands'] = $this->modelBrand->getAll(array (
			'col_key' => getColkey(),
			'lang' => getLanguage()
		), 'sort_id ASC, brand_id ASC', 'brand_id, name', null, false);
		/**
		 * 输出产品编辑视图
		 */
		$this->_executeView('modules/products/modify-product.tpl', $data);
	}

	// -------------------------------------------------------------------

	/**
	 * 产品分类视图
	 */
	function actionCategories() {
		/**
		 * 获得分类树
		 */
		$data['categories'] = $this->modelCate->getTree(0, 'cate_id, parent_id, name, enname, created');
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出产品分类列表视图
		 */
		$this->_executeView('modules/products/categories.tpl', $data);
	}

	/**
	 * 添加产品分类视图
	 */
	function actionAddNewCategory() {
		/**
		 * 获得分类表数据入口操作句柄
		 */
		$tbl = & $this->modelCate->getTable();
		/**
		 * 获得分类表元数据
		 */
		$data['category'] = $this->_prepareData($tbl->meta);
		$data['category']['lang'] = getLanguage();
		$data['category']['col_key'] = getColkey();
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出编辑分类视图
		 */
		$this->_editCategory($data);
	}

	/**
	 * 修改产品分类视图
	 */
	function actionModifyCategory() {
		/**
		 * 查询分类数据
		 */
		$data['category'] = $this->modelCate->getOne((int) $_GET['id']);
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出编辑分类视图
		 */
		$this->_editCategory($data);
	}

	/**
	 * 保存产品分类
	 */
	function actionSaveCategory() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 保存分类
		 */
		$this->modelCate->save($_POST);
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
	 * 删除产品分类
	 */
	function actionRemoveCategories() {
		/**
		 * 按主键删除单个分类
		 */
		if ($_GET['id']) {
			$pkvs = array (
				(int) $_GET['id']
			);
		}
		/**
		 * 按主键删除多个分类
		 */
		if ($_POST['check']) {
			$pkvs = $_POST['check'];
		}
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 删除所选分类
		 */
		$this->modelCate->removeAll($pkvs);
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
	 * 产品分类排序视图
	 */
	function actionSortCategories() {
		/**
		 * 获父类ID
		 */
		$parent_id = isset ($_GET['parent_id']) ? (int) $_GET['parent_id'] : 0;
		/**
		 * 获得分类列表
		 */
		$data['categories'] = $this->modelCate->getTopCates($parent_id);
		/**
		 * 当没有分类数据时，给出提示并返回上一视图
		 */
		if (!$data['categories']) {
			js_alert('没有可排序的分类', 0, $this->_getBack());
		}
		/**
		 * 获得顶级分类列表
		 */
		$data['topCategories'] = $this->modelCate->getTopCates();
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出产品分类排序视图
		 */
		$this->_executeView('modules/products/sort-categories.tpl', $data);
	}

	/**
	 * 保存产品分类排序结果
	 */
	function actionSaveSortCategories() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 保存排序
		 */
		$this->modelCate->saveSort($_POST['seqNoList']);
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
	 * 编辑产品分类
	 *
	 * @param array $data
	 * @access private
	 * @return void
	 */
	private function _editCategory(& $data) {
		/**
		 * 获得分类树
		 */
		$data['categories'] = $this->modelCate->getTopCates();
		/**
		 * 输出产品编辑视图
		 */
		$this->_executeView('modules/products/modify-category.tpl', $data);
	}

	// -------------------------------------------------------------------

	/**
	 * 产品品牌视图
	 */
	function actionBrands() {
		/**
		 * 获得所有品牌
		 */
		$data['brands'] = $this->modelBrand->getAll(array (
			'col_key' => getColkey(),
			'lang' => getLanguage()
		), 'sort_id ASC, brand_id ASC', 'brand_id, name, pic, created, logo');
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出产品品牌列表视图
		 */
		$this->_executeView('modules/products/brands.tpl', $data);
	}
	
	/**
	 * 获取品牌介绍
	 */
	function actionGetBrandIntro(){
		$data['brand'] = $this->modelBrand->getOne((int) $_GET['id']);
		
		echo json_encode(unserialize($data['brand']['intro']));
		exit;
	}

	/**
	 * 添加产品品牌视图
	 */
	function actionAddNewBrand() {
		/**
		 * 获得品牌表数据入口操作句柄
		 */
		$tbl = & $this->modelBrand->getTable();
		/**
		 * 获得品牌表元数据
		 */
		$data['brand'] = $this->_prepareData($tbl->meta);
		$data['brand']['lang'] = getLanguage();
		$data['brand']['col_key'] = getColkey();
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出编辑品牌视图
		 */
		$this->_editBrand($data);
	}

	/**
	 * 修改产品品牌视图
	 */
	function actionModifyBrand() {
		/**
		 * 查询品牌数据
		 */
		$data['brand'] = $this->modelBrand->getOne((int) $_GET['id']);

		$data['brand']['memo'] = unserialize($data['brand']['memo']);
		$data['brand']['intro'] = unserialize($data['brand']['intro']);
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出编辑品牌视图
		 */
		$this->_editBrand($data);
	}

	/**
	 * 保存产品品牌
	 */
	function actionSaveBrand() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 保存品牌
		 */
		$this->modelBrand->saveBrand(& $_POST);
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
	 * 删除产品品牌
	 */
	function actionRemoveBrands() {
		/**
		 * 按主键删除单个品牌
		 */
		if ($_GET['id']) {
			$pkvs = array (
				(int) $_GET['id']
			);
		}
		/**
		 * 按主键删除多个品牌
		 */
		if ($_POST['check']) {
			$pkvs = $_POST['check'];
		}
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 删除所选品牌
		 */
		$this->modelBrand->removeAll($pkvs);
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
	 * 删除品牌图片
	 */
	function actionRemoveBrandPic() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 删除品牌图片
		 */
		$this->modelBrand->removeBrandPic((int) $_GET['id'], $_GET['witch']);
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
	 * 产品品牌排序视图
	 */
	function actionSortBrands() {
		/**
		 * 获得所有品牌
		 */
		$data['brands'] = $this->modelBrand->getAll(array (
			'col_key' => getColkey(),
			'lang' => getLanguage()
		), 'sort_id ASC, brand_id ASC', 'brand_id, name');
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出产品品牌排序视图
		 */
		$this->_executeView('modules/products/sort-brands.tpl', $data);
	}

	/**
	 * 保存产品品牌排序结果
	 */
	function actionSaveSortBrands() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 保存排序
		 */
		$this->modelBrand->saveSort($_POST['seqNoList']);
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
	 * 编辑产品品牌
	 *
	 * @param array $data
	 * @access private
	 * @return void
	 */
	private function _editBrand(& $data) {
		/**
		 * 输出产品品牌编辑视图
		 */
		$this->_executeView('modules/products/modify-brand.tpl', $data);
	}
	/**
	 * 商品评论 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionComments() {
		$pro_id = isset ($_GET['id']) ? (int) $_GET['id'] : null;

		if (!empty ($pro_id)) {

			$where = array (
				array (
					'pro_id',
					$pro_id
				)
			);

			$sortby = 'created DESC';

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
			$tbl = $this->modelComments->getTable();
			/**
			 * 载入分页助手 
			 */
			FLEA :: loadHelper('pager');
			/**
			 * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
			 */
			$pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
			$data['pager'] = $pager->getPagerData();
			$data['rows'] = $pager->findAll('*');
		}

		$this->_setBack();

		$this->_executeView('modules/products/comments.tpl', $data);
	}
	/**
	 * 回复评论 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionReplyComments() {
		if ($_GET['id']) {
			$com_id = (int) $_GET['id'];

			$where = array (
				array (
					'com_id',
					$com_id
				)
			);

			$data['comment'] = $this->modelComments->getOne($where);
		}

		$this->_executeView('modules/products/reply_comment.tpl', $data);
	}
	/**
	 * 保存回复 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionSaveReply() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 保存品牌
		 */
		$this->modelComments->getTable()->updateField(array (
			array (
				'com_id',
				$_POST['com_id']
			)
		), 'reply', $_POST['reply']);
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
	 * 删除评论 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionRemoveComments() {
		/**
		 * 按主键删除单个品牌
		 */
		if ($_GET['id']) {
			$pkvs = array (
				(int) $_GET['id']
			);
		}
		/**
		 * 按主键删除多个品牌
		 */
		if ($_POST['check']) {
			$pkvs = $_POST['check'];
		}
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 删除所选品牌
		 */
		$this->modelComments->removeAll($pkvs);
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
	 * 属性设置 @drop
	 * ----------------------------------------*/
	/**
	 * 产品属性项视图
	 */
	function actionAttributeCate() {
		/**
		 * 获得属性项树
		 */
		$data['categories'] = $this->modelCate->getTree(0, 'cate_id, parent_id, name, created');
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出产品属性项列表视图
		 */
		$this->_executeView('modules/products/set-attribute.tpl', $data);
	}

	/**
	 * 添加产品属性项视图
	 */
	function actionAddNewAttrCate() {
		/**
		 * 获得属性项表数据入口操作句柄
		 */
		$tbl = & $this->modelCate->getTable();
		/**
		 * 获得属性项表元数据
		 */
		$data['category'] = $this->_prepareData($tbl->meta);
		$data['category']['lang'] = getLanguage();
		$data['category']['col_key'] = getColkey();
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出编辑属性项视图
		 */
		$this->_editAttrCate($data);
	}

	/**
	 * 修改产品属性项视图
	 */
	function actionModifyAttrCate() {
		/**
		 * 查询属性项数据
		 */
		$data['category'] = $this->modelCate->getOne((int) $_GET['id']);
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出编辑属性项视图
		 */
		$this->_editAttrCate($data);
	}

	/**
	 * 保存产品属性项
	 */
	function actionSaveAttrCate() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 保存属性项
		 */
		$this->modelCate->save($_POST);
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
	 * 删除产品属性项
	 */
	function actionRemoveAttrCates() {
		/**
		 * 按主键删除单个属性项
		 */
		if ($_GET['id']) {
			$pkvs = array (
				(int) $_GET['id']
			);
		}
		/**
		 * 按主键删除多个属性项
		 */
		if ($_POST['check']) {
			$pkvs = $_POST['check'];
		}
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 删除所选属性项
		 */
		$this->modelCate->removeAll($pkvs);
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
	 * 产品属性项排序视图
	 */
	function actionSortAttrCates() {
		/**
		 * 获父类ID
		 */
		$parent_id = isset ($_GET['parent_id']) ? (int) $_GET['parent_id'] : 0;
		/**
		 * 获得属性项列表
		 */
		$data['categories'] = $this->modelCate->getTopCates($parent_id);
		/**
		 * 当没有属性项数据时，给出提示并返回上一视图
		 */
		if (!$data['categories']) {
			js_alert('没有可排序的属性项', 0, $this->_getBack());
		}
		/**
		 * 获得顶级属性项列表
		 */
		$data['topCategories'] = $this->modelCate->getTopCates();
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出产品属性项排序视图
		 */
		$this->_executeView('modules/products/sort-attrcates.tpl', $data);
	}

	/**
	 * 保存产品属性项排序结果
	 */
	function actionSaveSortAttrCates() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 保存排序
		 */
		$this->modelCate->saveSort($_POST['seqNoList']);
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
	 * 编辑产品属性项
	 *
	 * @param array $data
	 * @access private
	 * @return void
	 */
	private function _editAttrCate(& $data) {
		/**
		 * 获得属性项树
		 */
		$data['categories'] = $this->modelCate->getTopCates();
		/**
		 * 输出产品编辑视图
		 */
		$this->_executeView('modules/products/modify-attrcate.tpl', $data);
	}
	/**
	 * 产品副图列表视图
	 */
	function actionAttribute() {
		/**
		 * 读出产品资料
		 */
		$data['product'] = $this->modelProduct->getOne((int) $_GET['id'], null, 'pro_id, name, col_key, lang');
		/**
		 * 修改属性
		 */
		$att_id = isset ($_GET['att_id']) ? (int) $_GET['att_id'] : null;
		if ($att_id) {
			$data['attribute'] = $this->modelAttribute->getOne($att_id);
		}

		/**
		 * 取出属性项的种类数 
		 */
		if ($data['product']['attribute']) {

			$temp = array ();
			foreach ($data['product']['attribute'] as $key) {
				$temp = array_merge_recursive($temp, $key);
			}

			if (count(($data['product']['attribute'])) >= 2) {
				$cateIds = array_unique($temp['cate_id']);
			} else {
				$cateIds = array (
					$temp['cate_id']
				);
			}

			if ($cateIds) {

				$where = array (
					array (
						'col_key',
						getColkey()
					),
					array (
						'lang',
						getLanguage()
					),
					'in()' => array (
						'cate_id' => $cateIds
					)
				);

				$rows['cates'] = $this->modelCate->getAll($where, 'sort_id ASC, created DESC', 'cate_id, name', null, false);

				foreach ($rows['cates'] as $k => $value) {
					foreach ($data['product']['attribute'] as $kk => $v) {

						if ($value['cate_id'] == $v['cate_id']) {

							$rows['cates'][$k]['child'][] = $v;
						}
					}
				}

				$data['product']['attribute'] = $rows['cates'];
			}
		}
		/**
		 * 限制属性数量
		 */
		if (count($data['product']['attribute']) >= 20 && !$att_id) {
			$data['upload'] = 'no';
		}

		$data['categories'] = $this->modelCate->getTopCates();
		/**
		 * 设置当前视图为返回视图
		 */
		$this->_setBack();
		/**
		 * 输出商品属性列表视图
		 */
		$this->_executeView('modules/products/attribute.tpl', $data);
	}
	/**
	 * ajax检测是否已上传慢 
	 * 
	 * @access public
	 * @return void
	 */
	function actionAjaxCheckIsUploadFull() {
		if ($_POST['cate_id']) {
			$cate_id = (int) $_POST['cate_id'];
		}
		/**
		 * 读出产品资料
		 */
		$data['product'] = $this->modelProduct->getOne((int) $_POST['pro_id'], null, 'pro_id, name, col_key, lang');
		/**
		 * 取出属性项的种类数 
		 */
		if ($data['product']['attribute']) {

			$temp = array ();
			foreach ($data['product']['attribute'] as $key) {
				$temp = array_merge_recursive($temp, $key);
			}
			$temp = array_count_values($temp['cate_id']);

			if ($temp[$cate_id] >= 4) {
				$json_data = array (
					'uploads' => 'no'
				);
			} else {
				$json_data = array (
					'uploads' => 'yes'
				);
			}

			echo json_encode($json_data);
		}
	}
	/**
	 * 删除产品属性视图
	 */
	function actionRemoveAttrPic() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 删除商品属性图片
		 */
		$this->modelAttribute->removePic((int) $_GET['att_id']);
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
	 * 删除商品属性视图
	 */
	function actionRemoveAttr() {
		/**
		 * 按主键删除
		 */
		if ($_GET['att_id']) {
			$pkvs = array (
				(int) $_GET['att_id']
			);
		}
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 删除所选商品属性
		 */
		$this->modelAttribute->removeAll($pkvs);
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
	 * 保存商品属性
	 */
	function actionSaveAttr() {
		/**
		 * 设置异常拦截点
		 */
		__TRY();
		/**
		 * 保存商品属性
		 */
		$this->modelAttribute->save($_POST);
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
}
