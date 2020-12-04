<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\StartGameService\StartGameService;
use MySelf\Scrabble\Infrastructure\Persistence\Games\FileGameRepository;
use MySelf\Scrabble\Infrastructure\Persistence\Players\FilePlayerRepository;
use MySelf\Scrabble\Presentation\Cli\BoardView;

class StartGameCommandFactory implements CommandFactory
{

    public function get(): StartGameCommand
    {
        return new StartGameCommand(
            new StartGameService(
                new FilePlayerRepository(),
                new FileGameRepository()
            ),
            new BoardView()
        );
    }
}
