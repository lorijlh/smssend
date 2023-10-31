<?php
/**
 * Created by dailinlin.
 * Date: 2019/6/24 10:31
 * for:
 */


namespace app\common\model;


use think\Model;

class Template extends Model
{
    protected $pk='id';

    /**添加模板
     * @param $data
     * @return false|int
     */
    public function insertTemplate($data){

        $validate = new \app\common\validate\Template();
        $result = $validate->check($data);
        if (!$result) {
            $this->error = $validate->getError();
            return false;
        }

        if (isset($data['params'])) {
            if (count($data['params'])==0){
                $this->error = '请输入参数key值';
                return false;
            }
            $params = [];
            foreach ($data['params'] as $item){
                $params[$item['val']] = '';
            }
        }else {
            $params = [];
        }
        
        $data['params'] = json_encode($params);
        $data['signature'] = Service::where('id',$data['sid'])->value('signature');

        $result=$this->save($data);
        return $result;
    }

    /**编辑模板
     * @param $data
     * @return false|int
     */
    public function updateTemplate($data){

        $validate = new \app\common\validate\Template();
        $result = $validate->check($data);
        if (!$result) {
            $this->error = $validate->getError();
            return false;
        }

        if (count($data['params'])==0){
            $this->error = '请输入参数key值';
            return false;
        }

        $params = [];
        foreach ($data['params'] as $item){
            $params[$item['val']] = '';
        }
        $data['params'] = json_encode($params);
        $data['signature'] = Service::where('id',$data['sid'])->value('signature');

        $result=$this->isUpdate(true)->save($data);
        return $result;
    }

}