<?php
namespace console\components;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use common\models\Chat;

class SocketServer implements MessageComponentInterface
{
    protected $clients;


    public function __construct()
    {
        //$this->clients = new \SplObjectStorage;
        echo "Server started";
    }

    public function onOpen(ConnectionInterface $conn)
    {
        //$this->clients->attach($conn);
        $urlString = $conn->httpRequest->getUri()->getQuery();
        $channel = explode("=", $urlString)[1];

        $this->clients[$channel][$conn->resourceId] = $conn;

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);
        $chat_id = $data['chat_channel'];
        $user_id = $data['user_id'];


        //var_dump($json['message']);

        echo "{$from->resourceId}: {$msg}\n";
        (new Chat($data))->save();

        foreach ($this->clients[$chat_id] as $client){
            $client->send($data['message']);
        }

    }

    public function onClose(ConnectionInterface $conn)
    {
        //$this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}