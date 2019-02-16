<?php

/**
 *  email观察者
 */
class EmailExceptionObserver implements ObserverInterface
{
    protected $_email = '3458194688@qq.com';

    public function __construct($email = null)
    {
        if(filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $this->_email = $email;
        }
    }

    public function update(ObserveExceptionHandler $e)
    {
        $message = '出现异常:'.PHP_EOL;
        $message .= '    异常信息:'.$e->getMessage().PHP_EOL;
        $message .= '    追踪信息:'.$e->getTraceAsString().PHP_EOL;
        $message .= '    文件名:'.$e->getFile().PHP_EOL;
        $message .= '    行号:'.$e->getLine().PHP_EOL;
        $message .= '    时间:'.date('Y-m-d H:i:s').PHP_EOL;
        $message .= PHP_EOL;

        error_log($message,1,$this->_email);
    }
}