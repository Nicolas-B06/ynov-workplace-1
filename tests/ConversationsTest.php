<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ConversationsTest extends ApiTestCase
{
    public function testPostConversation()
    {
        $client = static::createClient();
        $client->disableReboot();
        $client->request('POST', '/api/users', ['json' => [
            'nickname' => 'bogossDu06',
            'email' => 'machin@domain.com',
            'plainPassword' => 'toto1234',
        ]]);

        $response = $client->request('POST', '/auth', ['json' => [
            'email' => 'machin@domain.com',
            'password' => 'toto1234',
        ]]);
        $this->assertResponseIsSuccessful();

        $data = $response->toArray();
        $token = $data['token'];
        $client->setDefaultOptions(['headers' => ['authorization' => 'Bearer ' . $token]]);

        $client->request('POST', '/api/conversations', ['json' => [
            'guest' => '/api/users/1',
        ]]);

        $this->assertResponseStatusCodeSame(201);
    }
}
