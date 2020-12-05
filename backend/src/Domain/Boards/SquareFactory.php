<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Boards;

class SquareFactory
{
    public static function fromString(string $squareName): Square
    {
        preg_match('/^([A-z])(\d{1,2})$/', $squareName, $squareNameWithRowBeforeColumn);
        preg_match('/^(\d{1,2})([A-z])$/', $squareName, $squareNameWithColumnBeforeRow);

        $columnRowMatch = $squareNameWithRowBeforeColumn ?: $squareNameWithColumnBeforeRow;

        if ($columnRowMatch) {
            $column = is_numeric($columnRowMatch[1]) ? $columnRowMatch[1] : $columnRowMatch[2];
            $row = !is_numeric($columnRowMatch[1]) ? $columnRowMatch[1] : $columnRowMatch[2];

            return new Square((int) $column, $row);
        }

        throw new \InvalidArgumentException("Square name $squareName is wrong");
    }
}
