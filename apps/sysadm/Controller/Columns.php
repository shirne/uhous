<?php
//{{ 载入栏目脚手架类
FLEA::loadClass('Scaffolding_Columns');
//}}

class Controller_Columns extends Scaffolding_Columns
{
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
        parent::__construct();
    }

    function actionIndex()
    {
        $this->actionCreate();
    }
}

