<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Games;

use MySelf\Scrabble\Domain\Boards\Board;
use MySelf\Scrabble\Domain\Letters\LetterBag;
use MySelf\Scrabble\Domain\Players\Player;

class Game implements \JsonSerializable
{
    public const STATUS_PREPARING = 'preparing';
    public const STATUS_STARTED = 'started';
    public const STATUS_FINISHED = 'finished';

    private GameId $gameId;

    /** @var Player[]  */
    private array $players = [];
    private Board $board;
    private LetterBag $letterBag;

    private Player $initiator;
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
        $this->initiator = $player;

        $this->gameId = $gameId ?? new GameId(uniqid('', true));
        $this->status = self::STATUS_PREPARING;
    }

    public function getInitiator(): Player
    {
        return $this->initiator;
    }

    public function getGameId(): GameId
    {
        return $this->gameId;
    }

    public function getLetterBag()
    {
        return $this->letterBag;
    }

    public function getStatus(): string
    {
        return $this->status;
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

    public function addPlayer(Player $player)
    {
        $this->players[] = $player;
    }

    public function updateStatus(string $status)
    {
        $statusArrayOrdered = [self::STATUS_PREPARING, self::STATUS_STARTED, self::STATUS_FINISHED];

        if (!in_array($status, $statusArrayOrdered)) {
            throw new \InvalidArgumentException("Game status $status is not correct");
        }

        if (array_search($status, $statusArrayOrdered) < array_search($this->status, $statusArrayOrdered)) {
            throw new \Exception("The status $this->status cannot be transformed to $status");
        }

        $this->status = $status;
    }
}
