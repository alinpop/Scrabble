<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\BoardService\BoardService;
use MySelf\Scrabble\Application\DisplayBoardService\DisplayBoardService;
use MySelf\Scrabble\Infrastructure\Persistence\Games\FileGameRepository;
use MySelf\Scrabble\Infrastructure\Persistence\Players\FilePlayerRepository;
use MySelf\Scrabble\Presentation\Cli\BoardView;

class DisplayBoardCommandFactory implements CommandFactory
{
    public function get(): DisplayBoardCommand
    {
        return new DisplayBoardCommand(
            new BoardService(
                new FilePlayerRepository(),
                new FileGameRepository()
            ),
            new DisplayBoardService(),
            new BoardView()
        );
    }
}
