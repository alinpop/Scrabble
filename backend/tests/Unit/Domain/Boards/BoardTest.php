<?php declare(strict_types=1);

namespace MySelf\Scrabble\Tests\Unit\Domain\Boards;

use MySelf\Scrabble\Domain\Boards\Board;
use MySelf\Scrabble\Domain\Boards\Square;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function testGetSquare()
    {
        $board = new Board();

        $squareToLookFor = new Square(3, 'D');

        $square = $board->getSquare($squareToLookFor);

        $this->assertEquals($board->getSquares()[3][2], $square);

        $square = $board->getSquareToRight($squareToLookFor);
        $this->assertEquals(4, $square->getColumn());
        $this->assertEquals('D', $square->getRow());

        $square = $board->getSquareFromBellow($squareToLookFor);

        $this->assertEquals(3, $square->getColumn());
        $this->assertEquals('E', $square->getRow());
    }
}
