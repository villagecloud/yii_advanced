<?php
namespace console\components;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class SocketServer implements MessageComponentInterface
{
    protected $clients;

    private $conversationId;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->conversationId = null;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        //var_dump($conn->url);exit;
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
/*        $data = json_decode($msg, true);
        if (is_null($data))
        {
            echo "invalid data\n";
            return $from->close();
        }
        echo $from->resourceId."\n";*/
        //var_dump($from);exit;
        //$request = $from->httpRequest;
        $json = json_decode($msg, true);
        $msg = $json['message'];
        $id = $json['task_id'];
        $room_id = $json['room_id'];


        //var_dump($json['message']);

        echo "{$from->resourceId}: {$msg}\n";
        foreach ($this->clients as $client){
            $client->send($msg);
            //$client->send($id);
        }

    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    public function onTest($id){
        var_dump($id);
    }

}