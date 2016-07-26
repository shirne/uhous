<?php
/**
 * 用户注册或邀请时生成邀请码发送至邮箱并保存数据
 */

FLEA::loadClass('FLEA_Db_TableDataGateway');

class Table_Invidecode extends FLEA_Db_TableDataGateway
{
    /**
     * 表名
     * 
     * @var string
     * @access public
     */
    public $tableName = 'invidecode';
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

