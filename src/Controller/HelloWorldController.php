<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController
{
    /**
     * @Route("/hello")
     */
    public function __invoke(Request $request)
    {
        $name = $request->get('name');

        return new Response('Hello '.$name.'!');
    }
}