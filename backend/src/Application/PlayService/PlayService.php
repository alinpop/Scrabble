<?php declare(strict_types=1);

namespace MySelf\Scrabble\Application\PlayService;

use MySelf\Scrabble\Application\DisplayBoardService\DisplayBoardService;
use MySelf\Scrabble\Domain\Boards\SquareFactory;
use MySelf\Scrabble\Domain\Games\Game;
use MySelf\Scrabble\Domain\Games\GameRepository;
use MySelf\Scrabble\Domain\Letters\LetterFactory;
use MySelf\Scrabble\Domain\Players\PlayerRepository;

class PlayService
{
    private PlayerRepository $playerRepository;
    private GameRepository $gameRepository;
    private DisplayBoardService $boardService;

    public function __construct(
        DisplayBoardService $boardService,
        PlayerRepository $playerRepository,
        GameRepository $gameRepository
    ) {
        $this->playerRepository = $playerRepository;
        $this->gameRepository = $gameRepository;
        $this->boardService = $boardService;
    }

    public function run(string $playerName, string $square, string $direction, string $letters)
    {
        $game = $this->gameRepository->getPlayerGame(
            $this->playerRepository->getPlayer($playerName)
        );

        if ($game->getStatus() !== Game::STATUS_STARTED) {
            throw new \Exception("The Game state is {$game->getStatus()} and you cannot play");
        }

        $playerToMove = $game->getPlayerToMove()->getName();
        if ($playerToMove !== $playerName) {
            throw new \Exception("It's not your turn, next player to move is $playerToMove");
        }

        $game->getBoard()->addLetters(
            SquareFactory::fromString($square),
            $direction,
            (new LetterFactory())->fromString($letters)
        );

        /** @todo Validate letters */
        /** @todo Validate margin of the board surpass */

        $game->updatePlayerToMove();

        $this->gameRepository->save($game);

        return [
            'board' => $this->boardService->run($game->getBoard()),
            'playerToMove' => $game->getPlayerToMove(),
        ];
    }
}
