<?php

/**
 *  自定义异常处理
 */
class ExceptionHandler
{
    protected $_exceptionmsg;
    protected $_exceptionlog = 'C:/exception.log';

    public function __construct(Exception $e)
    {
        $this->_exceptionmsg = '出现异常:'.PHP_EOL;
        $this->_exceptionmsg .= '    异常信息:'.$e->getMessage().PHP_EOL;
        $this->_exceptionmsg .= '    追踪信息:'.$e->getTraceAsString().PHP_EOL;
        $this->_exceptionmsg .= '    文件名:'.$e->getFile().PHP_EOL;
        $this->_exceptionmsg .= '    行号:'.$e->getLine().PHP_EOL;
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

    //自定义异常处理
    public static function exceptionHandler(Exception $e)
    {
        $self = new self($e);
        $self->log();
        echo $self;
    }

    public function log()
    {
        error_log($this->_exceptionmsg,3,$this->_exceptionlog);
    }
}

//自定义异常处理类 测试
set_exception_handler(array('ExceptionHandler','exceptionHandler'));
//restore_exception_handler();
try
{
    throw new Exception('出现异常'.PHP_EOL);
}
catch(Exception $e)
{
    echo $e->getMessage();
}
throw new Exception('出现异常'.PHP_EOL);