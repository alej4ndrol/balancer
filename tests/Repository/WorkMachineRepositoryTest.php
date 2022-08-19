<?php

namespace App\Tests\Repository;

use App\Entity\Process;
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

    public function testFindWorkMachineWithEnoughResources()
    {
        $testWorkMachine1 = (new WorkMachine())->setName('Test1')->setRam(11)->setProcessor(11);
        $testWorkMachine2 = (new WorkMachine())->setName('Test2')->setRam(22)->setProcessor(20);
        $testWorkMachine3 = (new WorkMachine())->setName('Test3')->setRam(33)->setProcessor(30);
        $testProcess1 = (new Process())->setName('Proc1')->setRam(3)->setProcessor(3)->setWorkMachine($testWorkMachine2);
        $testProcess2 = (new Process())->setName('Proc2')->setRam(2)->setProcessor(2)->setWorkMachine($testWorkMachine1);
        $testProcess3 = (new Process())->setName('Proc3')->setRam(4)->setProcessor(4)->setWorkMachine($testWorkMachine1);
        $testProcess4 = (new Process())->setName('Proc4')->setRam(6)->setProcessor(6)->setWorkMachine($testWorkMachine2);
        $testProcess5 = (new Process())->setName('Proc5')->setRam(3)->setProcessor(3)->setWorkMachine($testWorkMachine3);
        $testProcess6 = (new Process())->setName('Proc6')->setRam(5)->setProcessor(5)->setWorkMachine($testWorkMachine3);
        $testProcess7 = (new Process())->setName('Proc7')->setRam(7)->setProcessor(7)->setWorkMachine($testWorkMachine2);

        foreach ([$testWorkMachine2, $testWorkMachine3, $testWorkMachine1] as $workMachine) {
            $this->em->persist($workMachine);
        }
        foreach ([$testProcess1, $testProcess2, $testProcess3, $testProcess4, $testProcess5, $testProcess6, $testProcess7] as $process) {
            $this->em->persist($process);
        }

        $this->em->flush();

        $titles = array_map(
            fn (WorkMachine $workMachine) => $workMachine->getName(),
            $this->workMachineRepository->findWorkMachineWithEnoughResources(5, 5)
        );

        $this->assertEquals(['Test3', 'Test1'], $titles);

    }
}
