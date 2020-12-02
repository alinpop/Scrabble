<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\CreatePlayerService\CreatePlayerService;
use MySelf\Scrabble\Infrastructure\Persistence\Players\FilePlayerRepository;

class CreatePlayerCommandFactory implements CommandFactory
{
    public function get(string $fileName = null): CreatePlayerCommand
    {
        return new CreatePlayerCommand(
            new CreatePlayerService(
                new FilePlayerRepository($fileName)
            )
        );
    }
}
