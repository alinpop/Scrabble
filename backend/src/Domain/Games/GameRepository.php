<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Games;

use MySelf\Scrabble\Domain\Players\Player;

interface GameRepository
{
    public function save(Game $game): GameId;

    public function getPlayerGame(Player $player): Game;
}