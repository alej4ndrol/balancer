<?php

namespace App\Entity;

use App\Repository\WorkMachineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkMachineRepository::class)]
class WorkMachine
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

    #[ORM\OneToMany(mappedBy: 'workMachine', targetEntity: Process::class)]
    private Collection $process;

    public function __construct()
    {
        $this->process = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Process>
     */
    public function getProcess(): Collection
    {
        return $this->process;
    }

    public function addProcess(Process $process): self
    {
        if (!$this->process->contains($process)) {
            $this->process->add($process);
            $process->setWorkMachine($this);
        }

        return $this;
    }

    public function removeProcess(Process $process): self
    {
        if ($this->process->removeElement($process)) {
            // set the owning side to null (unless already changed)
            if ($process->getWorkMachine() === $this) {
                $process->setWorkMachine(null);
            }
        }

        return $this;
    }
}
