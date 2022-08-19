<?php

namespace App\Tests\Service;

use App\Entity\Process;
use App\Entity\WorkMachine;
use App\Exception\WorkMachineNotFoundException;
use App\Model\ProcessListItem;
use App\Model\ProcessListResponse;
use App\Repository\ProcessRepository;
use App\Repository\WorkMachineRepository;
use App\Service\ProcessService;
use App\Tests\AbstractTestCase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

class ProcessServiceTest extends AbstractTestCase
{
    public function testGetProcessesByWorkMachineNotFound(): void
    {
        $processRepository = $this->createMock(ProcessRepository::class);
        $workMachineRepository = $this->createMock(WorkMachineRepository::class);
        $workMachineRepository->expects($this->once())
            ->method('existsById')
            ->with(130)
            ->willReturn(false);

        $this->expectException(WorkMachineNotFoundException::class);

        (new ProcessService($processRepository, $workMachineRepository))->getProcessesByWorkMachine(130);
    }

    public function testGetProcessesByWorkMachine(): void
    {
        $workMachine = new WorkMachine();
        $this->setEntityId($workMachine, 130);
        $processRepository = $this->createMock(ProcessRepository::class);
        $processRepository->expects($this->once())
            ->method('findProcessByWorkMachineId')
            ->with(130)
            ->willReturn([$this->createProcessEntity()]);

        $workMachineRepository = $this->createMock(WorkMachineRepository::class);
        $workMachineRepository->expects($this->once())
            ->method('existsById')
            ->with(130)
            ->willReturn(true);

        $service = new ProcessService($processRepository, $workMachineRepository);
        $expected = new ProcessListResponse([$this->createProcessItemModel()]);

        $this->assertEquals($expected, $service->getProcessesByWorkMachine(130));
    }

    public function testGetProcesses()
    {
        //         $workMachine = $this->createMock(WorkMachine::class);
        //         $workMachine->setName('server test')->setProcessor(77)->setRam(77)->setId(7);

        $workMachine = (new WorkMachine())->setName('server test')->setProcessor(77)->setRam(77);
        $this->setEntityId($workMachine, 7);

        $process = (new Process())->setName('test')->setRam(7)->setProcessor(7)->setWorkMachine($workMachine);
        $this->setEntityId($process, 7);

        $repository = $this->createMock(ProcessRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->with([], ['workMachine' => Criteria::ASC])
            ->willReturn([$process]);

        $mockRepository = $this->createMock(WorkMachineRepository::class);

        $service = new ProcessService($repository, $mockRepository);
        $expected = new ProcessListResponse([(new ProcessListItem())
            ->setId(7)
            ->setName('test')
            ->setRam(7)
            ->setProcessor(7)
            ->setWorkMachine(7),
            ]);
        $this->assertEquals($expected, $service->getProcesses());
    }

    private function createProcessEntity(): Process
    {
        $workMachine = new WorkMachine();
        $this->setEntityId($workMachine, 130);
        $process = (new Process())
            ->setName('Test process')
            ->setProcessor(123)
            ->setRam(123123)
            ->setWorkMachine($workMachine);

        $this->setEntityId($process, 123);

        return $process;
    }

    private function createProcessItemModel(): ProcessListItem
    {
        return (new ProcessListItem())
            ->setId(123)
            ->setName('Test process')
            ->setProcessor(123)
            ->setRam(123123)
            ->setWorkMachine(130);
    }
}
