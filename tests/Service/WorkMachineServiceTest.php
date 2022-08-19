<?php

namespace App\Tests\Service;

use App\Entity\WorkMachine;
use App\Model\WorkMachineListItem;
use App\Model\WorkMachineListResponse;
use App\Repository\WorkMachineRepository;
use App\Service\WorkMachineService;
use App\Tests\AbstractTestCase;
use Doctrine\ORM\EntityManagerInterface;

class WorkMachineServiceTest extends AbstractTestCase
{
    public function testGetWorkMachines()
    {
        $workMachine = (new WorkMachine())->setName('server test')->setProcessor(77)->setRam(77);
        $this->setEntityId($workMachine, 7);

        $repository = $this->createMock(WorkMachineRepository::class);
        $repository->expects($this->once())
            ->method('findAllSortedByName')
            ->willReturn([$workMachine]);

        $service = new WorkMachineService($repository);
        $expected = new WorkMachineListResponse([new WorkMachineListItem(7, 'server test', 77, 77)]);
        $this->assertEquals($expected, $service->getWorkMachines());
    }
}
