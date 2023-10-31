<?php
/**
 * Created by dh2y.
 * Blog: http://blog.csdn.net/sinat_22878395
 * Date: 2019/3/5 10:16
 * For: 短信控制器
 */

namespace app\admin\controller;

use app\common\controller\BaseAdmin;
use app\common\model\BaseModel;
use app\common\model\Phone;
use cache\Redis;
use sms\SmsManager;
use think\Db;
use think\exception\HttpException;
use think\facade\Config;
use think\helper\Str;


class Sms extends BaseAdmin
{
    /**
     * 群发对象列表
     */
    public function index(){
        if (request()->isAjax()){
            $cond['uid'] = ['eq',$this->uid];
            $list = $this->search('phone',true,$cond);
            return $list;
        }else{
            return $this->fetch();
        }
    }


    /**
     * 手机号添加
     */
    public function add(){
        if (request()->isAjax()){
            if (request()->isPost()){
                ini_set('memory_limit','256M');
                $file = request()->file('file');
                $path = 'upload';

                // 移动到框架应用根目录/public/uploads/ 目录下
                $name = date('Y-m-d') . '/' . md5(time() . Str::random(4));
                $info = $file->validate(['ext' => 'xlsx,xls,csv'])->move($path, $name);
                if ($info) {
                    $url = $path . '/' . $info->getSaveName();
                    $data = \Excel::import_excel('./'.$url);
                    $model = new \app\common\model\Phone();
                    $total = $model->insertCache($data,$this->uid);
                    return [
                        'status'=>true,
                        'message'=>'开始导入中....总计：'.$total.'条',
                        'data' => $total
                    ];
                } else {
                    return ['status' => false, 'message' => $file->getError()];
                }
            }else{
                $total = request()->get('total');
                $have = request()->get('have');
                $model = new \app\common\model\Phone();
                $config = Config::get('redis.');
                $data = Redis::getInstance($config)->lPop('phoneCache');

                if (!$data){
                    return ['status'=>true,'message'=>'已经导入了：100%','data'=>$total,'have'=>$total+1];
                }

                $data = json_decode($data,true);
                if($model->insertBatch($data)){
                    $have = (count($data)+$have);
                    $rate = number_format($have/$total*100, 2);
                    return ['status'=>true,'message'=>'正在导入中：'.$rate.'%','data'=>$total,'have'=>$have];
                }else{
                    return ['status'=>false,'message'=>$model->getError()];
                }
            }
        }else{
            return $this->fetch();
        }
    }

    /**
     * 手机号删除
     */
    public function remove(){
        $ids = request()->post('ids');
        if(request()->isAjax()){
            $result = Db::name('phone')->where('uid',$this->uid)->where('id','in',$ids)->delete();
            if($result){
                return ['status'=>true,'message'=>'删除成功!'];
            }else{
                return ['status'=>false,'message'=>'删除失败!'];
            }
        }else{
            throw new HttpException(502,'请求不合法');
        }
    }

    /**
     * 一键删除
     * @return array
     */
    public function bath_remove(){
        if(request()->isAjax()){
            $result =  Db::name('phone')->where('uid',$this->uid)->delete();
            if($result){
                return ['status'=>true,'message'=>'一键删除成功!'];
            }else{
                return ['status'=>false,'message'=>'一键删除失败!'];
            }
        }else{
            throw new HttpException(502,'请求不合法');
        }
    }


    /**
     * 短信群发
     * @return array
     */
    public function send(){
        if (request()->isAjax()){
            if (request()->isPost()){
                $tid = request()->post('template_id');
                $tag = request()->post('tag');
                $phones = request()->post('phones');
                if (!$tid) {
                    return ['status'=>false,'message'=>'请选择发送短信模板或添加'];
                }
                if (!$tag && !$phones) {
                    return ['status'=>false,'message'=>'请选择发送群组或添加发送手机号'];
                }

                Config::set('paginate.list_rows',200);

                $cond = ['tag'=>['=',$tag],'uid'=>['=',$this->uid]];
                $list =  $tag?$this->search('phone',false,$cond):['lists'=>[]];

                $template = Db::name('template')->where('id',$tid)->where('uid','in',[0,$this->uid])->find();
                $service =   Db::name('service')->where('uid','in',[0,$this->uid])->where('id',$template['sid'])->find();
                $send = SmsManager::getInstance($service['class_name']);
                $send->setConfig($service,$template);
                
                //计算总条要发的短信数量
                $phones = trim($phones);
                $phones_count = $phones!=''?count(explode(',', $phones)):0;
                $total = count($list['lists'])+$phones_count;
                $have_num =  Db::name('admin')->where('id',$this->uid)->value('num');
                if($total>$have_num){
                     return ['status'=>false,'message'=>"剩余短信条数不足，只够发送{$have_num}条"];
                }
                
                //开始发送短信
                $num = 0;
                foreach ($list['lists'] as $item){
                    $res = $send->sendSms($item['phone'],$this->uid);
                    if ($res) {
                        $num++;
                    }
                }
                if ($phones!='') {
                    $phones = explode(',', $phones);
                    foreach ($phones as $key => $value) {
                        $res = $send->sendSms($value,$this->uid,1);
                        if ($res) {
                            $num++;
                        }
                    }
                }
                if ($num){
                    //减少用户短信条数
                    Db::name('admin')->where('id',$this->uid)->setDec('num',$num);
                    return [
                        'status'=>true,
                        'message'=>'成功发送'.$num.'条短信'
                    ];
                }else{
                    return ['status'=>false,'message'=>$send->getError()];
                }
            }else{
                $tid = request()->get('template_id');
                $data = Db::name('template')->field('message')->where('id',$tid)->find();
                return $data;
            }

        }else{
            $template = Db::name('template')->where('uid','in',[0,$this->uid])->field('id,template_name')->select();
            $tag = Db::name('phone')->where('uid',$this->uid)->distinct(true)->column('tag');
            $this->assign('template',$template);
            $this->assign('tag',$tag);
            return $this->fetch();
        }
    }


    /**
     * 一键去重
     * @return array
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function repet(){
        $sql = 'DELETE  FROM  '.Config::get('database.prefix').'phone WHERE uid='.$this->uid.' and id NOT IN (  SELECT  id  FROM  (SELECT max(b.id) AS id  FROM '.Config::get('database.prefix').'phone  b  GROUP BY b.phone) b);';
        $Model = new BaseModel();
        $res  = $Model->execute($sql);
        if ($res){
            return ['status'=>true, 'message'=>'成功去重',];
        }else{
            return ['status'=>false,'message'=>'没有重复数据'];
        }
    }


    /**
     * 发送记录
     * @return array|false|mixed|\PDOStatement|string|\think\Collection
     */
    public function log(){
        if (request()->isAjax()){
            $cond['uid'] = ['eq',$this->uid];
            $list = $this->search('send_log',true,$cond);
            return $list;
        }else{
            return $this->fetch();
        }
    }

    /**
     * 删除短信日志
     * @return array
     */
    public function del_log(){
        $ids = request()->post('ids');
        if(request()->isAjax()){
            $result =  Db::name('send_log')->where('uid',$this->uid)->where('id','in',$ids)->delete();
            if($result){
                return ['status'=>true,'message'=>'删除成功!'];
            }else{
                return ['status'=>false,'message'=>'删除失败!'];
            }
        }else{
            throw new HttpException(502,'请求不合法');
        }
    }

}