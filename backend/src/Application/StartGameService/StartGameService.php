<?php declare(strict_types=1);

namespace MySelf\Scrabble\Application\StartGameService;

use MySelf\Scrabble\Application\DisplayBoardService\DisplayBoardService;
use MySelf\Scrabble\Domain\Games\GameRepository;
use MySelf\Scrabble\Domain\Players\PlayerRepository;

class StartGameService
{
    private GameRepository $gameRepository;
    private PlayerRepository $playerRepository;
    private DisplayBoardService $boardService;

    public function __construct(DisplayBoardService $boardService, PlayerRepository $playerRepository, GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
        $this->boardService = $boardService;
    }

    public function run(string $player): array
    {
        $game = $this->gameRepository->getPlayerGame(
            $this->playerRepository->getPlayer($player)
        );

        $game->start();

        $this->gameRepository->save($game);

        return $this->boardService->run($game->getBoard());
    }
}
