<?php

namespace App\DataFixtures;

use App\Entity\Process;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProcessFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $server_1 = $this->getReference(WorkMachineFixtures::SERVER_1);
        $server_2 = $this->getReference(WorkMachineFixtures::SERVER_2);
        $server_3 = $this->getReference(WorkMachineFixtures::SERVER_3);

        $manager->persist((new Process())
            ->setName('firstProc')
            ->setProcessor(1001)
            ->setRam(101)
            ->setWorkMachine($server_1)
        );
        $manager->persist((new Process())
            ->setName('secProc')
            ->setProcessor(1002)
            ->setRam(102)
            ->setWorkMachine($server_2)
        );
        $manager->persist((new Process())
            ->setName('thrProc')
            ->setProcessor(1003)
            ->setRam(103)
            ->setWorkMachine($server_1)
        );
        $manager->persist((new Process())
            ->setName('fourProc')
            ->setProcessor(1004)
            ->setRam(104)
            ->setWorkMachine($server_3)
        );

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            WorkMachineFixtures::class,
        ];
    }
}
