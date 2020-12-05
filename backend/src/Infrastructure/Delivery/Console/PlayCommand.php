<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\PlayService\PlayService;
use MySelf\Scrabble\Presentation\Cli\BoardView;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PlayCommand extends Command
{
    protected static $defaultName = 'play';
    private PlayService $playService;
    private BoardView $boardView;

    public function __construct(PlayService $playService, BoardView $boardView)
    {
        parent::__construct();
        $this->playService = $playService;
        $this->boardView = $boardView;
    }

    protected function configure()
    {
        $this->setDescription('Command to place Letters.');

        $this->addArgument('player', InputArgument::REQUIRED, 'The Player who places the Letters');
        $this->addArgument('square', InputArgument::REQUIRED, 'Square position to start from');
        $this->addArgument('direction', InputArgument::REQUIRED, 'Direction to place the Letters');
        $this->addArgument('letters', InputArgument::REQUIRED, 'Direction to place the Letters');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $playerName = $input->getArgument('player');
        $square = $input->getArgument('square');
        $direction = $input->getArgument('direction');
        $letters = $input->getArgument('letters');

        $data = $this->playService->run($playerName, $square, $direction, $letters);

        $output->writeln($this->boardView->get($data['board']));

        return Command::SUCCESS;
    }
}
