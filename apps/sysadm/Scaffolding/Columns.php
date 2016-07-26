<?php
/**
 * 栏目管理脚手架
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Scaffolding
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

//{{ 载入简单脚手架类
FLEA::loadClass('Scaffolding_Sample');
//}}

class Scaffolding_Columns extends Scaffolding_Sample
{
    /**
     * 存放系统数据
     * 
     * @var array
     * @access private
     */
    private $_data = array();
    /**
     * 构造函数
     * 
     * @access protected
     */
    function __construct()
    {
        /**
         * 执行父类构造函数
         */
        parent::__construct('Table_Columns');
        /**
         * 输入模块数据
         */
        $this->_data['modules'] = $this->loadData('modules');
    }
    /**
     * 保存栏目
     * 
     * @access public
     * @return void
     */
    function actionSave()
    {
        /**
         * 是否应用模块
         */
        if ($_POST['enable_mod'] == 'yes') {
            foreach ($this->_data['modules'] as $mod) {
                if ($mod['mod_id'] == (int)$_POST['mod']) {
                    $module = $this->prepareData($mod, $_POST);
                    break;
                }
            }
            /**
             * 存储其子模块
             */
            $submodule = $module['submodules'];
            // 清除子模块
            unset($module['submodules']);
            /**
             * 处理子模块的父级ID
             */
            if ($pkv = $this->_tdg->create($module)) {
                foreach ($submodule as $key => $sub) {
                    $submodule[$key]['parent_id'] = $pkv;
                }
            }
            /**
             * 写入子模块数据
             */
            if ($this->_tdg->createRowset($submodule)) {
                js_alert('Success!', 0, $this->_getBack());
            }
            js_alert('Fail!', 0, $this->_getBack());
        }
        parent::actionSave();
    }
    /**
     * 删除栏目
     *
     * @access public
     * @return void
     */
    function actionDelete()
    {
        $msg = 'Fail!';
        if ($this->_tdg->removeByPkv((int)$_GET[$this->_tdg->primaryKey])) {
            /**
             * 删除子栏目
             */
            $this->_tdg->removeByConditions(
                array(
                    array('parent_id', (int)$_GET[$this->_tdg->primaryKey])
                )
            );
            $msg = 'Success!';
        }
        /**
         * 返回消息
         */
        js_alert($msg, null, $this->_getBack());
    }
    /**
     * 记录编辑视图
     * 
     * @param mixed $row 
     * @access protected
     * @return void
     */
    protected function _editFields($data)
    {
        /**
         * 输入模块数据
         */
        $data['modules'] = $this->_data['modules'];
        /**
         * 获得父级栏目
         */
        $data['parents'] = $this->getRows('parent');
        /**
         * 输出视图
         */
        include SCAFF_DIR . DS . 'Columns/edit.php';
    }
    /**
     * 准备栏目数据
     * 
     * @param mixed $mod 模块数据
     * @param mixed $post 提交数据
     * @access protected
     * @return array
     */
    protected function prepareData($mod, $post)
    {
        /**
         * 写入栏目名称
         */
        if (trim($post['name'])) {
            $parent['name'] = trim($post['name']);
        }
        /**
         * 写入栏目别名
         */
        if (trim($post['col_key'])) {
            $parent['col_key'] = trim($post['col_key']);
        }
        /**
         * 写入栏目语言
         */
        if (trim($post['lang'])) {
            $parent['lang'] = trim($post['lang']);
        }
        /**
         * 写入栏目父类
         */
        $parent['parent_id'] = $post['parent_id'];
        /**
         * 控制器设置
         */
        $parent['controller'] = $post['controller'];
        $parent['action'] = $post['action'];
        $parent['args'] = $post['args'];
        /**
         * 控制器设置
         */
        $parent['controller'] = $mod['controller'];
        $parent['action'] = $mod['action'];
        $parent['args'] = $mod['args'];
        /**
         * 子模块设置
         */
        if ($mod['submodules']) {
            foreach ($mod['submodules'] as $key => $sub) {
                /**
                 * 注销不需要的数据
                 */
                unset($mod['submodules'][$key]['mod_id']);
                unset($mod['submodules'][$key]['parent_id']);
                unset($mod['submodules'][$key]['belongs_to']);
                unset($mod['submodules'][$key]['is_hide']);
                unset($mod['submodules'][$key]['childrens']);
                /**
                 * 替换栏目别名
                 */
                $mod['submodules'][$key]['col_key'] = $parent['col_key'];
                /**
                 * 替换栏目语言
                 */
                $mod['submodules'][$key]['lang'] = $parent['lang'];
            }
        }
        $parent['submodules'] = $mod['submodules'];
        /**
         * 回收内存
         */
        unset($mod, $post);
        /**
         * 返回数据
         */
        return $parent;
    }
    /**
     * 获得数据集
     *
     * @param mixed $type 数据类型
     * @access public
     * @return void
     */
    protected function getRows($type = null)
    {
        if ($type == 'parent') {
            $where = array(
                array('parent_id', 0)
            );
        }
        return $this->_tdg->findAll($where);
    }
    /**
     * 载入系统数据
     * 
     * @param mixed $type 系统数据类型
     * @access protected
     * @return void
     */
    protected function loadData($type, $lifetime=true)
    {
        // 缓存配置信息
        $cacheid = 'scaffolding.' . $type;
        $data = FLEA::getCache($cacheid, $lifetime, true, true);
        if (!is_array($data)) {
            /**
             * 初始化数据
             */
            $data = null;
            /**
             * 合并系统数据文件路径
             */
            $file = str_replace('/', DS, SCAFF_DIR . '/Columns/' . $type . '.php');
            /**
             * 返回文件
             */
            if (file_exists($file)) {
                $data = unserialize(file_get_contents($file));
            }
            FLEA::writeCache($cacheid, $data, true);
        }
        /**
         * 返回数据
         */
        return $data;
    }
}

