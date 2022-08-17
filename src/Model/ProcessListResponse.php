<?php

namespace App\Model;

class ProcessListResponse
{
    /**
     * @var ProcessListItem[]
     */
    private array $items;

    /**
     * @return ProcessListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param ProcessListItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }


}
