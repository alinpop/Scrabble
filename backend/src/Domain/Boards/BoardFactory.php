<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Boards;

class BoardFactory
{
    public static function fromArray($array): Board
    {
        $board = new Board();

        foreach($array as $rowIndex => $rowArray) {
            foreach ($rowArray as $columnIndex => $letter) {
                if ($letter !== null) {
                    $board->addLetterByIndexes($rowIndex, $columnIndex, $letter);
                }
            }
        }

        return $board;
    }
}
