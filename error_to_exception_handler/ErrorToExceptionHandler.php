<?php

/**
 *  自定义处理错误(exception)
 */
class ErrorToExceptionHandler extends Exception
{
    protected $_exceptionmsg;
    protected $_exceptionlog = 'C:/phpexception.log';

    public function __construct($errmsg)
    {
        parent::__construct();

        $this->_exceptionmsg = '出现异常:'.PHP_EOL;
        $this->_exceptionmsg .= '    异常信息:'.$this->getMessage().PHP_EOL;
        $this->_exceptionmsg .= '    追踪信息:'.$this->getTraceAsString().PHP_EOL;
        $this->_exceptionmsg .= '    文件名:'.$this->getFile().PHP_EOL;
        $this->_exceptionmsg .= '    行号:'.$this->getLine().PHP_EOL;
        $this->_exceptionmsg .= '    时间:'.date('Y-m-d H:i:s').PHP_EOL;
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

    //自定义处理错误
    public static function exceptionToErrorHandle($errmsg)
    {
        $self = new self($errmsg);
        $self->log();
        echo $self;
        throw new self($errmsg);
    }

    public function log()
    {
        error_log($this->_exceptionmsg,3,$this->_exceptionlog);
    }
}

error_reporting(-1);
set_error_handler(array('ErrorToExceptionHandler','exceptionToErrorHandle'),E_NOTICE|E_WARNING|E_USER_NOTICE|E_USER_WARNING);
try
{
    $test;
    settype($test,'ningbo');
    test();
    trigger_error('出现错误'.PHP_EOL,E_USER_NOTICE);
}
catch(Exception $e)
{
    echo $e->getMessage();
}