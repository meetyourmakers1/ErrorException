<?php

/**
 *  观察者规范
 */
interface ObserverInterface
{
    public function update(ObserveExceptionHandler $e);
}