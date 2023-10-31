<?php

use think\exception\HttpResponseException;

/**
 * json 数据输出
 * @param $data          data数据
 * @param int $code      code
 * @param string $msg    提示信息
 * @param array $param   额外参数
 * @param $httpCode      http状态码
 */
function show($data, $code = 1, $msg = '', $param = [], $httpCode = 200)
{
    $json = [
        'code' => $code,
        'msg' => $msg,
        'data' => $data,
    ];
    if ($param) {
        $json = array_merge($json, $param);
    }
    $response = json($json, $httpCode);
    throw new HttpResponseException($response);
}