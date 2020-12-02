<?php

namespace MySelf\Scrabble\Functional\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Infrastructure\Delivery\Console\DisplayBoardCommandFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class DisplayBoardCommandTest extends TestCase
{
    public function testCommand()
    {
        $commandTester = new CommandTester((new DisplayBoardCommandFactory())->get());

        $commandTester->execute([]);

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('01 02 03 04 05 06 07 08 09 10 11 12 13 14 15', $output);

        preg_match_all('/\n[A-O]./', $output, $regexResult);
        $this->assertCount(15, $regexResult[0]);
    }
}
