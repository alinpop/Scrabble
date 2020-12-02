<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Games;

use MySelf\Scrabble\Domain\Boards\Board;
use MySelf\Scrabble\Domain\Letters\LetterBag;
use MySelf\Scrabble\Domain\Players\Player;

class Game implements \JsonSerializable
{
    public const STATUS_STARTED = 'started';
    public const STATUS_FINISHED = 'finished';

    private GameId $gameId;

    /** @var Player[]  */
    private array $players = [];
    private Board $board;
    private LetterBag $letterBag;

    private Player $initiatior;
    private string $status;

    public function __construct(
        Player $player,
        Board $board,
        LetterBag $letterBag,
        ?GameId $gameId = null
    ) {
        $this->players[] = $player;
        $this->board = $board;
        $this->letterBag = $letterBag;
        $this->initiatior = $player;

        $this->gameId = $gameId ?? new GameId(uniqid('', true));
        $this->status = self::STATUS_STARTED;
    }

    public function getInitiator(): Player
    {
        return $this->initiatior;
    }

    public function getGameId(): GameId
    {
        return $this->gameId;
    }

    public function getLetterBag()
    {
        return $this->letterBag;
    }

    public function jsonSerialize(): array
    {
        $players = [];
        foreach ($this->players as $player) {
            $players[] = $player->getName();
        }

        return [
            'gameId' => $this->gameId->getId(),
            'status' => $this->status,
            'players' => $players,
            'board' => [],
            'letterBag' => $this->letterBag,
        ];
    }
}
