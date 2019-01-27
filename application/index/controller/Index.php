<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        var_dump($_GET);
        return 'hello world';
    }

    public function test ()
    {
        return 1234;
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
