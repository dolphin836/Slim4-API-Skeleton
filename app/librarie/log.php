<?php

namespace Dolphin\Tan\Librarie;

/** 
*  日志
*  
* @category Librarie
* @package  Log
* @author   dolphin.wang <416509859@qq.com>
* @license  MIT https://mit-license.org 
* @link     https://github.com/dolphin836/Slim-Skeleton-MVC
* @since    2017-05-18
**/
class Log
{
    protected $resource;
    protected $settings;
    /**
    * 初始化设置
    *
    * @return void
    **/
    public function __construct()
    {
        $this->settings = array(
                      'path' => LOGSPATH,
               'name_format' => 'Y-m-d',
            'message_format' => '%label% - %date% - %message%'
        );
    }
    /**
    * 写入日志
    *
    * @param string/array $msg   信息
    * @param int          $level 类型
    *
    * @return void
    **/
    public function write($msg, $level = 0)
    {
        switch ($level) {
        case 1:
            $label = 'FATAL';
            break;
        case 2:
            $label = 'ERROR';
            break;
        case 3:
            $label = 'WARN';
            break;
        case 4:
            $label = 'DEBUG';
            break;
        default:
            $label = 'INFO';
            break;
        }

        if (is_array($msg)) {
            $msg = json_encode($msg);
        }

        $message = str_replace(array('%label%', '%date%', '%message%'), array($label, date('Y-m-d H:i:s'), $msg), $this->settings['message_format']);

        if (!$this->resource) {
            $filename       = date($this->settings['name_format'], time()) . '.log';
            $this->resource = fopen($this->settings['path'] . $filename, 'a');
        }

        fwrite($this->resource, $message . PHP_EOL);
    }
}
