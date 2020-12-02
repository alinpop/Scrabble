<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\PrepareGameService\PrepareGameService;
use MySelf\Scrabble\Infrastructure\Persistence\Games\FileGameRepository;
use MySelf\Scrabble\Infrastructure\Persistence\Players\FilePlayerRepository;

class PrepareGameCommandFactory implements CommandFactory
{

    public function get(): PrepareGameCommand
    {
        return new PrepareGameCommand(
            new PrepareGameService(
                new FileGameRepository(),
                new FilePlayerRepository()
            )
        );
    }
}
