<?php

namespace MySelf\Scrabble\Tests\Functional\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\AddPlayerToGameService\AddPlayerToGameService;
use MySelf\Scrabble\Application\DisplayBoardService\DisplayBoardService;
use MySelf\Scrabble\Application\PlayService\PlayService;
use MySelf\Scrabble\Application\PrepareGameService\PrepareGameService;
use MySelf\Scrabble\Application\StartGameService\StartGameService;
use MySelf\Scrabble\Domain\Players\Player;
use MySelf\Scrabble\Infrastructure\Delivery\Console\AddPlayerToGameCommand;
use MySelf\Scrabble\Infrastructure\Delivery\Console\PlayCommand;
use MySelf\Scrabble\Infrastructure\Delivery\Console\PrepareGameCommand;
use MySelf\Scrabble\Infrastructure\Delivery\Console\StartGameCommand;
use MySelf\Scrabble\Presentation\Cli\BoardView;
use MySelf\Scrabble\Tests\Functional\AssertBoardIsDisplayed;
use Symfony\Component\Console\Tester\CommandTester;

class PlayCommandTest extends CommandTestCase
{
    use AssertBoardIsDisplayed;

    private static CommandTester $prepareGameCommand;
    private static CommandTester $addPlayerCommand;
    private static CommandTester $startGameCommand;
    private static CommandTester $playCommand;

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
            new StartGameService(new DisplayBoardService(), self::$playerRepository, self::$gameRepository),
            new BoardView()
        ));

        self::$playCommand = new CommandTester(
            new PlayCommand(
                new PlayService(new DisplayBoardService(), self::$playerRepository, self::$gameRepository),
                new BoardView()
            )
        );

        self::$prepareGameCommand->execute(['player' => 'player_1']);
        self::$addPlayerCommand->execute(['player' => 'player_1', 'newPlayer' => 'player_2']);
        self::$addPlayerCommand->execute(['player' => 'player_1', 'newPlayer' => 'player_3']);

        self::$startGameCommand->execute(['player' => 'player_1']);
    }

    public function testPlay()
    {
        $game = self::$gameRepository->getPlayerGame(new Player('player_1'));
        $playerToMove = $game->getPlayerToMove()->getName();
        self::$playCommand->execute([
            'player' => $playerToMove, 'square' => '8H', 'direction' => 'right', 'letters' => 'ABC',
        ]);

        $this->assertBoardIsDisplayed(self::$playCommand);
        $this->assertStringContainsString('A  B  C', self::$playCommand->getDisplay());

        $game = self::$gameRepository->getPlayerGame(new Player('player_1'));
        $playerToMove = $game->getPlayerToMove()->getName();
        self::$playCommand->execute([
            'player' => $playerToMove, 'square' => '8H', 'direction' => 'down', 'letters' => 'DEF',
        ]);
        $this->assertStringContainsString('A  B  C', self::$playCommand->getDisplay());
        $this->assertStringContainsString('_  _  +  _  _  _  +  D  +  _  _  _  +  _  _', self::$playCommand->getDisplay());
        $this->assertStringContainsString('_  +  _  _  _  +  _  E  _  +  _  _  _  +  _', self::$playCommand->getDisplay());
        $this->assertStringContainsString('_  _  _  _  *  _  _  F  _  _  *  _  _  _  _', self::$playCommand->getDisplay());
    }

    public function testPlayingWrongPlayer()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("It's not your turn");
        
        $game = self::$gameRepository->getPlayerGame(new Player('player_1'));
        $playerToMove = $game->getPlayerToMove();
        $wrongPlayerToMove = 'player_1';
        if ($playerToMove->getName() === 'player_1') {
            $wrongPlayerToMove = 'player_2';
        }

        self::$playCommand->execute([
            'player' => $wrongPlayerToMove, 'square' => '8H', 'direction' => 'right', 'letters' => 'ABC',
        ]);
    }

    public function testPlayingBeforeTheGameStarted()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('you cannot play');

        self::$prepareGameCommand->execute(['player' => 'player_4']);

        self::$playCommand->execute([
            'player' => 'player_4', 'square' => '8H', 'direction' => 'right', 'letters' => 'ABC',
        ]);
    }
}
