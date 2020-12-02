<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Boards;

use MySelf\Scrabble\Domain\Boards\SquareBonus\DoubleValueForWord;
use MySelf\Scrabble\Domain\Boards\SquareBonus\SquareBonus;
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
        if (in_array($column . $row, ['1A', '8A', '15A', '1O', '8O', '15O'])) {
            return new TripleValueForWord();
        }

        if (in_array($column . $row, [
            '2B', '2N', '3C', '3M'
        ])) {
            return new DoubleValueForWord();
        }

        return null;
    }

    public function jsonSerialize(): array
    {
        return json_decode(json_encode($this->squares), true);
    }
}
