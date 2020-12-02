<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Persistence\Players;

use MySelf\Scrabble\Domain\Players\Player;
use MySelf\Scrabble\Domain\Players\PlayerRepository;
use MySelf\Scrabble\Infrastructure\Persistence\FileRepository;

class FilePlayerRepository extends FileRepository implements PlayerRepository
{
    protected string $fileName = 'PlayerRepository';

    public function save(Player $player): void
    {
        $result = file_put_contents(
            $this->repositoryFile,
            $player->getName() . "\n",
            FILE_APPEND
        );

        if ($result === false) {
            throw new \Exception('Could not save player to the database');
        }
    }

    public function getPlayer(string $playerName): Player
    {
        foreach ($this->readData() as $data) {
            if ($data && $data[0] === $playerName) {
                return new Player($playerName);
            }
        }

        throw new \Exception("Player '$playerName' not found");
    }
}
