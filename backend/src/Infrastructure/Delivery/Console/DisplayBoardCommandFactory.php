<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\DisplayBoardService\DisplayBoardService;
use MySelf\Scrabble\Presentation\Cli\BoardView;

class DisplayBoardCommandFactory implements CommandFactory
{
    public function get(): DisplayBoardCommand
    {
        return new DisplayBoardCommand(
            new DisplayBoardService(),
            new BoardView()
        );
    }
}
