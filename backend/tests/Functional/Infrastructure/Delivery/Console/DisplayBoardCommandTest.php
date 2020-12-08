<?php

namespace MySelf\Scrabble\Tests\Functional\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Infrastructure\Delivery\Console\DisplayBoardCommandFactory;
use MySelf\Scrabble\Tests\Functional\AssertBoardIsDisplayed;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class DisplayBoardCommandTest extends TestCase
{
    use AssertBoardIsDisplayed;

    public function testCommand()
    {
        $commandTester = new CommandTester((new DisplayBoardCommandFactory())->get());

        $commandTester->execute(['player' => 'player_1']);

        $this->assertBoardIsDisplayed($commandTester);
    }
}
