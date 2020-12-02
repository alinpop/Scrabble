<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\PrepareGameService\PrepareGameService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrepareGameCommand extends Command
{
    protected static $defaultName = 'prepareGame';
    private PrepareGameService $prepareGameService;

    public function __construct(PrepareGameService $prepareGameService)
    {
        parent::__construct();

        $this->prepareGameService = $prepareGameService;
    }

    protected function configure()
    {
        $this->addArgument('player', InputArgument::REQUIRED, 'The player who prepares the game');

        $this->setDescription('Command to prepare the Game.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $playerName = $input->getArgument('player');

        $gameId = $this->prepareGameService->run($playerName);

        $output->writeln("Game is prepared.");
        $output->writeln("Game ID: $gameId");
        $output->writeln("You need to add at least one Player to start the Game.");

        return Command::SUCCESS;
    }
}
