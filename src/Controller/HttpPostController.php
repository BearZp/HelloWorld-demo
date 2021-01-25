<?php

namespace App\Controller;

use Client\AmqpClient;
use Client\HttpClient;
use Lib\protocol\ProtocolPacket;
use Lib\queues\rabbitMq\LazyRabbitMqConnectionProvider;
use Lib\transport\HttpConnectionProvider;
use Lib\types\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpPostController
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function handle(Request $request)
    {
        $packet = new ProtocolPacket(
            'httpPostPacket',
            [
                'startTime' => microtime(true),
            ],
            [
                'scope' => 'scope'
            ],
            (new Uuid(''))->generateRandom()->toString()
        );

        $connection = new HttpConnectionProvider(
            '127.0.0.1',
            4082,
            '',
            '',
            'http',
            '/'
        );
        $client = new HttpClient($connection, 10);
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