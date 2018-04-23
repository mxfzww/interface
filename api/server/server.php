#!/usr/bin/php
<?php
class server{
    
    protected $http;//swoole变量
    
    protected $config;//swoole信息
    
    public function __construct() {
        $this->config = include '../config/config.php';
        $this->http = new swoole_http_server($this->config['swoole']['host'], $this->config['swoole']['port']);
    }
    
    public function httpRun(){
        
        $this->http->on('request', function (swoole_http_request $request, swoole_http_response $response) {
            $response->end(json_encode($request->get));
        });
        
        $this->http->start();
    
    }
    
}
(new server)->httpRun();
