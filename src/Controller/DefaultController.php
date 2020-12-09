<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Created by PhpStorm.
 * User: bearzp
 * Date: 17.09.20
 * Time: 17:39
 */
class DefaultController
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        return new Response('Use /push or /post');
    }
}