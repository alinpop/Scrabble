<?php declare(strict_types=1);

namespace MySelf\Scrabble\Application\StartGameService;

use MySelf\Scrabble\Domain\Games\GameRepository;
use MySelf\Scrabble\Domain\Players\PlayerRepository;

class StartGameService
{
    private GameRepository $gameRepository;
    private PlayerRepository $playerRepository;

    public function __construct(PlayerRepository $playerRepository, GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
    }

    public function run(string $player)
    {
        $game = $this->gameRepository->getPlayerGame(
            $this->playerRepository->getPlayer($player)
        );

        $game->start();

        $this->gameRepository->save($game);
    }
}
