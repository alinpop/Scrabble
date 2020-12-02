<?php

namespace MySelf\Scrabble\Functional\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\PrepareGameService\PrepareGameService;
use MySelf\Scrabble\Domain\Games\Game;
use MySelf\Scrabble\Domain\Players\Player;
use MySelf\Scrabble\Infrastructure\Delivery\Console\PrepareGameCommand;
use Symfony\Component\Console\Tester\CommandTester;

class PrepareGameCommandTest extends CommandTestCase
{
    private static CommandTester $command;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$playerRepository->save(new Player('player_1'));
        self::$playerRepository->save(new Player('player_2'));
        self::$playerRepository->save(new Player('player_3'));

        self::$command = new CommandTester(new PrepareGameCommand(
            new PrepareGameService(self::$gameRepository, self::$playerRepository)
        ));
    }

    public function testPrepareGame()
    {
        self::$command->execute(['player' => 'player_1']);

        $game = self::$gameRepository->getPlayerGame(new Player('player_1'));

        $this->assertInstanceOf(Game::class, $game);
        $this->assertCount(100, $game->getLetterBag());
    }

    public function testCannotPrepareGame()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Game cannot be prepared");

        self::$command->execute(['player' => 'nonexistent_player']);
    }

    public function testPreparingSecondGameThrowsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('player_3 already has a started Game');

        self::$command->execute(['player' => 'player_3']);
        self::$command->execute(['player' => 'player_3']);
    }
}
