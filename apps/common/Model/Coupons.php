<?php

/**
 * 优惠券管理模块模型 
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

class Model_Coupons extends Model_Abstract {
	/**
	 * 构造函数 
	 */
	function __construct() {
		/**
		 * 构造表数据入口实例
		 */
		parent :: __construct('Table_Coupons');
	}
	/**
	 * 保存优惠券
	 *
	 * @param array $row
	 * @access public
	 * @return void
	 */
	function save(& $row) {
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
		 * 未定义名称
		 */
		if (!$row['name']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('优惠券名称'));
			return;
		}
		/**
		 * 未定义最小订单金额
		 */
		if (!$row['minprice']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('最小订单金额'));
			return;
		}
		/**
		 * 未定义价值
		 */
		if (!$row['value']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('优惠券价值'));
			return;
		}

		/**
		 * 未定义截止日期
		 */
		if (!$row['period']) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Undefined');
			//}}
			// 抛出异常
			__THROW(new Exception_Undefined('截止日期'));
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
		//{{ 载入文件上传助手类
		FLEA :: loadClass('Helper_Upload');
		//}}

		/**
		 * 上传配置
		 */
		$_config = array (
			'uploadDir' => FLEA :: getAppInf('uploadPath'),
			'fileType' => '.jpg/.png/.gif',
			'maxsize' => 1024 * 1024 // 1M
	
		);

		/**
		 * 实例化文件上传助手类
		 */
		$_uploader = new Helper_Upload($_config);

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
		 * 保存数据
		 */
		if ($row['cou_id']) {
			$row['cou_id'] = (int) $row['cou_id'];
		}
		if (parent :: save(& $row)) {
			return true;
		}

		//{{ 载入异常处理类
		FLEA :: loadClass('Exception_Failed');
		//}}
		// 抛出异常
		__THROW(new Exception_Failed('保存优惠券失败'));
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
					'cou_id' => $tmp[0],
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
				__THROW(new Exception_Failed('无法排序所选优惠券'));
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
	 * 删除全部优惠券
	 *
	 * @param array $pkvs 
	 * @access public
	 * @return 成功返回 true
	 */
	function removeAll($pkvs) {
		/**
		 * 删除优惠券
		 */
		if (!$this->tbl->removeByPkvs($pkvs)) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Failed');
			//}}
			// 抛出异常
			__THROW(new Exception_Failed('无法删除所选优惠券'));
			return;
		} else {
			return true;
		}
	}
	/**
	 * 删除优惠券图片
	 * 
	 * @param int $pkv
	 * @access public
	 * @return void
	 */
	function removePic($pkv) {
		/**
		 * 读出图片记录
		 */
		$pic = $this->getAll($pkv, 'sort_id ASC', 'pic', null, false);
		/**
		 * 删除图片
		 */
		$this->_delPic($pic);
		/**
		 * 清空信息记录的图片字段
		 */
		if (!$this->tbl->updateField(array (
				array (
					'cou_id',
					$pkv
				)
			), 'pic', '')) {
			//{{ 载入异常处理类
			FLEA :: loadClass('Exception_Failed');
			//}}
			// 抛出异常
			__THROW(new Exception_Failed('删除优惠券图片失败'));
			return;
		}
	}
	
	/**
	 * 赠送优惠券给指定的用户
	 * $cou_id  优惠券ID
	 * $mem_id  会员ID
	 */
	function send($cou_id,$mem_id){
	    $ucou=& FLEA :: getSingleton('Table_Membercoupon');
	    $time=time();
		$rowcou=array(
		    'member_id'=>$mem_id,
		    'sn'=>md5($time),
		    'created'=>$time,
		    'cou_id'=>$cou_id
		);
		$where=array(
	        'cou_id'=>$cou_id
	    );
	    $row=$this->getOne($where);
	    if(empty($row))return false;
	    
	    //按日期
	    if($row['invaluetype']==0){
	        $rowcou['invaluetime']=$row['period'];
	    }else{//按日间
	        $rowcou['invaluetime']=$row['exprise']+$time;
	    }
	    
	    $rowcou['value']=$row['value'];
		
		return $ucou->create($rowcou);
	}

	/**
	 * 删除图片
	 * 
	 * @param array $rows
	 * @access protected
	 * @return void
	 */
	function _delPic($rows) {
		/**
		 * 上传目录路径
		 */
		$_uploadDir = FLEA :: getAppInf('uploadPath');
		if ($rows) {
			foreach ($rows as $row) {
				if ($row['pic'] && file_exists($_uploadDir . DS . $row['pic'])) {
					/**
					 * 删除文件
					 */
					@ unlink($_uploadDir . DS . $row['pic']);
				}
			}
		}
		/**
		 * 回收内存
		 */
		unset ($rows);
	}
}
