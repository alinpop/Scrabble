<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\AddPlayerToGameService\AddPlayerToGameService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddPlayerToGameCommand extends Command
{
    protected static $defaultName = 'addPlayer';
    private AddPlayerToGameService $addPlayerToGameService;

    public function __construct(AddPlayerToGameService $addPlayerToGameService)
    {
        parent::__construct();

        $this->addPlayerToGameService = $addPlayerToGameService;
    }

    protected function configure()
    {
        $this->addArgument('player', InputArgument::REQUIRED, 'The player who does the command.');
        $this->addArgument('gameId', InputArgument::REQUIRED, 'The ID of the Game');
        $this->addArgument('newPlayer', InputArgument::REQUIRED, 'The player that is added');

        $this->setDescription('Command to add Player to Game.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $player = $input->getArgument('player');
        $gameId = $input->getArgument('gameId');
        $newPlayer = $input->getArgument('newPlayer');

        return Command::SUCCESS;
    }
}
