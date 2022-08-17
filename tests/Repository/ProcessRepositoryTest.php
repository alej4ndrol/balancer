<?php

namespace App\Tests\Repository;

use App\Entity\Process;
use App\Entity\WorkMachine;
use App\Repository\ProcessRepository;
use App\Tests\AbstractRepositoryTest;

class ProcessRepositoryTest extends AbstractRepositoryTest
{
    private ProcessRepository $processRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->processRepository = $this->getRepositoryForEntity(Process::class);
    }

    public function testFindProcessByWorkMachineId()
    {
        $testWorkMachine = (new WorkMachine())->setName('Test')->setRam(123)->setProcessor(123);
        $this->em->persist($testWorkMachine);

        for ($i = 0; $i < 5; ++$i) {
            $process = $this->createProcess('Test'.$i, $testWorkMachine);
            $this->em->persist($process);
        }

        $this->em->flush();

        $this->assertCount(5, $this->processRepository->findProcessByWorkMachineId($testWorkMachine->getId()));
    }

    private function createProcess(string $title, WorkMachine $testWorkMachine): Process
    {
        return (new Process())
            ->setName($title)
            ->setRam(123)
            ->setProcessor(123)
            ->setWorkMachine($testWorkMachine);
    }
}
