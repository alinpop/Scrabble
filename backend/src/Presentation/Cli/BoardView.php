<?php declare(strict_types=1);

namespace MySelf\Scrabble\Presentation\Cli;

class BoardView
{
    public function get($boardArray)
    {
        $view = '';
        
        $view .= "\n0. ";
        $view .= implode(' ', array_keys(current($boardArray)));
        $view .= "\n";

        foreach ($boardArray as $rows => $squares) {
            $view .= "$rows. ";
            $view .= implode(' ', $squares);
            $view .= "\n";
        }

        return $view;
    }
}
