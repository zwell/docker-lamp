<?php

namespace Zwell\rpc\Service;

class Service
{
    public $socket;

    public function __construct($tcp)
    {
        $this->socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );

        list($host, $port) = explode(":", $tcp);

        socket_bind($this->socket, $host, $port );

        socket_listen($this->socket);
    }

    /**
     * 绑定类
     *
     * @param $class
     * @throws \ReflectionException
     */
    public function bind($class)
    {
        $rClass = new \ReflectionClass($class);
        $publicMethods = array_column($rClass->getMethods(\ReflectionMethod::IS_PUBLIC), "name");

        while( true ){
            $connection_socket = socket_accept($this->socket);

            try {
                $msg = socket_read($connection_socket, 1024);

                parse_str($msg, $result);

                if (!isset($result['method'], $result['arguments'])) {
                    throw new \Exception("method and arguments is required!");
                }

                $method = $result['method'];

                // 验证方法是否存在
                if (!in_array($method, $publicMethods)) {
                    echo "method not exist!\n";
                    socket_close( $connection_socket );
                    continue;
                }

                // 验证参数个数是否正确
                $arguments = json_decode($result['arguments']);
                $rMethod = new \ReflectionMethod($class, $method);
                $parameters = $rMethod->getParameters();
                $requiredParameterCount = 0;
                foreach ($parameters as $parameter) {
                    $rParamete = new \ReflectionParameter([$class, $method], $parameter->name);
                    if ($rParamete->isOptional() === false) {
                        $requiredParameterCount++;
                    }
                }
                if (count($arguments) < $requiredParameterCount) {
                    throw new \Exception("arguments not match!");
                }

                // 调用方法
                $call_res = call_user_func_array([$class, $result['method']], $arguments);

                // 返回执行结果
                socket_write($connection_socket, $call_res);

            } catch (\Exception $e) {
                echo $e->getMessage()."\n";
            }

            socket_close($connection_socket);
        }

        socket_close($this->socket);
    }
}