<?php

namespace App\Entity;

use App\Repository\ProcessRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProcessRepository::class)]
class Process
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private string $name;

    #[ORM\Column]
    private int $processor;

    #[ORM\Column]
    private int $ram;

    #[ORM\ManyToOne(inversedBy: 'process')]
    #[ORM\JoinColumn(nullable: false)]
    private WorkMachine $workMachine;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProcessor(): ?int
    {
        return $this->processor;
    }

    public function setProcessor(int $processor): self
    {
        $this->processor = $processor;

        return $this;
    }

    public function getRam(): ?int
    {
        return $this->ram;
    }

    public function setRam(int $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    public function getWorkMachine(): ?WorkMachine
    {
        return $this->workMachine;
    }

    public function setWorkMachine(?WorkMachine $workMachine): self
    {
        $this->workMachine = $workMachine;

        return $this;
    }
}
