<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Tests\Tools\FixtureTools;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetMeActionTest extends WebTestCase
{
    use FixtureTools; // trait-ы используются внутри класса

    public function test_get_auth_me_action(): void
    {
        $client = static::createClient();

        $user = $this->loadUserFixture(); // $this приобретает функцию из Fixture Tools, потому что он используется внутри класса

        // authorize user
        $client->request(
            'POST', // method
            '/api/auth/token/login', // uri
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'], // header
            json_encode([
              'email' => $user->getEmail(),
              'password' => $user->getPassword(),
            ]) // post-data
        );

        $data = json_decode($client->getResponse()->getContent(), true); // associative array: true

        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $data['token']));

        // act
        $client->request('GET', '/api/users/me');

        // assert authorized user's email is equal to email on /api/users/me route
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($user->getEmail(), $data['email']);
    }
}
