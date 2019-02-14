<?php

namespace console\controllers;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use console\components\SocketServer;
use yii\console\Controller;

class SocketController extends Controller
{
    public function actionStartSocket($port = 8080)
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new SocketServer()
                )
            ),
            $port
        );
        $server->run();
    }
}