<?php

namespace MySelf\Scrabble\Tests\Functional\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\CreatePlayerService\CreatePlayerService;
use MySelf\Scrabble\Domain\Players\Player;
use MySelf\Scrabble\Infrastructure\Delivery\Console\CreatePlayerCommand;
use MySelf\Scrabble\Infrastructure\Persistence\Players\FilePlayerRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CreatePlayerCommandTest extends TestCase
{
    private static FilePlayerRepository $playerRepository;
    private static CommandTester $command;

    public static function setUpBeforeClass(): void
    {
        self::$playerRepository = new FilePlayerRepository('TestPlayerRepository');
        self::$command = new CommandTester(new CreatePlayerCommand(new CreatePlayerService(self::$playerRepository)));
    }

    public static function tearDownAfterClass(): void
    {
        self::$playerRepository->dropRepository();
    }

    public function testCommand()
    {
        self::$command->execute(['name' => 'a_Player']);

        $player = self::$playerRepository->getPlayer('a_Player');

        $this->assertInstanceOf(Player::class, $player);
    }

    /**
     * @dataProvider commandWithWrongNameDataProvider
     */
    public function testCommandWithWrongName(string $name)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The name is invalid');

        self::$command->execute(['name' => $name]);
    }

    public function commandWithWrongNameDataProvider()
    {
        return [
            ['My Name'],
            ['My$Name'],
            ['My+Name'],
            ['%$^%&^_$%#%%'],
            ["Some Other\nName"],
        ];
    }

    public function testCommandWIthDuplicate()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('already exists');

        self::$command->execute(['name' => 'somePlayer']);
        self::$command->execute(['name' => 'somePlayer']);
    }
}
