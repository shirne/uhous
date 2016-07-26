<?php
/**
 * 用户提交修改密码申请时生成验证码并发送至邮箱
 */

FLEA::loadClass('FLEA_Db_TableDataGateway');

class Table_Changecode extends FLEA_Db_TableDataGateway
{
    /**
     * 表名
     * 
     * @var string
     * @access public
     */
    public $tableName = 'changecode';
    /**
     * 主键
     * 
     * @var string
     * @access public
     */
    public $primaryKey = 'id';
    
    public function _beforeCreate(& $row){
        $row['date']=date('Y-m-d H:i:s');
        return true;
    }
}

