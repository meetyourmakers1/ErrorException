<?php

/**
 *  自定义错误处理
 */
class ErrorHandler
{
    public $errmsg = '';
    public $errfile = '';
    public $errline = '';
    protected $_errorlog = 'C:\PHPerror.log';

    public function __construct($errno,$errmsg,$errfile,$errline)
    {
        $this->errmsg = $errmsg;
        $this->errfile = $errfile;
        $this->errline = $errline;
    }

    //自定义错误处理
    public static function errorHandler($errno,$errmsg,$errfile,$errline)
    {
        $self = new self($errno,$errmsg,$errfile,$errline);
        switch($errno)
        {
            case E_USER_ERROR:
                return $self->fatal();
                break;
            case E_USER_WARNING:
            case E_WARNING:
                return $self->warning();
                break;
            case E_USER_NOTICE:
            case E_NOTICE:
                return $self->notice();
                break;
            default:
                return false;
        }
    }

    //致命错误处理
    public function fatal()
    {
        ob_start();
        debug_print_backtrace();
        $backtrace = ob_get_flush();
        $errmsg = <<<EOF
致命错误:
    错误信息: {$this->errmsg},
    错误文件: {$this->errfile},
    错误行号: {$this->errline},
    追踪信息: {$backtrace}.
EOF;
    error_log($errmsg,1,'3458194688@qq.com');
    exit(1);
    }

    //警告错误处理
    public function warning()
    {
        $errmsg = <<<EOF
警告错误:
    错误信息: {$this->errmsg},
    错误文件: {$this->errfile},
    错误行号: {$this->errline}.
EOF;
        return error_log($errmsg,1,'3458194688@qq.com');
    }

    //注意错误处理
    public function notice()
    {
        $datetime = date('Y-m-d H:i:s',time() );
        $errmsg = <<<EOF
注意错误:
    错误信息: {$this->errmsg},
    错误文件: {$this->errfile},
    错误行号: {$this->errline},
    错误时间: {$datetime}.


EOF;
        return error_log($errmsg,3,$this->_errorlog);
    }

    public function shutdownFunction()
    {
        if(error_get_last())
        {
            echo '<pre>';
            print_r(error_get_last());
            echo '</pre>';
        }
        file_put_contents('C:\error.log',error_get_last());
        die('shutdown function');
    }
}

//自定义错误处理类 测试
register_shutdown_function(array(new ErrorHandler(),'shutdownFunction'));

//error_reporting(-1);
ini_set('display_errors',0);
set_error_handler(array('ErrorHandler','errorHandler'));
echo $test; //注意错误
//settype($test,'ningbo'); //警告错误
//test(); //致命错误
trigger_error('用户触发自定义错误',E_USER_NOTICE);


