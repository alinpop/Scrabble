<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Games;

use MySelf\Scrabble\Domain\Boards\Board;
use MySelf\Scrabble\Domain\Letters\LetterBagFactory;
use MySelf\Scrabble\Domain\Letters\LetterFactory;
use MySelf\Scrabble\Domain\Players\Player;
use MySelf\Scrabble\Domain\Players\PlayerFactory;

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

    public function fromArray(array $array, ?string $initiator = null): Game
    {
        $initiatorOfTheGame = $initiator ?? $array['players'][0];

        $letterFactory = new LetterFactory();
        foreach ($array['playerLetters'] as &$letters) {
            $letters = $letterFactory->fromArray($letters);
        }

        $game = new Game(
            new Player($initiatorOfTheGame),
            new Board(),
            (new LetterBagFactory())->fromArray($array['letterBag']),
            (new PlayerFactory())->fromCollection($array['players']),
            $array['status'],
            $array['playerToMove'] ? new Player($array['playerToMove']) : null,
            $array['playerLetters'],
            $array['playOrder'],
            new GameId($array['gameId'])
        );

        return $game;
    }

    public function fromJson(string $json, ?string $initiator = null): Game
    {
        $array = json_decode($json, true);

        return $this->fromArray($array, $initiator);
    }
}
