<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloWorldControllerTest extends WebTestCase
{
    public function test_request_responded_successful(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/hello', ['name' => 'Ruslan']);
    
        $this->assertResponseIsSuccessful();

        $jsonResult = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($jsonResult['status'], 'ok');
        $this->assertEquals($jsonResult['message'], 'Hello Ruslan!');
    }
}
