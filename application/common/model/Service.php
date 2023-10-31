<?php
/**
 * Created by pengxingyuan.
 * Date: 2018/8/8
 * Time: 16:05
 * 短信服务商
 */

namespace app\common\model;


use think\Model;


class Service extends Model
{
    protected $pk='id';

    /**添加服务商
     * @param $data
     * @return false|int
     */
    public function insertService($data){

        $validate = new \app\common\validate\Service();
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
    public function updateService($data){

        $validate = new \app\common\validate\Service();
        $result = $validate->check($data);
        if (!$result) {
            $this->error = $validate->getError();
            return false;
        }

        $result=$this->isUpdate(true)->save($data);
        return $result;
    }
}