<?php

namespace App\Service;

use App\Entity\WorkMachine;
use App\Model\WorkMachineListItem;
use App\Model\WorkMachineListResponse;
use App\Repository\ProcessRepository;
use App\Repository\WorkMachineRepository;
use Doctrine\Common\Collections\Criteria;

class WorkMachineService
{
    public function __construct(private WorkMachineRepository $workMachineRepository)
    {
    }

    public function getWorkMachines(): WorkMachineListResponse
    {
        $workMachines = $this->workMachineRepository->findBy([], ['name' => Criteria::ASC]);
        $items = array_map(
            fn (WorkMachine $workMachine) => new WorkMachineListItem(
                $workMachine->getId(), $workMachine->getName(), $workMachine->getProcessor(), $workMachine->getRam()
            ),
            $workMachines
        );

        return new WorkMachineListResponse($items);
    }

    public function getWorkMachineByName(string $name): WorkMachine
    {
        return $this->workMachineRepository->findOneBy(['name' => $name]);
    }
}
