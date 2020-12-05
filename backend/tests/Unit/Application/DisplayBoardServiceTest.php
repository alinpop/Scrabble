<?php

namespace MySelf\Scrabble\Tests\Unit\Application;

use MySelf\Scrabble\Application\DisplayBoardService\DisplayBoardService;
use MySelf\Scrabble\Domain\Boards\Board;
use MySelf\Scrabble\Domain\Boards\SquareFactory;
use MySelf\Scrabble\Domain\Letters\Letter;
use PHPUnit\Framework\TestCase;

class DisplayBoardServiceTest extends TestCase
{
    public function testDisplayLetters()
    {
        $board = new Board();
        $board->addLetters(
            SquareFactory::fromString('1A'),
            'right',
            [new Letter('X', 10)]
        );

        $service = new DisplayBoardService();
        $display = $service->run($board);

        $this->assertStringContainsString('X', $display["A"]["01"]);
    }
}
