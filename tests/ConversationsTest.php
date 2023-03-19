<?php

namespace App\Tests;

use App\Tests\AbstractTest;

class ConversationsTest extends AbstractTest
{
    public function testPostConversation()
    {
        static::createClient()->request('POST', '/api/users', ['json' => [
            'nickname' => 'bogossDu06',
            'email' => 'machin@domain.com',
            'plainPassword' => 'toto1234',
        ]]);

        $this->assertResponseIsSuccessful();

        $token = $this->getToken([
            'email' => 'machin@domain.com',
            'password' => 'toto1234',
        ]);

        static::createClientWithCredentials($token)->request('POST', '/api/conversations', ['json' => [
            'guest' => '/api/users/1',
        ]]);

        $this->assertEquals('test', $token);
    }
}
