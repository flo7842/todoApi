<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class TaskTest extends ApiTestCase
{
    public function testGetTasks(): void
    {
        static::createClient()->request('GET', 'api/tasks');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            "@context" => "/api/contexts/Task",
            '@id' => '/api/tasks',
            '@type' => 'hydra:Collection',
        ]);
    }

    public function testGetFilterTasksStatus(): void
    {
        static::createClient()->request('GET', 'api/tasks?status=false');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            "hydra:totalItems"=> 6,
            "hydra:view"=> [
                "@id"=> "/api/tasks?status=false",
                "@type"=> "hydra:PartialCollectionView"
            ],
        ],
    );
    }

}


