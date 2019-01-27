<?php
//http server的demo
$http = new Swoole\Http\Server('0.0.0.0',9527);

$http->set([
    'enable_static_handler'=>true,
    'document_root'=>'/var/www/html/tp5_swoole/public/static',
    'worker_num'=>2
]);

$http->on('WorkerStart',function ($serv,$worker_id) {
    require __DIR__ . '/../thinkphp/base.php';
});

$http->on('request',function ($request,$response) use ($http) {
   /* Container::get('app')->run()->send();*/

   /*$_SERVER = [];*/
   if(isset($request->header)) {
        foreach ($request->header as $k=>$v) {
            $_SERVER[strtoupper($k)] = $v;
        }
   }

   /*if(!empty($_GET)) {
       unset($_GET);
   }*/


   $_GET = [];
    if(isset($request->get)) {
        foreach ($request->get as $k=>$v) {
            $_GET[$k] = $v;
        }
    }

    $_POST = [];
    if(isset($request->post)) {
        foreach ($request->post as $k=>$v) {
            $_POST[$k] = $v;
        }
    }


    ob_start();
    try {
        think\Container::get('app')->run()->send();

    } catch (\Exception $e) {
        //todo

    }

   /* think\Container::get('app')->run()->send();*/

    $res = ob_get_contents();

    ob_end_clean();

    $response->end($res);

    /*$http->close();*/

   /* Container::get('app')->run()->send();*/

    /*print_r($request->get);*/
    //request 设置cookie
   /* $request->cookie('zhang','1234',time()+1000);*/

    //response 设置cookie
   /* $response->cookie('zhangjun','hello world',time()+3600);*/
    /*$response->end("参数:".json_encode(($request->get))."<h1>HttpServer #".rand(1111,9999)."</h1>");*/
});

$http->start();