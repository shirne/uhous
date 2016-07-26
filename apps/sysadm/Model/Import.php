<?php
/**
 * 产品批量导入模型
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Model
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

//{{ 载入表数据入口类
FLEA::loadClass('FLEA_Db_TableDataGateway');
//}}

/**
 * 产品表入口
 **/
class Table_Products extends FLEA_Db_TableDataGateway
{
    /**
     * 表名
     * 
     * @var string
     * @access public
     */
    public $tableName = 'products';
    /**
     * 主键
     * 
     * @var string
     * @access public
     */
    public $primaryKey = 'pro_id';
}

/**
 * 分类表入口
 **/
class Table_Categories extends FLEA_Db_TableDataGateway
{
    /**
     * 表名
     * 
     * @var string
     * @access public
     */
    public $tableName = 'categories';
    /**
     * 主键
     * 
     * @var string
     * @access public
     */
    public $primaryKey = 'cate_id';
}

class Model_Import
{
    private $tblProduct = null;

    private $tblCategory = null;

    private $dir = null;

    private $categories = null;

    private $dirData = null;

    function __construct()
    {
        $this->tblProduct =& FLEA::getSingleton('Table_Products');
        $this->tblCategory =& FLEA::getSingleton('Table_Categories');
    }

    function setDir($dir)
    {
        $this->dir = $dir;
    }

    function load($reload = null)
    {
        if (!$this->getData() || $reload == 'yes') {
            $this->_categories();
            foreach (new RecursiveDirectoryIterator($this->dir) as $i => $dir)
            {
                if (sprintf($dir) != '..' && sprintf($dir) != '.') {
                    $this->dirData[$i]['dir'] = sprintf($dir);
                    $this->dirData[$i]['files'] = $this->_products($dir);
                }
            }
            $this->build();
        }
    }

    function _categories()
    {
        foreach (new DirectoryIterator($this->dir) as $dir)
        {
            if (sprintf($dir) != '..' && sprintf($dir) != '.') {
                $this->categories[] = sprintf($dir);
            }
        }
    }

    function _products($dir)
    {
        $array = array();
        foreach (new DirectoryIterator(sprintf($dir)) as $file) {
            if (sprintf($file) != '..' && sprintf($file) != '.') {
                $array[] = sprintf($file);
            }
        }
        return $array;
    }

    function getData()
    {
        $build = unserialize(file_get_contents(FLEA::getAppInf('internalCacheDir') . DS . 'products.build'));
        if ($build) {
            return $build;
        }
    }

    function build()
    {
        $build = array();

        foreach ($this->categories as $i => $cateName) {
            $build[$i]['name'] = $cateName;
            $build[$i]['dirName'] = $this->dirData[$this->dir . DS . $cateName]['dir'];

            foreach ($this->dirData[$this->dir . DS . $cateName]['files'] as $file) {
                $f = explode('.', $file);
                $build[$i]['files'][] = array(
                    'name' => $f[0],
                    'filename' => $file,
                    'filepath' => $this->dir . DS . $cateName . DS . $file
                );
            }
        }

        // 写入文件
        $fp = fopen(FLEA::getAppInf('internalCacheDir') . DS . 'products.build', 'w+');
        fwrite($fp, serialize($build));
        fclose($fp);
        unset($fp, $build);
    }

    function getAllProducts($fields = '*')
    {
        return $this->tblProduct->findAll(array(array('lang', FLEA::getAppInf('defaultLanguage'))), null, null, $fields);
    }

    function setCateColkey($colkey = '')
    {
        return $this->tblCategory->updateField(
            null,
            'col_key',
            $colkey
        );
    }

    function setProductsColkey($colkey = '')
    {
        return $this->tblProduct->updateField(
            null,
            'col_key',
            $colkey
        );
    }

    function save()
    {
        $caterows = array();
        $prorows = array();

        $this->_categories();

        // 保存分类
        foreach ($this->categories as $cate) {
            $caterows[] = array(
                'name' => $cate,
                'lang' => FLEA::getAppInf('defaultLanguage')
            );
        }

        $cateIds = $this->tblCategory->createRowset($caterows);

        $data = $this->getData();

        foreach ($this->categories as $i => $cate) {
            if ($data[$i]['files']) {
                foreach ($data[$i]['files'] as $file) {
                    $prorows[] = array(
                        'cate_id' => $cateIds[$i],
                        'name' => $file['name'],
                        'pic' => $this->movePicture($file['filepath']),
                        'lang' => FLEA::getAppInf('defaultLanguage')
                    );
                }
            }
        }

        dump($this->tblProduct->createRowset($prorows));
    }

    function movePicture($file)
    {
        $fo = explode('.', $file);
        $newName = md5($file) . '.' . end($fo);
        copy($file, FLEA::getAppInf('uploadPath') . $newName);
        //unset($file);
        return $newName;
    }
}

