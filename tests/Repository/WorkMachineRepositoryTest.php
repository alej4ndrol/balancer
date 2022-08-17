<?php

namespace App\Tests\Repository;

use App\Entity\WorkMachine;
use App\Repository\WorkMachineRepository;
use App\Tests\AbstractRepositoryTest;

class WorkMachineRepositoryTest extends AbstractRepositoryTest
{
    private WorkMachineRepository $workMachineRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->workMachineRepository = $this->getRepositoryForEntity(WorkMachine::class);
    }

    public function testFindAllSortedByName()
    {
        $testWorkMachine1 = (new WorkMachine())->setName('Test1')->setRam(1231)->setProcessor(123);
        $testWorkMachine2 = (new WorkMachine())->setName('Test2')->setRam(1232)->setProcessor(123);
        $testWorkMachine3 = (new WorkMachine())->setName('Test3')->setRam(1233)->setProcessor(123);

        foreach ([$testWorkMachine2, $testWorkMachine3, $testWorkMachine1] as $workMachine) {
            $this->em->persist($workMachine);
        }

        $this->em->flush();

        $titles = array_map(
            fn (WorkMachine $workMachine) => $workMachine->getName(),
            $this->workMachineRepository->findAllSortedByName()
        );

        $this->assertEquals(['Test1', 'Test2', 'Test3'], $titles);
    }
}
