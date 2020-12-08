<?php declare(strict_types=1);

namespace MySelf\Scrabble\Application\BoardService;

use MySelf\Scrabble\Domain\Games\GameRepository;
use MySelf\Scrabble\Domain\Players\PlayerRepository;

class BoardService
{
    private PlayerRepository $playerRepository;
    private GameRepository $gameRepository;

    public function __construct(
        PlayerRepository $playerRepository,
        GameRepository $gameRepository
    ) {
        $this->playerRepository = $playerRepository;
        $this->gameRepository = $gameRepository;
    }

    public function run(string $playerName)
    {
        $game = $this->gameRepository->getPlayerGame(
            $this->playerRepository->getPlayer($playerName)
        );

        return ['board' => $game->getBoard()];
    }
}
