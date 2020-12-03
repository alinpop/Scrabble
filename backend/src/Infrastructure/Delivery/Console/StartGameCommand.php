<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\StartGameService\StartGameService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartGameCommand extends Command
{
    protected static $defaultName = 'startGame';
    private StartGameService $startGameService;

    public function __construct(StartGameService $startGameService)
    {
        parent::__construct();
        $this->startGameService = $startGameService;
    }

    protected function configure()
    {
        $this->addArgument('player', InputArgument::REQUIRED, 'The player who starts the game');

        $this->setDescription('Command to start the Game.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $playerName = $input->getArgument('player');

        $this->startGameService->run($playerName);

        return Command::SUCCESS;
    }
}
