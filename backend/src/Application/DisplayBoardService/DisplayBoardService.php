<?php declare(strict_types=1);

namespace MySelf\Scrabble\Application\DisplayBoardService;

use MySelf\Scrabble\Domain\Boards\Board;
use MySelf\Scrabble\Domain\Boards\Square;
use MySelf\Scrabble\Domain\Boards\SquareBonus\DoubleValueForLetter;
use MySelf\Scrabble\Domain\Boards\SquareBonus\DoubleValueForWord;
use MySelf\Scrabble\Domain\Boards\SquareBonus\SquareBonus;
use MySelf\Scrabble\Domain\Boards\SquareBonus\TripleValueForLetter;
use MySelf\Scrabble\Domain\Boards\SquareBonus\TripleValueForWord;

class DisplayBoardService
{
    public function run(?Board $board = null): array
    {
        $board = $board ?? new Board();
        $squares = $board->getSquares();

        $data = [];
        foreach ($squares as $squaresOnRows) {
            /** @var Square $square */
            foreach ($squaresOnRows as $square) {
                $squareLetter = $square->getLetter() ? ' ' . $square->getLetter() : ' _';

                if ($squareLetter === ' _' && $square->getBonus() !== null) {
                    $squareLetter = $this->setSquareBonusField($square->getBonus());
                }

                $data[$square->getRow()][sprintf('%02d', $square->getColumn())] = $squareLetter;
            }
        }

        return $data;
    }

    private function setSquareBonusField(SquareBonus $bonus): string
    {
        $string = '_';

        if ($bonus instanceof DoubleValueForLetter) {
            $string = "<info>+</info>";
        }

        if ($bonus instanceof TripleValueForLetter) {
            $string = "<question>+</question>";
        }

        if ($bonus instanceof DoubleValueForWord) {
            $string = "<comment>*</comment>";
        }

        if ($bonus instanceof TripleValueForWord) {
            $string = "<error>*</error>";
        }

        return " $string";
    }
}
