<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\DisplayBoardService\DisplayBoardService;
use MySelf\Scrabble\Presentation\Cli\BoardView;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DisplayBoardCommand extends Command
{
    protected static $defaultName = 'display';
    private BoardView $boardView;
    private DisplayBoardService $boardService;

    public function __construct(DisplayBoardService $boardService, BoardView $boardView)
    {
        parent::__construct();

        $this->boardService = $boardService;
        $this->boardView = $boardView;
    }

    protected function configure()
    {
        $this->setDescription('Command to output the board in CLI.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $boardArray = $this->boardService->run();

        $output->writeln($this->boardView->get($boardArray));

        return Command::SUCCESS;
    }
}
