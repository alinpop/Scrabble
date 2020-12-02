<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Players;

interface PlayerRepository
{
    public function save(Player $player): void;

    public function getPlayer(string $playerName): Player;

    public function dropRepository(): void;
}
