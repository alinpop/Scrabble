<?php

namespace MySelf\Scrabble\Tests\Functional\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\AddPlayerToGameService\AddPlayerToGameService;
use MySelf\Scrabble\Application\PrepareGameService\PrepareGameService;
use MySelf\Scrabble\Application\StartGameService\StartGameService;
use MySelf\Scrabble\Domain\Games\Game;
use MySelf\Scrabble\Domain\Players\Player;
use MySelf\Scrabble\Infrastructure\Delivery\Console\AddPlayerToGameCommand;
use MySelf\Scrabble\Infrastructure\Delivery\Console\PrepareGameCommand;
use MySelf\Scrabble\Infrastructure\Delivery\Console\StartGameCommand;
use MySelf\Scrabble\Presentation\Cli\BoardView;
use Symfony\Component\Console\Tester\CommandTester;

class StartGameCommandTest extends CommandTestCase
{
    private static CommandTester $startGameCommand;
    private static CommandTester $addPlayerCommand;
    private static CommandTester $prepareGameCommand;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$playerRepository->save(new Player('player_1'));
        self::$playerRepository->save(new Player('player_2'));
        self::$playerRepository->save(new Player('player_3'));
        self::$playerRepository->save(new Player('player_4'));

        self::$prepareGameCommand = new CommandTester(new PrepareGameCommand(
            new PrepareGameService(self::$gameRepository, self::$playerRepository)
        ));

        self::$addPlayerCommand = new CommandTester(new AddPlayerToGameCommand(
            new AddPlayerToGameService(self::$playerRepository, self::$gameRepository)
        ));

        self::$startGameCommand = new CommandTester(new StartGameCommand(
            new StartGameService(self::$playerRepository, self::$gameRepository), new BoardView()
        ));
    }

    public function testStartGame()
    {
        self::$prepareGameCommand->execute(['player' => 'player_1']);
        self::$addPlayerCommand->execute(['player' => 'player_1', 'newPlayer' => 'player_2']);
        self::$addPlayerCommand->execute(['player' => 'player_1', 'newPlayer' => 'player_3']);

        self::$startGameCommand->execute(['player' => 'player_1']);

        $game = self::$gameRepository->getPlayerGame(
            self::$playerRepository->getPlayer('player_1')
        );

        $gameArray = $this->objectToArray($game);

        $this->assertEquals(Game::STATUS_STARTED, $gameArray['status']);

        $this->assertCount(7, $gameArray['playerLetters']['player_1']);
        $this->assertCount(7, $gameArray['playerLetters']['player_2']);
        $this->assertCount(7, $gameArray['playerLetters']['player_3']);

        $this->assertCount(100-21, $gameArray['letterBag']);

        $playerOrderToMove = explode(',', $gameArray['playOrder']);
        $this->assertCount(3, $playerOrderToMove);

        $this->assertEquals($playerOrderToMove[0], $gameArray['playerToMove']);
    }

    /**
     * @depends testStartGame
     */
    public function testAddingPlayerAfterTheStartGame()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Player cannot be added when Game status is started");

        self::$addPlayerCommand->execute(['player' => 'player_1', 'newPlayer' => 'player_4']);
    }

    /**
     * @depends testStartGame
     */
    public function testPlayerStartingNotAvailableGame()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No Game started');

        self::$startGameCommand->execute(['player' => 'player_4']);
    }
}
