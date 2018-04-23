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
            //$url = $request->get['interface']['url'];
            $data = $this->crawlPage($request->get);
            $response->end($data);
        });
        
        $this->http->start();
    
    }
    public function crawlPage($data){
        $data = file_get_contents($data['interface']['url'].$data['like']);
        return json_encode($data);
    } 
}
(new server)->httpRun();
