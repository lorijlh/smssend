<?php

// admin应用行为扩展定义文件
return [
    // 应用初始化
    'app_init'     => [],
    // 应用开始
    'app_begin'    => [
        'app\\common\\behavior\\ShowBehavior'
    ],
    // 模块初始化
    'module_init'  => [
        'app\\common\\behavior\\AuthBehavior'
    ],
    // 操作开始执行
    'action_begin' => [
        'app\\common\\behavior\\LoginBehavior',
    ],
    // 视图内容过滤
    'view_filter'  => [],
    // 日志写入
    'log_write'    => [],
    // 应用结束
    'app_end'      => [],
];
