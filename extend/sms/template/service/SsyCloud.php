<?php
/**
 * Created by dh2y.
 * Date: 2018/7/31 12:11
 * for:
 */

namespace sms\template\service;


/** .-----------------------------配置说明---------------------------------
 * |    只需要配置 account(阿里大鱼accessKeyId )和  password(阿里大鱼accessKeySecret)
 * |------------------------------配置方法---------------------------------
 * |   'SMS_SDK' => array(
 * |        'class' => 'Aliyun',
 * |        'account' => 'demo',
 * |        'password'=> '12345',
 * |        'signature' => 'XXXX'   //签名
 * |   )
 * |   new Sms(config('SMS_SDK'))
 * '-------------------------------------------------------------------*/

class SsyCloud extends TemplateInterface
{

    protected $baseUrl = 'http://testwebsite.ssycloud.com/api/v1/sms/sendsms';

    /**
     * 发送短信
     * @param $phone
     * @param string $code 短信模板Code
     * @param array $param ["code" => "12345","product" => "ddd"];
     * @return mixed
     * http://testwebsite.ssycloud.com/api/v1/sms/sendsms?account=***&sign=***&datetime=***
     */
    public function sendSms($phone, $code, $codeId)
    {
        $curTime = time();

        // 按照协议组织 post 包体
        $data = new \stdClass();
        $signs= $this->sign($this->password,$curTime, $this->account);

        $wholeUrl = $this->baseUrl . "?account=" . $this->account . "&sign=" . $signs."&datetime=".$curTime;

        $data->content = $code;
        $data->numbers = $phone;
        $data->codeId = '10001';

        $result =  $this->sendCurlPost($wholeUrl, $data);
        $rsp = json_decode($result);

        var_dump($this->password);
        var_dump( $this->account);
        var_dump($curTime);
        var_dump($signs);
        var_dump($rsp);
        die();
        if($rsp->status==0){
            return true;
        }else{
            $this->setError($rsp->errmsg);
            return false;
        }
    }

    /**
     * 查询发送短信内容
     * @param $phone
     * @return mixed
     */
    public function querySend($phone)
    {
        // TODO: Implement querySend() method.
    }

    /**
     * 获取短信请求地址
     * @param $api
     * @return mixed
     */
    public function getRequestUrl($api)
    {
        // TODO: Implement getRequestUrl() method.
    }

    /**
     * 生成签名
     * @param string $appkey        sdkappid对应的appkey
     * @param string $curTime       当前时间
     * @param array  $phoneNumber   手机号码
     * @return string  签名结果
     */
    public function sign($appkey,$curTime, $phoneNumber){
        return md5($phoneNumber.$appkey.$curTime);
    }

    /**
     * 发送请求
     * @param string $url      请求地址
     * @param array  $dataObj  请求内容
     * @return string 应答json字符串
     */
    public function sendCurlPost($url, $dataObj){
        $jsondata = json_encode($dataObj);
        var_dump($jsondata);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsondata);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($jsondata))
        );
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $ret = curl_exec($curl);
        var_dump($ret);
        if (false == $ret) {
            // curl_exec failed
            $result = "{ \"result\":" . -2 . ",\"errmsg\":\"" . curl_error($curl) . "\"}";
        } else {
            $rsp = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (200 != $rsp) {
                $result = "{ \"result\":" . -1 . ",\"errmsg\":\"". $rsp
                    . " " . curl_error($curl) ."\"}";
            } else {
                $result = $ret;
            }
        }

        curl_close($curl);

        return $result;
    }


}