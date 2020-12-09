<?php

namespace App\Controller;

use Client\amqp\AmqpProtocol;
use Client\AmqpClient;
use Lib\protocol\ProtocolPacket;
use Lib\queues\rabbitMq\LazyRabbitMqConnectionProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PushController
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function handle(Request $request)
    {
        $packet = new ProtocolPacket(
            'pushPacket',
            [
                'param1' => "asdssdf",
                'param2' => "asdssdf",
                'param3' => "asdssdf",
            ],
            [
                'scope' => 'scope'
            ],
            'requestUuid'
        );

        $connection = new LazyRabbitMqConnectionProvider(
            'localhost',
            5672,
            'guest',
            'guest',
            '/'
        );
        $client = new AmqpClient($connection, 'test', 300);
        $client->pushPacket($packet);

        return new Response('pushed!');
    }
}