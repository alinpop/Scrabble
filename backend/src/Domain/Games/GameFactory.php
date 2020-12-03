<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Games;

use MySelf\Scrabble\Domain\Boards\Board;
use MySelf\Scrabble\Domain\Letters\LetterBagFactory;
use MySelf\Scrabble\Domain\Players\Player;

class GameFactory
{
    public function prepareGame(Player $player)
    {
        return new Game(
            $player,
            new Board(),
            (new LetterBagFactory())->new()
        );
    }

    public function fromArray(array $array): Game
    {
        $initiatorOfTheGame = array_shift($array['players']);

        $game = new Game(
            new Player($initiatorOfTheGame),
            new Board(),
            (new LetterBagFactory())->fromArray($array['letterBag']),
            new GameId($array['gameId'])
        );

        foreach ($array['players'] as $player) {
            $game->addPlayer(new Player($player));
        }

        return $game;
    }

    public function fromJson(string $json): Game
    {
        $array = json_decode($json, true);

        return $this->fromArray($array);
    }
}
