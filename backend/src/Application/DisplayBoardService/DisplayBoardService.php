<?php declare(strict_types=1);

namespace MySelf\Scrabble\Application\DisplayBoardService;

use MySelf\Scrabble\Domain\Boards\Board;
use MySelf\Scrabble\Domain\Boards\Square;

class DisplayBoardService
{
    /** @var Board */
    private Board $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function run()
    {
        $squares = $this->board->getSquares();

        $data = [];
        foreach ($squares as $squaresOnRows)
        {
            /** @var Square $square */
            foreach ($squaresOnRows as $square) {
                $squareLetter = $square->getLetter() ? ' ' . $square->getLetter() : ' _';

                if ($squareLetter === ' _' && $square->getBonus() !== null) {
                    $squareLetter = ' %';
                }

                $data[$square->getRow()][sprintf('%02d', $square->getColumn())] = $squareLetter;
            }
        }

        return $data;
    }
}
