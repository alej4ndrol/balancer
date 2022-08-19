<?php

namespace App\Service;

use App\Entity\Process;
use App\Entity\WorkMachine;
use App\Exception\ProcessAlreadyExistsException;
use App\Exception\WorkMachineAlreadyExistsException;
use App\Exception\WorkMachinesOverloadedException;
use App\Model\CreateProcessRequest;
use App\Model\CreateWorkMachineRequest;
use App\Model\IdResponse;
use App\Repository\ProcessRepository;
use App\Repository\WorkMachineRepository;
use Doctrine\ORM\EntityManagerInterface;

class BalancingService
{
    public function __construct(private ProcessRepository $processRepository, private WorkMachineRepository $workMachineRepository, private EntityManagerInterface $em)
    {
    }

    public function createProcess(CreateProcessRequest $request): IdResponse
    {
        if ($this->processRepository->existsByName($request->getName())) {
            throw new ProcessAlreadyExistsException();
        }

        $workMachine = $this->findWorkMachineMinimumLoad($request->getProcessor(), $request->getRam(), 'Can\'t create work-machine. All ');

        $process = (new Process())
            ->setName($request->getName())
            ->setProcessor($request->getProcessor())
            ->setRam($request->getRam())
            ->setWorkMachine($workMachine);

        $this->em->persist($process);
        $this->em->flush();

        return new IdResponse($process->getId());
    }

    public function deleteProcess(string $name): void
    {
        $process = $this->processRepository->getByName($name);


        $this->em->remove($process);
        $this->em->flush();
    }

    public function findWorkMachineMinimumLoad(int $processor, int $ram, string $errorMessage): WorkMachine
    {
        $result = null;
        $minLoadFact = 1;

        $workMachines = $this->workMachineRepository->findWorkMachineWithEnoughResources($processor, $ram);

        foreach ($workMachines as $workMachine) {
            $processes = $this->processRepository->findProcessByWorkMachineId($workMachine->getId());

            $processProcessor = 0;
            $processRam = 0;
            foreach ($processes as $process) {
                $processProcessor += $process->getProcessor();
                $processRam += $process->getRam();
            }

            $data = ($processProcessor / $workMachine->getProcessor() + $processRam / $workMachine->getRam()) / 2;
            // #todo add getLoad
            // #todo add tests
            if ($data < $minLoadFact) {
                $minLoadFact = $data;
                $result = $workMachine;
            }
        }

        if (null === $result) {
            throw new WorkMachinesOverloadedException($errorMessage);
        }

        return $result;
    }

    public function createWorkMachine(CreateWorkMachineRequest $request): IdResponse
    {
        if ($this->workMachineRepository->existsByName($request->getName())) {
            throw new WorkMachineAlreadyExistsException();
        }

        $workMachine = (new WorkMachine())
            ->setName($request->getName())
            ->setProcessor($request->getCores())
            ->setRam($request->getRam());

        $this->em->persist($workMachine);
        $this->em->flush();

        return new IdResponse($workMachine->getId());
    }

    public function deleteWorkMachine(string $name): void
    {
        $workMachine = $this->workMachineRepository->getByName($name);

        $processes = $this->processRepository->findProcessByWorkMachineId($workMachine->getId());
        if (!empty($processes)) {
            foreach ($processes as $process) {
                $workMachineToBalance = $this->findWorkMachineMinimumLoad($process->getProcessor(), $process->getRam(), 'Can\'t delete work-machine. Other ');
                $process->setWorkMachine($workMachineToBalance);
                $this->em->persist($process);
            }
        }
        $this->em->remove($workMachine);
        $this->em->flush();
    }
}
