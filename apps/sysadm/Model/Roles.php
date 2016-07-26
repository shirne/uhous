<?php
/**
 * 管理员角色管理模型
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Model
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

//{{ 载入角色管理基类
FLEA::loadClass('FLEA_Rbac_RolesManager');
//}}

class Model_Roles extends FLEA_Rbac_RolesManager
{
    /**
     * 表名
     *
     * @var string
     * @access public
     */
    public $tableName = 'roles';
    /**
     * 主键
     *
     * @var string
     * @access public
     */
    public $primaryKey = 'role_id';
    /**
     * 角色字段名
     *
     * @var string
     * @access public
     */
    public $rolesNameField = 'name';
    /**
     * 多对多关系，一个角色管理多个栏目
     *
     * @var array
     * @access public
     */
    public $manyToMany = array(
        array(
            'tableClass' => 'Table_Columns',
            'mappingName' => 'columns',
            'joinTable' => 'role_has_columns',
            'fields' => array('col_id', 'parent_id', 'name', 'col_key', 'controller', 'action', 'args', 'lang')
        )
    );
    /**
     * 按角色查询栏目列表
     *
     * @param mixed $role
     * @param string $orderby
     * @param string $fields
     * @access public
     * @return array
     */
    function findRolesColumns($role, $orderby = 'role_id ASC', $fields = 'label, name')
    {
        // 查询出该角色的信息
        $rows = $this->findAll(
            array(
                'in()' => array(
                    $this->rolesNameField => $role
                )
            ),
            $orderby,
            null,
            $fields
        );
        $columns = null;
        // 遍历数据
        for ($i = 0; $i < count($rows); $i++) {
            if (is_array($columns)) {
                if ($rows[$i]['columns']) {
                    $columns = array_merge($rows[$i]['columns'], $columns);
                }
            } else {
                if ($rows[$i]['columns']) {
                    $columns = $rows[$i]['columns'];
                }
            }
        }
        /**
         * 获得所有语言版本
         */
        $allLanguages = array_keys(FLEA::getAppInf('languages'));
        /**
         * 输出栏目列表
         */
        if($columns) {
            /**
             * 将所有栏目数据按语言版本分组
             */
            $groupColumns = array_group_by($columns, 'lang');
            /**
             * 将分好组的栏目数据转换成树状目录
             */
            foreach ($allLanguages as $lang) {
                if ($groupColumns[$lang]) {
                    $return[$lang] = array_to_tree($groupColumns[$lang], 'col_id', 'parent_id', 'childrens');
                }
            }
            return $return;
        }
        return null;
    }
    /**
     * 返回新的角色识别名称
     *
     * @param string $name 默认识别名称
     * @access public
     * @return string
     */
    function newRoleName($name = 'UserRole')
    {
        $count = $this->findCount(null, 'role_id');
        return strtoupper($name) . ($count + 1);
    }
    /**
     * 保存角色权限设置
     * 
     * @param $_POST $competence
     * @access public
     */
    function saveCompetence(&$competence)
    {
        $rows =& $competence;
        $columns = $_POST['col_id'];
        foreach ($columns as $column) {
            $rows['columns'][] = array(
                'col_id' => $column
            );
        }
        unset($rows['col_id']);
        /**
         * 返回结果
         */
        return $this->save($rows);
    }
    /**
     * 按主键(集)删除角色
     *
     * @param array $pkvs 角色主键
     * @access public
     */
    function removeRolesByPkvs($pkvs)
    {
        /**
         * 未传递角色主键
         */
        if (!$pkvs) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_PkvsNotFound');
            //}}
            // 抛出异常
            __THROW(new Exception_PkvsNotFound('角色'));
            return;
        } else {
            /**
             * 查询角色
             */
            $roles = $this->findAll(
                array(
                    'in()' => $pkvs
                ),
                null,
                null,
                'role_id',
                false
            );
            /**
             * 角色记录不存在
             */
            if (!$roles) {
                //{{ 载入异常处理类
                FLEA::loadClass('Exception_RolesNotFound');
                //}}
                // 抛出异常
                __THROW(new Exception_RolesNotFound($pkvs));
                return;
            }
        }
        /**
         * 实例化管理员管理模型
         */
        $modelAdmin =& FLEA::getSingleton('Model_Admin');
        /**
         * 查询应用此角色的管理员
         */
        foreach ($pkvs as $pkv) {
            if ($users = $modelAdmin->findAll(array(array('roles.role_id', (int)$pkv)), null, null, 'admin_id')) {
                break;
            }
        }
        /**
         * 已有管理员应用此角色
         */
        if ($users) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_RolesIsEnabled');
            //}}
            // 抛出异常
            __THROW(new Exception_RolesIsEnabled(count($users)));
            /**
             * 回收内存
             */
            unset($modelAdmin, $users);
            return;
        }
        /**
         * 返回删除结果
         */
        return $this->removeByPkvs($pkvs);
    }
}

