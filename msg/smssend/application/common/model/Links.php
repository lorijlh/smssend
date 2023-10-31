<?php


namespace app\common\model;


use think\Model;

class Links extends Model
{
    protected $pk='id';
    protected $autoWriteTimestamp = true;


    /**添加服务商
     * @param $data
     * @return false|int
     */
    public function insertLinks($data){

        $validate = new \app\common\validate\Links();
        $result = $validate->check($data);
        if (!$result) {
            $this->error = $validate->getError();
            return false;
        }

        $result=$this->save($data);
        return $result;
    }

    /**编辑服务商
     * @param $data
     * @return false|int
     */
    public function updateLinks($data){

        $validate = new \app\common\validate\Links();
        $result = $validate->check($data);
        if (!$result) {
            $this->error = $validate->getError();
            return false;
        }

        $result=$this->isUpdate(true)->save($data);
        return $result;
    }
}