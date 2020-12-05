<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Application\StartGameService\StartGameService;
use MySelf\Scrabble\Presentation\Cli\BoardView;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartGameCommand extends Command
{
    protected static $defaultName = 'startGame';
    private StartGameService $startGameService;
    private BoardView $boardView;

    public function __construct(StartGameService $startGameService, BoardView $boardView)
    {
        parent::__construct();
        $this->startGameService = $startGameService;
        $this->boardView = $boardView;
    }

    protected function configure()
    {
        $this->addArgument('player', InputArgument::REQUIRED, 'The player who starts the game');

        $this->setDescription('Command to start the Game.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $playerName = $input->getArgument('player');

        $board = $this->startGameService->run($playerName);

        $output->writeln($this->boardView->get($board));

        /** @todo Output the players and their scores. Output the player who will move. */
        /** @todo Validate which player will move further. */

        return Command::SUCCESS;
    }
}
