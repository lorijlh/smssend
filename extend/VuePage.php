<?php
/**
 * Created by dailinlin.
 * Date: 2017/10/11 15:55
 * for: VueJS分页扩展
 */

use think\facade\Config;
use think\facade\Request;

class VuePage
{

    public $firstRow; // 起始行数
    public $listRows; // 列表每页显示行数
    public $totalPages; // 分页总页面数
    public $currentPage;  //当前页码
    public $totalRows;  //总数据
    public $listData;   //列表数据

    /**
     * 架构函数
     * VuePage constructor.
     * @param $totalRows
     * @param int $listRows
     */
    public function __construct($totalRows, $listRows=15)
    {
        if (Config::get('paginate.list_rows')) {
            $listRows= Config::get('paginate.list_rows');
        }
        $this->listRows = $listRows;
        $this->currentPage = Request::instance()->get(Config::get('paginate.var_page'),1);
        $this->firstRow = ($this->currentPage-1)*$listRows;
        $this->totalPages = ceil($totalRows/$listRows);
        $this->totalRows = $totalRows;
    }


    /**
     * 设置表格数据
     * @param $list
     */
    public function setData($list){
        $this->listData = $list;
    }

    /**
     * 获取列表数据
     * @return mixed
     */
    public function getData(){
        return $this->listData;
    }

    /**
     * 当前页
     * @return mixed
     */
    public function getCurrent(){
        return $this->currentPage;
    }

    /**
     * 分页开始
     * @return mixed
     */
    public function getStart(){
        return $this->firstRow;
    }

    /**
     * 分页大小
     * @return int|mixed
     */
    public function getPageSize(){
        return $this->listRows;
    }

    /**
     * 分页结束
     * @return int|mixed
     */
    public function getEnd(){
        return $this->listRows;
    }


    /**
     * 总页数
     * @return float
     */
    public function getTotal(){
        return $this->totalPages;
    }

    /**
     * 总数据
     * @return mixed
     */
    public function getCount(){
        return $this->totalRows;
    }

    public function show(){
        return [
            'lists' => $this->getData(),
            'count' => $this->getCount(),
            'total' => $this->getTotal(),
            'current' => $this->getCurrent(),
            'size' => $this->getPageSize()
        ];
    }
}