<?php

namespace App\Tests\Controller;

use App\Entity\Process;
use App\Entity\WorkMachine;
use App\Tests\AbstractControllerTest;

class ProcessControllerTest extends AbstractControllerTest
{
    public function testProcessByWorkMachine()
    {
        $workMahchineId = $this->createWorkMachine();
        $this->client->request('GET', '/api/v1/workmachine/'.$workMahchineId.'/processes');
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
                        'required' => ['id', 'name', 'ram', 'processor', 'workMachine'],
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'name' => ['type' => 'string'],
                            'ram' => ['type' => 'integer'],
                            'processor' => ['type' => 'integer'],
                            'workMachine' => ['type' => 'integer'],
                        ],
                    ],
                ],
            ],
        ]);
    }

    private function createWorkMachine(): int
    {
        $workMachine = (new WorkMachine())->setName('test')->setRam(123)->setProcessor(123);
        $this->em->persist($workMachine);

        $process = (new Process())
            ->setName('Test')
            ->setRam(123)
            ->setProcessor(123)
            ->setWorkMachine($workMachine);

        $this->em->flush();

        return $workMachine->getId();
    }

//    public function testGetProcesses()
//    {
//        $this->em->persist((new Process())->setName('Test')->s);
//
//        $this->client->request('GET', '/api/v1/process/get');
//        $responseContent = $this->client->getResponse()->getContent();
//
//        $this->assertResponseIsSuccessful();
//    }
}
