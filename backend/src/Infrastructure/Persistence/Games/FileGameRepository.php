<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Persistence\Games;

use MySelf\Scrabble\Domain\Games\Game;
use MySelf\Scrabble\Domain\Games\GameFactory;
use MySelf\Scrabble\Domain\Games\GameId;
use MySelf\Scrabble\Domain\Games\GameRepository;
use MySelf\Scrabble\Domain\Players\Player;
use MySelf\Scrabble\Infrastructure\Persistence\FileRepository;

class FileGameRepository extends FileRepository implements GameRepository
{
    protected string $fileName = 'GameRepository';
    protected string $delimiter = "\t";

    public function save(Game $game): GameId
    {
        $data = $game->getInitiator()->getName() . "\t" .
            $game->getGameId()->getId() . "\t" .
            json_encode($game);

        $result = file_put_contents($this->repositoryFile, $data . "\n", FILE_APPEND);

        if ($result === false) {
            throw new \Exception('Could not save Game to the database');
        }

        return $game->getGameId();
    }

    public function getPlayerGame(Player $player): Game
    {
        $result = null;

        foreach ($this->readData() as $data) {
            if (!$data) {
                continue;
            }

            $gameArray = json_decode($data[2], true);

            $playerInTheGame = in_array($player->getName(), $gameArray['players']);
            $statusStarted = $gameArray['status'] !== Game::STATUS_FINISHED;
            if ($playerInTheGame && $statusStarted) {
                $result = $data;
            }
        }

        if ($result) {
            return (new GameFactory())->fromJson($result[2]);
        }

        throw new \Exception('No Game started');
    }
}
