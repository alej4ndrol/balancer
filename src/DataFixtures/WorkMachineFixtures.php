<?php

namespace App\DataFixtures;

use App\Entity\WorkMachine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WorkMachineFixtures extends Fixture
{
    public const SERVER_1 = 'server_1';
    public const SERVER_2 = 'server_2';
    public const SERVER_3 = 'server_3';

    public function load(ObjectManager $manager): void
    {
        $servers = [
            self::SERVER_1 => (new WorkMachine())->setName('server 1')->setProcessor(10011)->setRam(1011),
            self::SERVER_2 => (new WorkMachine())->setName('server 2')->setProcessor(10012)->setRam(1022),
            self::SERVER_3 => (new WorkMachine())->setName('server 3')->setProcessor(10013)->setRam(1033),
        ];
        foreach ($servers as $server) {
            $manager->persist($server);
        }

        $manager->flush();

        foreach ($servers as $code => $server) {
            $this->addReference($code, $server);
        }
    }
}
