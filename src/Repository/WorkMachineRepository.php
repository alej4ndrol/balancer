<?php

namespace App\Repository;

use _PHPStan_9a6ded56a\Composer\XdebugHandler\Process;
use App\Entity\WorkMachine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
}
