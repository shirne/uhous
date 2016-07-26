<?php
/**
 * 邮箱验证码缓存
 */
FLEA::loadClass('Model_Abstract');

class Model_Changecode extends Model_Abstract
{
    function __construct()
    {
        parent::__construct('Table_Changecode');
    }
    
    //保存验证码
    function save(& $row){
        return parent::save($row);
    }
    
    //设定注册通过状态
    function setok($hash){
        $row=$this->getOneByHash($hash);
        if(empty($row))return false;
        $row['stat']=1;
        $row['fdate']=date('Y-m-d H:i:s');
        
        return parent::save($row);
    }
    
    //根据哈希码获取,只取状态为0的
    //用于注册时验证
    function getOneByHash($hash){
        $condition=array(
            'hash'=>$hash,
            'stat'=>0
        );
        return parent::getOne($condition);
    }
    
    //根据用户获取提交过的申请
    function getAllByUser($userid,$stat=null){
        $condition=array(
            'userid'=>intval($userid)
        );
        if($stat!=null)$condition['stat']=intval($stat);
        return parent::getOne($condition);
    }
    
    //根据邮箱获取
    function getOneByEmail($email,$stat=null){
        $condition=array(
            'email'=>$email
        );
        if($stat!=null)$condition['stat']=intval($stat);
        return parent::getOne($condition);
    }
    
    //根据邮箱删除
    function del($email){
        $condition=array(
            'email'=>$email
        );
        $this->tbl->removeByConditions($condition);
    }
    
    //清除过期条目,三天过期
    function clear($day=3){
        $this->tbl->removeByConditions('stat=0 AND DATEDIFF(date,\''.date('Y-m-d').'\')>'.intval($day));
    }

}
