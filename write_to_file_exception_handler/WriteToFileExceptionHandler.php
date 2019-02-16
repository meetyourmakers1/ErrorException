<?php

/**
 *  文件写入异常处理
 */
class WriteToFileExceptionHandler extends Exception
{
    protected $message = null;
    protected $code = '';
    protected $_exceptionmsg;

    public function __construct($message,$code)
    {
        parent::__construct($message,$code);
        $this->message = $message;
        $this->code = $code;
        $this->_exceptionmsg = '出现异常:'.PHP_EOL;
        $this->_exceptionmsg .= '    异常信息:'.$e->getMessage().PHP_EOL;
        $this->_exceptionmsg .= '    追踪信息:'.$e->getTraceAsString().PHP_EOL;
        $this->_exceptionmsg .= '    文件名:'.$e->getFile().PHP_EOL;
        $this->_exceptionmsg .= '    行号:'.$e->getLine().PHP_EOL;
        $this->_exceptionmsg .= '    时间:'.date('Y-m-d H:i:s',time()).PHP_EOL;
        $this->_exceptionmsg .= PHP_EOL;

        switch($this->code)
        {
            case 0:
                $this->message .= '文件不为空';
                break;
            case 1:
                $this->message .= '文件不存在';
                break;
            case 2:
                $this->message .= '文件不正确';
                break;
            case 3:
                $this->message .= '文件不可写';
                break;
            case 4:
                $this->message .= '文件非法操作';
                break;
            case 5:
                $this->message .= '文件写入失败';
                break;
            case 6:
                $this->message .= '文件关闭失败';
                break;
            default:
                $this->message .= '非法操作';
                break;
        }
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
}

//文件写入处理
class WriteToFile{

    private $_message = '';
    private $_file = null;

    public function __construct($filename = null,$mode = 'w')
    {
        $this->_message = "文件名: {$filename},操作模式: {$mode}<br/>";
        if(empty($filename)) throw new WriteToFileExceptionHandler($this->_message,0);
        if(!file_exists($filename)) throw new WriteToFileExceptionHandler($this->_message,1);
        if(!is_file($filename)) throw new WriteToFileExceptionHandler($this->_message,2);
        if(!is_writable($filename)) throw new WriteToFileExceptionHandler($this->_message,3);
        if(!in_array($mode,array('w','w+','a','a+'))) throw new WriteToFileExceptionHandler($this->_message,4);
        $this->_file = fopen($filename,$mode);
    }

    public function write($data)
    {
        if(@!fwrite($this->_file,$data.PHP_EOL)) throw new WriteToFileExceptionHandler($this->_message,5);
    }

    public function close()
    {
        if($this->_file)
        {
            if(@!fclose($this->_file)) throw new WriteToFileExceptionHandler($this->_message,6);
            $this->_file = null;
        }
    }

    public function __destruct()
    {
        $this->close();
    }
}

//文件写入异常处理类 测试
try{
    //$file = new WriteToFile('test.txt','w');
    $file = new WriteToFile();
    $file->write('测试数据');
    $file->close();
    echo '数据写入文件成功<br/>';
}
catch(WriteToFileExceptionHandler $e)
{
    echo '出现异常:<br/>'.$e->getMessage().'<br/>异常详情:<br/>'.$e;
}