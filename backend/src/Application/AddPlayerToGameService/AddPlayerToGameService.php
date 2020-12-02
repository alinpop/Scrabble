<?php declare(strict_types=1);

namespace MySelf\Scrabble\Application\AddPlayerToGameService;

use MySelf\Scrabble\Application\ApplicationService;
use MySelf\Scrabble\Domain\Games\GameRepository;
use MySelf\Scrabble\Domain\Players\PlayerRepository;

class AddPlayerToGameService implements ApplicationService
{
    private PlayerRepository $playerRepository;
    private GameRepository $gameRepository;

    public function __construct(PlayerRepository $playerRepository, GameRepository $gameRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->gameRepository = $gameRepository;
    }

    public function run()
    {
        // TODO: Implement run() method.
    }
}
