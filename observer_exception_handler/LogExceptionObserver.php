<?php

/**
 *  log观察着
 */
class LogExceptionObserver implements ObserverInterface
{
    protected $_errlog = 'C:/observeException.log';

    public function __construct($_errlog = null)
    {
        if(!empty($_errlog))
        {
            $this->_errlog = $_errlog;
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

        error_log($message,3,$this->_errlog);
    }
}