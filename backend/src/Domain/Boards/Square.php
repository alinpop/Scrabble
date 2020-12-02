<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Boards;

use MySelf\Scrabble\Domain\Boards\SquareBonus\SquareBonus;
use MySelf\Scrabble\Domain\Letters\Letter;

class Square implements \JsonSerializable
{
    private int $column;
    private string $row;

    private ?SquareBonus $bonus;
    private ?Letter $letter = null;

    public function __construct(int $column, string $row, ?SquareBonus $bonus = null)
    {
        $this->setColumn($column);
        $this->setRow($row);
        $this->bonus = $bonus;
    }

    public function addLetter(Letter $letter): void
    {
        $this->letter = $letter;
    }

    public function getLetter(): ?Letter
    {
        return $this->letter;
    }

    /**
     * @param string $row
     */
    private function setRow(string $row): void
    {
        $row = strtoupper($row);

        preg_match('/^[ABCDEFGHIJKLMNO]$/', $row, $result);

        if (!$result) {
            throw new \InvalidArgumentException("No Square has the row [$row]");
        }

        $this->row = $row;
    }

    public function getRow(): string
    {
        return $this->row;
    }

    /**
     * @param int $column
     */
    private function setColumn(int $column): void
    {
        if ($column < 0 || $column > 15) {
            throw new \InvalidArgumentException("No Square has the column [$column]");
        }

        $this->column = $column;
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public function getBonus(): ?SquareBonus
    {
        return $this->bonus;
    }

    public function jsonSerialize(): ?string
    {
        return $this->letter ? null : $this->letter->getLetter();
    }
}
