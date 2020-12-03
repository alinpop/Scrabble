<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\AddPlayerToGameService\AddPlayerToGameService;
use MySelf\Scrabble\Infrastructure\Persistence\Games\FileGameRepository;
use MySelf\Scrabble\Infrastructure\Persistence\Players\FilePlayerRepository;

class AddPlayerToGameCommandFactory implements CommandFactory
{
    public function get(): AddPlayerToGameCommand
    {
        return new AddPlayerToGameCommand(
            new AddPlayerToGameService(
                new FilePlayerRepository(),
                new FileGameRepository()
            )
        );
    }
}
