<?php


namespace app\common\model;


use think\Model;

class Document extends Model
{
    protected $pk='id';
    protected $autoWriteTimestamp = true;


    /**添加文章
     * @param $data
     * @return false|int
     */
    public function insertDocument($data){
        $validate = new \app\common\validate\Document();
        $result = $validate->check($data);
        if (!$result) {
            $this->error = $validate->getError();
            return false;
        }

        $result=$this->save($data);
        return  $result;
    }
    /**
     * 编辑文章
     */
    public function updateDocument($data){

        $validate = new \app\common\validate\Document();
        $result = $validate->check($data);
        if (!$result) {
            $this->error = $validate->getError();
            return false;
        }

        $result=$this->isUpdate(true)->save($data);
        return  $result;
    }

}