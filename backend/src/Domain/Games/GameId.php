<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Games;

class GameId
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }



    public function __toString(): string
    {
        return $this->getId();
    }
}
