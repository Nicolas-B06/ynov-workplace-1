<?php
// api/tests/AbstractTest.php
namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

abstract class AbstractTest extends ApiTestCase
{
  private ?string $token = null;

  use RefreshDatabaseTrait;

  public function setUp(): void
  {
    self::bootKernel();
  }

  protected function createClientWithCredentials($token = null): Client
  {
    $token = $token ?: $this->getToken();

    return static::createClient([], ['headers' => ['authorization' => 'Bearer ' . $token]]);
  }

  /**
   * Use other credentials if needed.
   */
  protected function getToken($body = []): string
  {
    if ($this->token) {
      return $this->token;
    }

    $client = static::createClient();
    $client->disableReboot();

    $response = $client->request('POST', '/auth', ['json' => $body ?: [
      'email' => 'test@test.com',
      'password' => 'test',
    ]]);

    $this->assertResponseIsSuccessful();
    $data = $response->toArray();
    $this->token = $data['token'];

    return $data['token'];
  }
}
