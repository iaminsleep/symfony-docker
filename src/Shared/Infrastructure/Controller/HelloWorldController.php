<?php

namespace App\Shared\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController
{
    /**
     * @Route("/hello")
     */
    public function __invoke(Request $request): JsonResponse
    {
        $name = $request->get('name');

        return new JsonResponse(
            [
                'status' => 'ok',
                'message' => 'Hello '.$name.'!',
                'ssl' => extension_loaded('openssl'),
            ]
        );
    }
}
