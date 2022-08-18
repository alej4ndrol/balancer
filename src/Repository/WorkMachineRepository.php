<?php

namespace App\Repository;

use App\Entity\WorkMachine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;

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

    public function add(WorkMachine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WorkMachine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function existsById(int $id): bool
    {
        return null !== $this->find($id);
    }
}
