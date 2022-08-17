<?php

namespace App\Model;

class WorkMachineListResponse
{
    /**
     * @var WorkMachineListItem[]
     */
    private array $items;

    /**
     * @return WorkMachineListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param WorkMachineListItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }


}
