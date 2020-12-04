<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Boards;

use MySelf\Scrabble\Domain\Boards\SquareBonus\DoubleValueForLetter;
use MySelf\Scrabble\Domain\Boards\SquareBonus\DoubleValueForWord;
use MySelf\Scrabble\Domain\Boards\SquareBonus\SquareBonus;
use MySelf\Scrabble\Domain\Boards\SquareBonus\TripleValueForLetter;
use MySelf\Scrabble\Domain\Boards\SquareBonus\TripleValueForWord;

class Board implements \JsonSerializable
{
    /**
     * @var array
     */
    private $squares = [];

    public function __construct()
    {
        $this->startBoard();
    }

    /**
     * @return Square[]
     */
    public function getSquares(): array
    {
        return $this->squares;
    }

    private function startBoard()
    {
        $columns = range(1, 15);
        $rows = range('A', 'O');

        foreach ($rows as $keyRow => $row) {
            foreach ($columns as $keyColumn => $column) {
                $bonus = $this->getSquareBonus($column, $row);

                $this->squares[$keyRow][$keyColumn] = new Square($column, $row, $bonus);
            }
        }
    }

    private function getSquareBonus(int $column, string $row): ?SquareBonus
    {
        if (in_array($column . $row, ['1A', '8A', '15A', '1O', '8O', '15O', '1H', '15H'])) {
            return new TripleValueForWord();
        }

        if (in_array($column . $row, [
            '2B', '3C', '4D', '5E',
            '2N', '3M', '4L', '5K',
            '11E', '12D', '13C', '14A',
            '11K', '12L', '13M', '14N',
            '8H',
        ])) {
            return new DoubleValueForWord();
        }

        if (in_array($column . $row, [
            '2F', '2J',
            '6B', '6F', '6J', '6N',
            '10B', '10F', '10J', '10N',
            '14F', '14J',
        ])) {
            return new TripleValueForLetter();
        }

        if (in_array($column . $row, [
            '1D', '1L',
            '8D', '8L',
            '15D', '15L',
            '3G', '3I',
            '13G', '13I',
            '4A', '4H', '4O',
            '12A', '12H', '12O',
            '7C', '7G', '7I', '7M',
            '9C', '9G', '9I', '9M',
        ])) {
            return new DoubleValueForLetter();
        }

        return null;
    }

    public function jsonSerialize(): array
    {
        return json_decode(json_encode($this->squares), true);
    }
}
