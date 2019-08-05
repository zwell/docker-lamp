<?php


require_once "../src/Client/Client.php";

$client = new \Zwell\rpc\Client\Client("127.0.0.1:3333");

$res = $client->get("name");

var_dump($res);