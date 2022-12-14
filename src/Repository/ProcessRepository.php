<?php

namespace App\Repository;

use App\Entity\Process;
use App\Exception\ProcessNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Process>
 *
 * @method Process|null find($id, $lockMode = null, $lockVersion = null)
 * @method Process|null findOneBy(array $criteria, array $orderBy = null)
 * @method Process[]    findAll()
 * @method Process[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Process::class);
    }

    /**
     * @return Process[]
     */
    public function findProcessByWorkMachineId(int $id): array
    {
        $query = $this->_em->createQuery('SELECT b FROM App\Entity\Process b WHERE b.workMachine IN (:workMachineId)');
        $query->setParameter('workMachineId', $id);

        return $query->getResult();
    }

    public function getByName(string $name): Process
    {
        $process = $this->findOneBy(['name' => $name]);
        if (null === $process) {
            throw new ProcessNotFoundException();
        }

        return $process;
    }

    public function existsByName(string $name): bool
    {
        return null !== $this->findOneBy(['name' => $name]);
    }
}
