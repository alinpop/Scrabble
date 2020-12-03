<?php

namespace MySelf\Scrabble\Tests\Unit\Domain\Boards;

use MySelf\Scrabble\Domain\Boards\Square;
use PHPUnit\Framework\TestCase;

class SquareTest extends TestCase
{
    public function testInstance()
    {
        $square = new Square(5, 'O');

        $this->assertInstanceOf(Square::class, $square);
    }

    /**
     * @dataProvider wrongParametersDataProvider
     */
    public function testWrongParameters($column, $row, $errorMessage)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($errorMessage);

        new Square($column, $row);
    }

    public function wrongParametersDataProvider()
    {
        return [
            'wrong row' => [5, 'X', 'No Square has the row'],
            'too many letters in row' => [3, 'DG', 'No Square has the row'],
            'not a letter in row' => [10, '^', 'No Square has the row'],
            'wrong number in column' => [16, 'F', 'No Square has the column'],
        ];
    }
}
