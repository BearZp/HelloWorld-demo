<?php

namespace App\Controller;

use Client\AmqpClient;
use Lib\protocol\ProtocolPacket;
use Lib\queues\rabbitMq\LazyRabbitMqConnectionProvider;
use Lib\types\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function handle(Request $request)
    {
        $packet = new ProtocolPacket(
            'postPacket',
            [
                'startTime' => microtime(true),
            ],
            [
                'scope' => 'scope'
            ],
            (new Uuid(''))->generateRandom()->toString()
        );

        $connection = new LazyRabbitMqConnectionProvider(
            'localhost',
            5672,
            'guest',
            'guest',
            '/'
        );
        $client = new AmqpClient($connection, 'test', 300);
        $answer = $client->sendPacket($packet);

        return new Response(json_encode([
            'controller' => $answer->getData()['controller'],
            'startTime' => $answer->getData()['startTime'],
            'time_____' => $answer->getData()['time'],
            'endTime__' => microtime(true),
            'requestId' => $answer->getRequestId()
        ]));
    }
}