<?php

class SQLException extends Exception
{
    //重定义构造器使第一个参数 message 变为必须被指定的属性
    public function __construct($message, $code = 0)
    {
        //可以在这里定义一些自己的代码
        //建议同时调用 parent::construct()来检查所有的变量是否已被赋值
        parent::__construct($message, $code);
    }
}
