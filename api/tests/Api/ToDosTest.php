<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\ToDo;

class ToDoTest extends ApiTestCase
{
    public function testCreateToDo()
    {
        $response = static::createClient()->request('POST', '/to_dos', ['json' => [
            'name' => 'Premier todo',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Greeting',
            '@type' => 'ToDo',
            'name' => 'Premier todo',
        ]);
    }
}

