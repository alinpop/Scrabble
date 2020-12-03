<?php declare(strict_types=1);

namespace MySelf\Scrabble\Application\AddPlayerToGameService;

use MySelf\Scrabble\Domain\Games\Game;
use MySelf\Scrabble\Domain\Games\GameRepository;
use MySelf\Scrabble\Domain\Players\Player;
use MySelf\Scrabble\Domain\Players\PlayerRepository;

class AddPlayerToGameService
{
    private PlayerRepository $playerRepository;
    private GameRepository $gameRepository;

    public function __construct(PlayerRepository $playerRepository, GameRepository $gameRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->gameRepository = $gameRepository;
    }

    public function run(string $playerName, string $newPlayerName)
    {
        try {
            $activeGame = $this->gameRepository->getPlayerGame(
                $this->playerRepository->getPlayer($playerName)
            );

            $gameStatus = $activeGame->getStatus();
            if ($gameStatus !== Game::STATUS_PREPARING) {
                throw new \Exception("Player cannot be added when Game status is $gameStatus");
            }

            $newPlayer = $this->playerRepository->getPlayer($newPlayerName);

            if ($this->playerHasActiveGame($newPlayer)) {
                throw new \Exception("{$newPlayer->getName()} is playing another Game");
            }

            $activeGame->addPlayer($newPlayer);

            $this->gameRepository->save($activeGame);
        } catch (\Throwable $e) {
            throw new \Exception(
                "Player '$newPlayerName' could not be added to the Game: " . $e->getMessage()
            );
        }
    }

    private function playerHasActiveGame(Player $newPlayer): bool
    {
        try {
            $this->gameRepository->getPlayerGame($newPlayer);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
