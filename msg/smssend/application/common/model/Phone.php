<?php
/**
 * Created by dailinlin.
 * Date: 2019/6/4 12:00
 * for:
 */


namespace app\common\model;


use cache\Redis;
use think\facade\Config;
use think\Model;

class Phone extends Model
{
    protected $pk='id';

    protected $autoWriteTimestamp = true;

    /**添加服务商
     * @param $data
     * @return false|int
     */
    public function insertPhone($data){

        $validate = new \app\common\validate\Phone();
        $result = $validate->check($data);
        if (!$result) {
            $this->error = $validate->getError();
            return false;
        }

        $result=$this->save($data);
        return $result;
    }

    public function insertCache($data,$uid=0){
        $time = time();
        $temp = [];
        $config = Config::get('redis.');

        $i=0;
        foreach ($data as $item){
            if (!isset($item[0])){
                continue;
            }
            $temp[] = [
                'uid' => $uid,
                'phone' => $item[0],
                'tag' => isset($item[1])?$item[1]:date('Y-m-d'),
                'create_time' =>$time
            ];
            $i++;
            if ($i%6000==0||$i==count($data)){
                Redis::getInstance($config)->rPush('phoneCache',json_encode($temp));
                unset($temp);
            }

        }

        //如果有很多空字符串
        if ($i<count($data)){
            Redis::getInstance($config)->rPush('phoneCache',json_encode($temp));
        }
        return $i;
    }

    /**
     * 批量添加服务商
     * @param $data
     * @return \think\Collection
     */
    public function insertBatch($data){
        $result = $this->saveAll($data);
        return $result;
    }


    /**编辑服务商
     * @param $data
     * @return false|int
     */
    public function updatePhone($data){

        $validate = new \app\common\validate\Phone();
        $result = $validate->check($data);
        if (!$result) {
            $this->error = $validate->getError();
            return false;
        }

        $result=$this->isUpdate(true)->save($data);
        return $result;
    }


}