<?php

namespace Zwell\rpc\Client;

class Client
{
    public $socket;

    public function __construct($tcp)
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        list($host, $port) = explode(":", $tcp);

        socket_connect($this->socket, $host, $port);
    }


    public function __call($name, $arguments)
    {
        $msg = "method=$name&arguments=".json_encode($arguments);
        socket_write($this->socket, $msg);

        return socket_read($this->socket, 1024);
    }

    public function __destruct()
    {
        socket_close($this->socket);
    }
}