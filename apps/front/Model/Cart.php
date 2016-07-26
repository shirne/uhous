<?php
/**
 * 购物车模型
 */
#doc
#    classname:    Model_Cart
#    scope:        PUBLIC
#
#/doc

class Model_Cart
{
    #    internal variables
    private $cart;
    
    private $strcookie='cartcookie';
    
    private $modelProducts;

    #    Constructor
    function __construct ()
    {
        
        isset($_COOKIE[$this->strcookie])?
        $ckcart=unserialize($_COOKIE[$this->strcookie]):
        $ckcart=false;
        
		if($ckcart){
		    foreach($ckcart as $key=>$val){
		       if(is_int($key)){
		          $this->cart[$key]=intval($val);
		        }
		    }
		}else{
		    $this->cart=array();
		}
    }
    ###
    
    public function count(){
        return count($this->cart);
    }
    
    /**
     * 添加一个产品到购物车
     */
    public function add($id,$num=1){
        $id=intval($id);
        array_key_exists($id,$this->cart)?
        $this->cart[$id]=$this->cart[$id]+$num:
        $this->cart[$id]=$num;
    }
    
    public function setNum($id,$num=1){
        $this->cart[$id]=$num;
    }
    
    /**
     * 删除一个产品在购物车
     */
    public function del($id){
        $id=intval($id);
        if(array_key_exists($id,$this->cart)){
            unset($this->cart[$id]);
        }
    }
    
    /**
     * 获取一个产品的数目
     */
    public function getItem($id){
        $id=intval($id);
        return array_key_exists($id,$this->cart)?
                $this->cart[$id]:
                0;
    }
    
    //获取所有产品属性
    public function getProducts(){
        return $this->cart;
    }
    
    //获取所有产品的id数组
    public function getIds(){
        return array_keys($this->cart);
    }
    
    /**
     * 清除购物车,自动输出
     */
    public function clear(){
        $this->cart=array();
        return $this->flush();
    }
    
    /**
     * 输出购物车信息
     */
    public function flush(){
        return setCookie($this->strcookie,serialize($this->cart),null,'/',$_SERVER['SERVER_NAME']);
    }

}
