<?php


namespace app\common\model;


use think\Model;

class SendLog extends Model
{
    protected $pk='id';

    protected $autoWriteTimestamp = true;


    /**
     * 保存日志
     * @param $uid
     * @param $phone
     * @param $content
     */
    public function saveLog($uid,$phone,$content){
        $data['uid'] = $uid;
        $data['phone'] = $phone;
        $data['content'] = $content;
        $this->save($data);
        return $this->id;
    }

    /**
     * 发送成功日志
     * @param $log_id
     */
    public function sendSucceed($log_id,$is_temp=0){
        $data['id'] = $log_id;
        $data['state'] = 1;
        $data['is_temp'] = $is_temp;
        $this->isUpdate(true)->save($data);
    }

    /**
     * 发送失败日志
     * @param $log_id
     */
    public function sendFail($log_id,$msg,$is_temp=0){
        $data['id'] = $log_id;
        $data['state'] = 2;
        $data['msg'] = $msg;
        $data['is_temp'] = $is_temp;
        $this->isUpdate(true)->save($data);
    }
}