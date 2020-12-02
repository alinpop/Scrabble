<?php declare(strict_types=1);

namespace MySelf\Scrabble\Functional\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\AddPlayerToGameService\AddPlayerToGameService;
use MySelf\Scrabble\Domain\Players\Player;
use MySelf\Scrabble\Infrastructure\Delivery\Console\AddPlayerToGameCommand;
use Symfony\Component\Console\Tester\CommandTester;

class AddPlayerToGameCommandTest extends CommandTestCase
{
    private static CommandTester $command;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$playerRepository->save(new Player('player_1'));
        self::$playerRepository->save(new Player('player_2'));

        self::$command = new CommandTester(
            new AddPlayerToGameCommand(
                new AddPlayerToGameService(
                    self::$playerRepository,
                    self::$gameRepository
                )
            )
        );
    }

    public function testAddPlayer()
    {
        self::$command->execute(['player' => 'player_1']);
    }
}
