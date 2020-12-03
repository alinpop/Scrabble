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
    private string $playOrder = '';
    private array $playerLetters = [];

    public function __construct(
        Player $initiator,
        Board $board,
        LetterBag $letterBag,
        ?array $players = null,
        ?string $status = null,
        ?array $playerLetters = [],
        ?GameId $gameId = null
    ) {
        $this->initiator = $initiator;
        $this->board = $board;
        $this->letterBag = $letterBag;

        $this->players = $players ?: [$initiator];

        $this->status = $status ?? self::STATUS_PREPARING;

        $this->playerLetters = $playerLetters ?? [];

        $this->gameId = $gameId ?? new GameId(uniqid('', true));
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

    public function addPlayer(Player $player)
    {
        $this->players[] = $player;
    }

    public function setPlayOrder()
    {
        shuffle($this->players);

        $this->playOrder = implode(',', $this->players);
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

    public function start()
    {
        foreach ($this->players as $player) {
            $this->playerLetters[$player->getName()] = $this->letterBag->extractRandomLetters(7);
        }

        $this->setPlayOrder();

        $this->updateStatus(self::STATUS_STARTED);
    }

    public function jsonSerialize(): array
    {
        $players = [];
        foreach ($this->players as $player) {
            $players[] = $player->getName();
        }

        $playerLetters = $this->playerLetters;
        foreach ($playerLetters as $playerName => $letters) {
            $playerLetters[$playerName] = array_map(
                function($letter) {
                    return $letter->getLetter();
                }, $letters);
        }

        return [
            'gameId' => $this->gameId->getId(),
            'status' => $this->status,
            'players' => $players,
            'playOrder' => $this->playOrder,
            'board' => [],
            'playerLetters' => $playerLetters,
            'letterBag' => $this->letterBag,
        ];
    }
}
