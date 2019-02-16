<?php

require_once 'ObserverInterface.php';
require_once 'LogExceptionObserver.php';
require_once 'EmailExceptionObserver.php';

/**
 *  观察异常处理(观察者模式)
 */
class ObserveExceptionHandler extends Exception
{
    public static $observers = array();

    public static function addObserver(ObserverInterface $observer)
    {
        self::$observers[] = $observer;
    }

    public function __construct($message = "", $code = 0)
    {
        parent::__construct($message, $code);
        $this->noticeObserver();
    }

    public function noticeObserver()
    {
        foreach(self::$observers as $observer)
        {
            $observer->update($this);
        }
    }
}

//观察异常处理类 测试
ObserveExceptionHandler::addObserver(new LogExceptionObserver());
ObserveExceptionHandler::addObserver(new EmailExceptionObserver());

try
{
    throw new ObserveExceptionHandler('出现异常');
}
catch(ObserveExceptionHandler $e)
{
    echo $e->getMessage().'<br/>';
    echo $e;
}