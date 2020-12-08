<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\BoardService\BoardService;
use MySelf\Scrabble\Application\DisplayBoardService\DisplayBoardService;
use MySelf\Scrabble\Presentation\Cli\BoardView;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DisplayBoardCommand extends Command
{
    protected static $defaultName = 'display';
    private BoardView $boardView;
    private DisplayBoardService $displayBoardService;
    private BoardService $boardService;

    public function __construct(BoardService $boardService, DisplayBoardService $displayBoardService, BoardView $boardView)
    {
        parent::__construct();

        $this->boardService = $boardService;
        $this->displayBoardService = $displayBoardService;
        $this->boardView = $boardView;
    }

    protected function configure()
    {
        $this->setDescription('Command to output the board in CLI.');

        $this->addArgument('player', InputArgument::REQUIRED, 'One of the players that play');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $playerName = $input->getArgument('player');

        $board = $this->boardService->run($playerName)['board'];

        $boardArray = $this->displayBoardService->run($board);

        $output->writeln($this->boardView->get($boardArray));

        return Command::SUCCESS;
    }
}
