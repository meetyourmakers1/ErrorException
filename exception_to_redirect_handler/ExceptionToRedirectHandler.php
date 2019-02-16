<?php

/**
 *  自定义异常处理(重定向)
 */
class ExceptionToRedirectHandler
{
    protected $_exceptionmsg;
    public $redirect = '404.html';
    protected $_exceptionlog = 'C:/phpexception.log';

    public function __construct(Exception $e)
    {
        $this->_exceptionmsg = '出现异常:'.PHP_EOL;
        $this->_exceptionmsg .= '    异常信息:'.$e->getMessage().PHP_EOL;
        $this->_exceptionmsg .= '    追踪信息:'.$e->getTraceAsString().PHP_EOL;
        $this->_exceptionmsg .= '    文件名:'.$e->getFile().PHP_EOL;
        $this->_exceptionmsg .= '    行号:'.$e->getLine().PHP_EOL;
        $this->_exceptionmsg .= '    时间:'.date('Y-m-d H:i:s',time()).PHP_EOL;
        $this->_exceptionmsg .= PHP_EOL;
    }

    public function __toString()
    {
        /*$_exceptionmsg = <<<EOF
出现异常:
    联系管理员:<a href="mailto:3458194688@qq.com">3458194688@qq.com</a>
EOF;*/
        $_exceptionmsg = $this->_exceptionmsg;
        return $_exceptionmsg;
    }

    //自定义异常处理
    public static function errorToRedirectHandler(Exception $e)
    {
        $self = new self($e);
        $self->log();
        while(@ob_end_clean());
        header('HTTP/1.1 307 Temporary Redirect');
        header('Cache-Control:no-cache,must-revalidate');
        header('Location:'.$self->redirect);
        exit(1);
    }

    public function log()
    {
        error_log($this->_exceptionmsg,3,$this->_exceptionlog);
    }
}

set_exception_handler(array('ExceptionToRedirectHandler','errorToRedirectHandler'));

throw new Exception('出现异常');