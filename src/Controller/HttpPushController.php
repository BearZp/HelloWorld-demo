<?php

namespace App\Controller;

use Client\HttpClient;
use Lib\protocol\ProtocolPacket;
use Lib\transport\HttpConnectionProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpPushController
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function handle(Request $request)
    {
        $packet = new ProtocolPacket(
            'httpPushPacket',
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

        $connection = new HttpConnectionProvider(
            '127.0.0.1',
            4082,
            '',
            '',
            'http',
            '/'
        );
        $client = new HttpClient($connection, 10);
        $client->pushPacket($packet);

        return new Response('pushed!');
    }
}