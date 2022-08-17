<?php

namespace App\Service;

use App\Entity\Process;
use App\Exception\WorkMachineNotFoundException;
use App\Model\ProcessListItem;
use App\Model\ProcessListResponse;
use App\Repository\ProcessRepository;
use App\Repository\WorkMachineRepository;
use Doctrine\Common\Collections\Criteria;

class ProcessService
{
    public function __construct(private ProcessRepository $processRepository, private WorkMachineRepository $workMachineRepository)
    {
    }

    public function getProcessesByWorkMachine(int $workMachineId): ProcessListResponse
    {
        $workMachine = $this->workMachineRepository->find($workMachineId);

        if (null === $workMachine) {
            throw new WorkMachineNotFoundException();
        }

        return new ProcessListResponse(array_map(
            [$this, 'map'],
            $this->processRepository->findProcessByWorkMachineId($workMachineId)
        ));
    }

    public function getProcesses(): ProcessListResponse
    {
        $processes = $this->processRepository->findBy([], ['workMachine' => Criteria::ASC]);
        $items = array_map(
            fn (Process $process) => (new ProcessListItem())
                ->setId($process->getId())
                ->setName($process->getName())
                ->setRam($process->getRam())
                ->setProcessor($process->getProcessor())
                ->setWorkMachine($process->getWorkMachine()->getId()),
            $processes
        );

        return new ProcessListResponse($items);
    }

    public function map(Process $process): ProcessListItem
    {
        return (new ProcessListItem())
            ->setId($process->getId())
            ->setName($process->getName())
            ->setRam($process->getRam())
            ->setProcessor($process->getProcessor())
            ->setWorkMachine($process->getWorkMachine()->getId())
        ;
    }
}
