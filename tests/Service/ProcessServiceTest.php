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
use Doctrine\Common\Collections\Criteria;
use PHPUnit\Framework\TestCase;

class ProcessServiceTest extends TestCase
{
    public function testGetProcessesByWorkMachineNotFound(): void
    {
        $processRepository = $this->createMock(ProcessRepository::class);
        $workMachineRepository = $this->createMock(WorkMachineRepository::class);
        $workMachineRepository->expects($this->once())
            ->method('find')
            ->with(130)
            ->willReturn(null);

        $this->expectException(WorkMachineNotFoundException::class);

        (new ProcessService($processRepository, $workMachineRepository))->getProcessesByWorkMachine(130);
    }

    public function testGetProcessesByWorkMachine(): void
    {
        $processRepository = $this->createMock(ProcessRepository::class);
        $processRepository->expects($this->once())
            ->method('findProcessByWorkMachineId')
            ->with(130)
            ->willReturn([$this->createProcessEntity()]);

        $workMachineRepository = $this->createMock(WorkMachineRepository::class);
        $workMachineRepository->expects($this->once())
            ->method('find')
            ->with(130)
            ->willReturn(new WorkMachine());

        $service = new ProcessService($processRepository, $workMachineRepository);
        $expected = new ProcessListResponse([$this->createProcessItemModel()]);

        $this->assertEquals($expected, $service->getProcessesByWorkMachine(130));
    }

//    public function testGetProcesses()
//    {
    // //        $workMachine = $this->createMock(WorkMachine::class);
    // //        $workMachine->setName('server test')->setProcessor(77)->setRam(77)->setId(7);
//
//        $workMachine = new WorkMachine();
//        $workMachine->setName('server test')->setProcessor(77)->setRam(77)->setId(7);
//
//        $repository = $this->createMock(ProcessRepository::class);
//        $repository->expects($this->once())
//            ->method('findBy')
//            ->with([], ['workMachine' => Criteria::ASC])
//            ->willReturn([(new Process())->setId(7)->setName('test')->setRam(7)->setProcessor(7)->setWorkMachine($workMachine)]);
//
//        $service = new ProcessService($repository);
//        $expected = new ProcessListResponse([new ProcessListItem(7, 'test', 7, 7, 7)]);
//        $this->assertEquals($expected, $service->getProcesses());
//    }
    private function createProcessEntity(): Process
    {
        return (new Process())
            ->setId(123)
            ->setName('Test process')
            ->setProcessor(123)
            ->setRam(123123)
            ->setWorkMachine((new WorkMachine())->setId(130));
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
