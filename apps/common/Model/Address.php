<?php

/**
 * 地址管理模块模型 
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Model
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

//{{ 载入模型抽象基类
FLEA :: loadClass('Model_Abstract');
//}}

class Model_Address extends Model_Abstract {
	/**
	 * 构造函数 
	 */
	function __construct() {
		/**
		 * 构造表数据入口实例
		 */
		parent :: __construct('Table_Address');
	}
	/**
	 * 保存地址
	 *
	 * @param array $row
	 * @access public
	 * @return void
	 */
	function save(& $row) {
		/**
		 * 未定义信息
		 */
		if (!$row['username']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('收货人'));
			return;
		}

		if (!$row['phone'] && !$row['tel']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('手机号码或电话号码'));
			return;
		}

		if (!$row['post']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('邮政编码'));
			return;
		}

		if (!$row['address']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('收货地址'));
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
		 * 保存数据
		 */
		if ($row['add_id']) {
			$row['add_id'] = (int) $row['add_id'];
		}
		if (parent :: save(& $row)) {
			return true;
		}

		//{{ 载入异常处理类
		FLEA :: loadClass('Exception_Failed');
		//}}
		// 抛出异常
		__THROW(new Exception_Failed('保存地址失败'));
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
					'add_id' => $tmp[0],
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
				__THROW(new Exception_Failed('无法排序所选地址'));
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
	 * 删除全部地址
	 *
	 * @param array $pkvs 
	 * @access public
	 * @return 成功返回 true
	 */
	function removeAll($pkvs) {
		/**
		 * 删除地址
		 */
		if (!$this->tbl->removeByPkvs($pkvs)) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Failed');
			//}}
			// 抛出异常
			__THROW(new Exception_Failed('无法删除所选地址'));
			return;
		} else {
			return true;
		}
	}
}