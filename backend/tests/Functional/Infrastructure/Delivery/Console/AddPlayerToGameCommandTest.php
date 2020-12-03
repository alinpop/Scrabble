<?php declare(strict_types=1);

namespace MySelf\Scrabble\Functional\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\AddPlayerToGameService\AddPlayerToGameService;
use MySelf\Scrabble\Application\PrepareGameService\PrepareGameService;
use MySelf\Scrabble\Domain\Games\Game;
use MySelf\Scrabble\Domain\Players\Player;
use MySelf\Scrabble\Infrastructure\Delivery\Console\AddPlayerToGameCommand;
use MySelf\Scrabble\Infrastructure\Delivery\Console\PrepareGameCommand;
use Symfony\Component\Console\Tester\CommandTester;

class AddPlayerToGameCommandTest extends CommandTestCase
{
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

        self::$addPlayerCommand = new CommandTester(
            new AddPlayerToGameCommand(
                new AddPlayerToGameService(self::$playerRepository, self::$gameRepository)
            )
        );
    }

    public function testAddPlayer()
    {
        self::$prepareGameCommand->execute(['player' => 'player_1']);

        self::$addPlayerCommand->execute(['player' => 'player_1', 'newPlayer' => 'player_2']);
        self::$addPlayerCommand->execute(['player' => 'player_1', 'newPlayer' => 'player_3']);

        $game = self::$gameRepository->getPlayerGame(new Player('player_2'));
        $this->assertInstanceOf(Game::class, $game);

        $game = self::$gameRepository->getPlayerGame(new Player('player_3'));
        $this->assertInstanceOf(Game::class, $game);

        $this->assertCount(3, json_decode(json_encode($game), true)['players']);
    }

    /**
     * @depends testAddPlayer
     */
    public function testAddingAPlayerThatAlreadyPlays()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("player_2 is playing another Game");

        self::$prepareGameCommand->execute(['player' => 'player_4']);
        self::$addPlayerCommand->execute(['player' => 'player_1', 'newPlayer' => 'player_2']);
    }

    /**
     * @depends testAddPlayer
     */
    public function testAddingNonexistentPlayer()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Player 'player_unknown' could not be added");

        self::$addPlayerCommand->execute([
            'player' => 'player_1', 'newPlayer' => 'player_unknown'
        ]);
    }
}
