<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateWorkMachineRequest
{
    #[NotBlank]
    private string $name;

    #[NotBlank]
    #[GreaterThan(0)]
    private int $cores;

    #[NotBlank]
    #[GreaterThan(0)]
    private int $ram;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCores(): int
    {
        return $this->cores;
    }

    public function setCores(int $cores): self
    {
        $this->cores = $cores * 100;

        return $this;
    }

    public function getRam(): int
    {
        return $this->ram;
    }

    public function setRam(int $ram): self
    {
        $this->ram = $ram;

        return $this;
    }
}
