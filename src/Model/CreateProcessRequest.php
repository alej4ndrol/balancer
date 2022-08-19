<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateProcessRequest
{
    #[NotBlank]
    private string $name;

    #[NotBlank]
    #[GreaterThan(0)]
    private int $processor;

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

    public function getProcessor(): int
    {
        return $this->processor;
    }

    public function setProcessor(int $processor): self
    {
        $this->processor = $processor;

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
