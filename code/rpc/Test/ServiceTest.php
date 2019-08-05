<?php

class ServiceTest
{
    public function __construct()
    {

    }

    protected function get(string $name, int $age, string $a = "")
    {
        return $name.$age;
    }
}

require_once "../src/Service/Service.php";

$service = new \Zwell\rpc\Service\Service();
$service->bind("127.0.0.1:3333", new ServiceTest());
