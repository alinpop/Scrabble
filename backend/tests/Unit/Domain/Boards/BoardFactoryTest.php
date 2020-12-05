<?php

namespace MySelf\Scrabble\Tests\Unit\Domain\Boards;

use MySelf\Scrabble\Domain\Boards\BoardFactory;
use MySelf\Scrabble\Domain\Boards\Square;
use PHPUnit\Framework\TestCase;

class BoardFactoryTest extends TestCase
{
    public function testBoardInitiatedFromArray()
    {
        $board = BoardFactory::fromArray(
            [3 => [2 => "P"]]
        );

        $this->assertEquals("P", $board->getSquare(new Square(3, "D"))->getLetter());
    }
}
