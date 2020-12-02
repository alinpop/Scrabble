<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\CreatePlayerService\CreatePlayerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreatePlayerCommand extends Command
{
    protected static $defaultName = 'createPlayer';
    private CreatePlayerService $createPlayerService;

    public function __construct(CreatePlayerService $createPlayerService)
    {
        parent::__construct();
        $this->createPlayerService = $createPlayerService;
    }

    protected function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Nickname of player');

        $this->setDescription('Command to create new Player.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $playerName = $input->getArgument('name');

        $this->createPlayerService->run($playerName);

        $output->writeln("Player {$playerName} created.");

        return Command::SUCCESS;
    }
}
