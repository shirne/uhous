<?php
/**
 * 访问控制模型
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Model
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

class Model_Act
{
    /**
     * 构造函数
     *
     * @access public
     * @return Model_Acl
     */
    function __construct()
    {
    }

    /**
     * 获得访问控制列表
     *
     * @param mixed $user
     * @access public
     * @return string
     */
    function getACT()
    {
        /**
         * 实例化Rbac
         */
        $rbac =& FLEA::getSingleton('FLEA_Rbac');
        $user = $rbac->getUser();
        /**
         * 返回角色控制列表
         */
        if ($user) {
            //$user['roles'] = array('ADMIN');
            //$user['RBAC_ROLES'] = array('ADMIN');
            /**
             * 获得控制器列表
             */
            $ctls = $this->getCtlList($user['roles'], FLEA::getAppInf('defaultLanguage'));
            $act = array(
                'Admin' => array(
                    'allow' => RBAC_EVERYONE,
                    'actions' => array(
                        'Login' => array(
                            'allow' => RBAC_NO_ROLE
                        ),
                        'Profile' => array(
                            'allow' => strtoupper(implode(',' , $user['roles']))
                        ),
                        'Logout' => array(
                            'allow' => strtoupper(implode(',' , $user['roles']))
                        ),
                    )
                ),
                'Base' => array(
                    'allow' => RBAC_EVERYONE
                ),
                'Dashboard' => array(
                    'allow' => RBAC_HAS_ROLE
                ),
                'Settings' => array(
                    'allow' => RBAC_HAS_ROLE
                )
            );
            if ($ctls) {
                /**
                 * 设置当前权限
                 */
                foreach ($ctls as $ctl) {
                    $act[$ctl] = array(
                        'allow' => strtoupper(implode(',' , $user['roles']))
                    );
                }
            }
            /**
             * 返回列表
             */
            return $act;
        }
        return array(
            'Admin' => array(
                'allow' => RBAC_EVERYONE
            )
        );
    }

    /**
     * 获得控制器列表
     *
     * @param mixed $lang 
     * @access public
     * @return array
     */
    function getCtlList($role, $lang = null)
    {
        /**
         * 管理员管理所有栏目
         */
        if (in_array('ADMIN', $role)) {
            /**
             * 实例化栏目管理模型
             */
            $modelColumns =& FLEA::getSingleton('Model_Columns');
            /**
             * 获得栏目清单
             */
            $columns = $modelColumns->getAll();
            unset($modelColumns);
        } else {
            /**
             * 实例化角色管理模型
             */
            $modelRoles =& FLEA::getSingleton('Model_Roles');
            $this->rolesNameField = isset($this->rolesNameField) ? $this->rolesNameField : 'name';
            // 查询出该角色的信息
            $role = $modelRoles->findAll(
                array(
                    'in()' => array(
                        $this->rolesNameField => $role
                    )
                )
            );
            $columns = null;
            // 遍历数据
            for ($i = 0; $i < count($role); $i++) {
                if (is_array($columns)) {
                    if ($role[$i]['columns']) {
                        $columns = array_merge($role[$i]['columns'], $columns);
                    }
                } else {
                    if ($role[$i]['columns']) {
                        $columns = $role[$i]['columns'];
                    }
                }
            }
        }
        /**
         * 按语言版本分组栏目
         */
        $buildLangColumns = array_group_by($columns, 'lang');
        unset($columns);
        /**
         * 筛选各语言版本中的控制器
         */
        foreach ($buildLangColumns as $lang => $blc) {
            $buf[$lang] = array_col_values($blc, 'controller');
        }
        unset($buildLangColumns);

        if ($buf) {
            /**
             * 清理空的控制器及重复控制器
             */
            foreach ($buf as $lang => $ctls) {
                if (!$columns[$lang]) {
                    $columns[$lang] = array();
                }
                foreach ($ctls as $ctl) {
                    if ($ctl && !in_array($ctl, $columns[$lang])) {
                        $columns[$lang][] = $ctl;
                    }
                }
            }
        }

        unset($buf);

        if ($lang) {
            return $columns[$lang];
        }
        return $columns;
    }
}

