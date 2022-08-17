<?php

namespace App\Tests\Controller;

use App\Entity\WorkMachine;
use App\Tests\AbstractControllerTest;

class WorkMachineControllerTest extends AbstractControllerTest
{
    public function testGetWorkMachines()
    {
        $this->em->persist((new WorkMachine())->setName('Test')->setProcessor(123)->setRam(123));
        $this->em->flush();

        $this->client->request('GET', '/api/v1/workmachine/get');
        $responseContent = json_decode($this->client->getResponse()->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'name', 'processor', 'ram'],
                        'properties' => [
                            'name' => ['type' => 'string'],
                            'processor' => ['type' => 'integer'],
                            'ram' => ['type' => 'integer'],
                            'id' => ['type' => 'integer'],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
