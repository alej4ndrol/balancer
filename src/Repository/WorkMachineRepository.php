<?php

namespace App\Repository;

use App\Entity\WorkMachine;
use App\Exception\WorkMachineNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkMachine>
 *
 * @method WorkMachine|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkMachine|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkMachine[]    findAll()
 * @method WorkMachine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkMachineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkMachine::class);
    }

    /**
     * @return WorkMachine[]
     */
    public function findAllSortedByName(): array
    {
        return $this->findBy([], ['name' => Criteria::ASC]);
    }

    /**
     * @return WorkMachine[]
     */
    public function findWorkMachineWithEnoughResources(int $processor, int $ram): array
    {
        $query = $this->_em->createQuery('SELECT b FROM App\Entity\WorkMachine as b WHERE b.id NOT IN (
    SELECT
        IDENTITY(a.workMachine)
    FROM
        App\Entity\Process a
    GROUP BY
        a.workMachine
    HAVING
        SUM(a.processor) + (:processor) > b.processor AND SUM(a.ram) + (:ram) > b.ram)
        ');
        $query->setParameter('processor', $processor);
        $query->setParameter('ram', $ram);

        return $query->getResult();
    }

    public function getByName(string $name): WorkMachine
    {
        $workMachine = $this->findOneBy(['name' => $name]);
        if (null === $workMachine) {
            throw new WorkMachineNotFoundException();
        }
        return $workMachine;
    }

    public function existsByName(string $name): bool
    {
        return null !== $this->findOneBy(['name' => $name]);
    }

    public function existsById(int $id): bool
    {
        return null !== $this->find($id);
    }
}
