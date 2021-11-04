<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class WebhooksTest extends ApiTestCase
{
    public function testPush(): void
    {
        $data = json_decode(file_get_contents(__DIR__.'/Resources/push.json'), true);

        static::createClient()->request('POST', '/api/webhooks', ['json' => $data]);
        $this->assertResponseStatusCodeSame(Response::HTTP_ACCEPTED);
    }
}
