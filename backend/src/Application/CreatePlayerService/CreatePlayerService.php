<?php declare(strict_types=1);

namespace MySelf\Scrabble\Application\CreatePlayerService;

use MySelf\Scrabble\Domain\Players\Player;
use MySelf\Scrabble\Domain\Players\PlayerRepository;

class CreatePlayerService
{
    private PlayerRepository $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function run(?string $playerName = null): void
    {
        if (!$playerName || $this->playerExists($playerName)) {
            throw new \InvalidArgumentException("User '{$playerName}' already exists");
        }

        $this->playerRepository->save(new Player($playerName));
    }

    private function playerExists(string $playerName)
    {
        try {
            $this->playerRepository->getPlayer($playerName);
        } catch (\Throwable $e) {
            return false;
        }

        return true;
    }
}
