<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

class AddPlayerToGameCommandFactory implements CommandFactory
{
    public function get(): AddPlayerToGameCommand
    {
        return new AddPlayerToGameCommand();
    }
}
