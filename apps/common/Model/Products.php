<?php

/**
 * 商品管理模型
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Model
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

//{{ 载入抽象模型类
FLEA :: loadClass('Model_Abstract');
//}}

class Model_Products extends Model_Abstract {
	/**
	 * 构造函数
	 */
	function __construct() {
		/**
		 * 构造表数据入口实例
		 */
		parent :: __construct('Table_Products');
	}
	/**
	 * 获取产品数据
	 * 
	 * @param mixed $pro_id 
	 * @param string $fields 
	 * @param string $orderby 
	 * @access public
	 * @return void
	 */
	function getProById($pro_id = null, $fields = '*', $orderby = 'sort_id ASC, created DESC', $links = true) {
		if ($pro_id) {
			/**
			 * 构造条件 
			 */
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
					(int) $pro_id
				)
			);
			/**
			 * 返回产品数据
			 */
			$pro = $this->getOne($where, $orderby, $fields, $links);
			/**
			 * 恢复序列化数据
			 */
			if (!empty ($pro['params'])) {
				$pro['params'] = unserialize($pro['params']);
			}
			/**
			 * 返回数据
			 */
			return $pro;
		} else {
			/**
			 * 返回元数据
			 */
			return parent :: _prepareData($this->meta);
		}
	}
	/**
	 * 保存产品
	 *
	 * @param array $row
	 * @access public
	 * @return void
	 */
	function save(& $row) {
		/**
		 * 未定义产品名称
		 */
		if (!$row['name']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('商品名称'));
			return;
		}
		/**
		 * 未定义价格
		 */
		if (!$row['price']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('商品价格'));
			return;
		}
		/**
		 * 未定义市场价
		 */
		if (!$row['retail']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('市场零售价'));
			return;
		}
		/**
		 * 未定义产品分类
		 */
		if (!$row['cate_id']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('商品分类'));
			return;
		}
		/**
		 * 未定义产品品牌
		 */
		if (!$row['brand_id']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('商品品牌'));
			return;
		}
		/**
		 * 未定义语言版本
		 */
		if (!$row['lang']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('语言版本'));
			return;
		}
		/**
		 * 未定义栏目识别
		 */
		if (!$row['col_key']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('栏目识别'));
			return;
		}

		/**
		 * 强制转换数据类型
		 */
		$row['cate_id'] = (int) $row['cate_id'];
		$row['brand_id'] = (int) $row['brand_id'];
		$row['displayorder'] = (int) $row['displayorder'];
		$row['price'] = (float) $row['price'];

		//{{ 载入文件上传助手类
		FLEA :: loadClass('Helper_Upload');
		//}}

		/**
		 * 上传配置
		 */
		$_config = array (
			'uploadDir' => FLEA :: getAppInf('uploadPath'),
			'fileType' => '.jpg/.png/.gif',
			'maxsize' => 1024 * 1024, // 1M
	'thumb' => array (
				'prefix' => 'thumb_',
				'width' => 210,
				'height' => 158,
				'nocut' => true
			)
		);
		
		/**
		 * 实例化文件上传助手类
		 */
		$_uploader = new Helper_Upload($_config);
		$_uploader_thumb = new Helper_Upload($_config);

		/**
		 * 开始上传图片
		 */
		if ($_uploader->isReady('pic')) {
			$_pic = $_uploader->upload('pic');
			/**
			 * 获得图片路径
			 */
			if ($_pic) {
				$row['pic'] = $_pic['filename'];
			}
		}

		/**
		 * 开始上传图片
		 */
		if ($_uploader_thumb->isReady('thumb_pic')) {
			$_pic_thumb = $_uploader_thumb->upload('thumb_pic');
			/**
			 * 获得图片路径
			 */
			if ($_pic_thumb) {
				$row['thumb_pic'] = $_pic_thumb['filename'];
			}
		}
		
		$_config = array (
			'uploadDir' => FLEA :: getAppInf('uploadPath'),
			'fileType' => '.jpg/.png/.gif',
			'maxsize' => 1024 * 1024, // 1M
			'prefix' => 'params_',
	'thumb' => array (
				'prefix' => 'thumb_',
				'width' => 170,
				'height' => 85,
				'nocut' => true
			)
		);
		
		for($i=1;$i<5;$i++){
			$_uploader_thumb = new Helper_Upload($_config);
			$fild='params_intro_'.$i.'_pic';
			if ($_uploader_thumb->isReady($fild)) {
				$_pic_thumb[$i] = $_uploader_thumb->upload($fild);
				/**
				 * 获得图片路径
				 */
				if ($_pic_thumb[$i]) {
					$row['params']['intro'][$i]['pic'] = $_pic_thumb[$i]['filename'];
				}
			}
		}

		$row['params'] = serialize($row['params']);

		/**
		 * 保存数据
		 */
		if ($row['pro_id']) {
			$row['pro_id'] = (int) $row['pro_id'];
		}
		if (parent :: save(& $row)) {
			return true;
		}

		//{{ 载入异常处理类
		FLEA :: loadClass('Exception_Failed');
		//}}
		// 抛出异常
		__THROW(new Exception_Failed('保存商品失败'));
		return;
	}

	/**
	 * 保存排序结果
	 *
	 * @param string $seqNoList
	 * @access public
	 * @return void
	 */
	function saveSort($seqNoList) {
		if ($seqNoList) {
			/**
			 * 切割为记录数组
			 */
			$rows = explode(',', $seqNoList);
			/**
			 * 合并数据
			 */
			foreach ($rows as $row) {
				/**
				 * 切割为具体排序数组
				 */
				$tmp = explode(':', $row);
				$data[] = array (
					'pro_id' => $tmp[0],
					'sort_id' => $tmp[1]
				);
			}
			/**
			 * 更新结果
			 */
			if (!$this->tbl->updateRowset($data)) {
				//{{ 载入异常处理类
				FLEA :: loadClass('Exception_Failed');
				//}}
				// 抛出异常
				__THROW(new Exception_Failed('无法排序所选商品'));
				return;
			}
			return true;
		}
		/**
		 * 没有提交排序内容
		 */
		//{{ 载入异常处理类
		FLEA :: loadClass('Exception_Failed');
		//}}
		// 抛出异常
		__THROW(new Exception_Failed('没有提交排序内容'));
		return;
	}

	/**
	 * 删除全部产品
	 *
	 * @param array $pkvs
	 * @access public
	 * @return void
	 */
	function removeAll($pkvs) {
		/**
		 * 获得所有产品的图片字段
		 */
		$products = $this->getAll(array (
			'in()' => $pkvs
		), 'sort_id ASC', 'pic', null, false);
		/**
		 * 删除副图
		 */
		$modelPhoto = & FLEA :: getSingleton('Model_Photos');
		/**
		 * 获得所有产品副图的图片字段
		 */
		$photos = $modelPhoto->getAll(array (
			'in()' => array (
				'pro_id' => $pkvs
			)
		), 'photo_id ASC', 'photo_id, pic', null, false);
		/**
		 * 删除图片
		 */
		$this->_delPic($photos);
		/**
		 * 删除产品
		 */
		if (!$this->tbl->removeByPkvs($pkvs)) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Failed');
			//}}
			// 抛出异常
			__THROW(new Exception_Failed('无法删除所选商品'));
			return;
		}
		/**
		 * 删除图片
		 */
		$this->_delPic($products);
	}

	/**
	 * 删除产品图片
	 *
	 * @param int $pkv
	 * @access public
	 * @return void
	 */
	function removeProductPic($pkv, $type = 'pic') {
		/**
		 * 读出图片记录
		 * 2012/03/19
		 * 增加删除序列化字段中的图片信息的功能
		 */
		if(strpos($type,'.')!==false){
			$item=explode('.',$type);
			$itemstr=implode('_',$item);
			$pic = $this->getAll($pkv, 'sort_id ASC', $item[0], null, false);
			foreach($pic as $key=>$p){
				$params=unserialize($p[$item[0]]);
				$param=$params;
				$i=1;
				while(is_Array($param) && $item[$i]){
					$param=$param[$item[$i]];
					$i++;
				}
				
				$pic[$key][$itemstr]=$param;
			}
			$type=$itemstr;
		}else{
			$pic = $this->getAll($pkv, 'sort_id ASC', $type, null, false);
		}
		/**
		 * 删除图片
		 */
		$this->_delPic($pic, $type);
		/**
		 * 清空信息记录的图片字段
		 */
		if(!empty($item)){
			switch(count($item)){
				case 1:
				//unset($params[]);
				break;
				case 2:
				unset($params[$item[1]]);
				break;
				case 3:
				unset($params[$item[1]][$item[2]]);
				break;
				case 4:
				unset($params[$item[1]][$item[2]][$item[3]]);
				break;
				case 5:
				unset($params[$item[1]][$item[2]][$item[3]][$item[4]]);
				break;
			}
			$this->tbl->updateField(array (
					array (
						'pro_id',
						$pkv
					)
				), $item[0], serialize($params));
		}else{
			if (!$this->tbl->updateField(array (
					array (
						'pro_id',
						$pkv
					)
				), $type, '')) {
				//{{ 载入异常处理类
				FLEA :: loadClass('Exception_Failed');
				//}}
				// 抛出异常
				__THROW(new Exception_Failed('删除商品图片失败'));
				return;
			}
		}
	}

	/**
	 * 删除图片
	 * 
	 * @param array $rows
	 * @access protected
	 * @return void
	 */
	function _delPic($rows, $type='pic') {
		/**
		 * 上传目录路径
		 */
		$_uploadDir = FLEA :: getAppInf('uploadPath');
		if ($rows) {
			foreach ($rows as $row) {
				/**
				 * 删除原图
				 */
				if ($row[$type] && file_exists($_uploadDir . DS . $row[$type])) {
					/**
					 * 删除文件
					 */
					@ unlink($_uploadDir . DS . $row[$type]);
				}
				/**
				 * 删除缩略图
				 */
				if (file_exists($_uploadDir . DS . 'thumb_' . $row[$type])) {
					/**
					 * 删除文件
					 */
					@ unlink($_uploadDir . DS . 'thumb_' . $row[$type]);
				}
			}
		}
		/**
		 * 回收内存
		 */
		unset ($rows);
	}

}
