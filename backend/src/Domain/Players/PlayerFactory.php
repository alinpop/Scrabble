<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Players;

class PlayerFactory
{
    public function fromCollection(array $collection = []): array
    {
        $result = [];
        foreach ($collection as $player) {
            $result[] = new Player($player);
        }

        return $result;
    }
}
