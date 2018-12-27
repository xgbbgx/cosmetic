<?php
return [
    'adminEmail' => 'xgb547757645@126.com',
    'supportEmail' => '547757645@qq.com',
    'user.passwordResetTokenExpire' => 3600,
    
    'base_conf'=> include __DIR__ . '/conf/base_conf.php',//基础配置
    'error_conf'=> include __DIR__ . '/conf/error_conf.php',//错误配置
    'speech_conf'=> include __DIR__ . '/conf/speech_conf.php',//翻译集合
    'classify_conf'=> include __DIR__ . '/conf/classify_conf.php',//翻译集合
    'tag_conf'=> include __DIR__ . '/conf/tag_conf.php',//标签配置
];
