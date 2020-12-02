<?php declare(strict_types=1);

namespace MySelf\Scrabble\Application\PrepareGameService;

use MySelf\Scrabble\Application\ApplicationService;
use MySelf\Scrabble\Domain\Games\GameFactory;
use MySelf\Scrabble\Domain\Games\GameRepository;
use MySelf\Scrabble\Domain\Players\PlayerRepository;

class PrepareGameService implements ApplicationService
{
    private GameRepository $gameRepository;
    private PlayerRepository $playerRepository;

    public function __construct(GameRepository $gameRepository, PlayerRepository $playerRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
    }

    public function run(?string $playerName = null)
    {
        try {
            $player = $this->playerRepository->getPlayer($playerName);
        } catch (\Throwable $e) {
            throw new \Exception("Game cannot be prepared. " . $e->getMessage());
        }

        try {
            $activeGame = $this->gameRepository->getPlayerGame($player);
        } catch (\Throwable $e) {
            $activeGame = null;
        }

        if ($activeGame) {
            throw new \Exception("Player {$player->getName()} already has a started Game");
        }

        $game = (new GameFactory())->prepareGame($player);

        $this->gameRepository->save($game);

        return $game->getGameId();
    }
}
