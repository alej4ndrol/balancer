<?php

namespace App\Model;

class WorkMachineListItem
{
    private int $id;

    private string $name;

    private int $processor;

    private int $ram;

    public function __construct(int $id, string $name, int $processor, int $ram)
    {
        $this->id = $id;
        $this->name = $name;
        $this->processor = $processor;
        $this->ram = $ram;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setProcessor(int $processor): self
    {
        $this->processor = $processor;

        return $this;
    }

    public function setRam(int $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProcessor(): int
    {
        return $this->processor;
    }

    public function getRam(): int
    {
        return $this->ram;
    }
}
