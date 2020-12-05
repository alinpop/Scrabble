<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\DisplayBoardService\DisplayBoardService;
use MySelf\Scrabble\Application\PlayService\PlayService;
use MySelf\Scrabble\Infrastructure\Persistence\Games\FileGameRepository;
use MySelf\Scrabble\Infrastructure\Persistence\Players\FilePlayerRepository;
use MySelf\Scrabble\Presentation\Cli\BoardView;

class PlayCommandFactory implements CommandFactory
{
    public function get(): PlayCommand
    {
        return new PlayCommand(
            new PlayService(
                new DisplayBoardService(),
                new FilePlayerRepository(),
                new FileGameRepository()
            ),
            new BoardView()
        );
    }
}
