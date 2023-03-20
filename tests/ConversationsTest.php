<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\UserRepository;

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

        // We need this to get a valid IRI
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->firstUser();

        $client->request('POST', '/api/conversations', ['json' => [
            'guest' => '/api/users/' . $user->getId(),
        ]]);

        $this->assertResponseStatusCodeSame(201);
    }
}
