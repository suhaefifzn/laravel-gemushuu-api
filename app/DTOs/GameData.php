<?php

namespace App\DTOs;

class GameData
{
    public string $name;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }
}
