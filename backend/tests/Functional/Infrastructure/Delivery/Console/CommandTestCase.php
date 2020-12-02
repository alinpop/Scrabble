<?php declare(strict_types=1);

namespace MySelf\Scrabble\Functional\Infrastructure\Delivery\Console;

use MySelf\Scrabble\Infrastructure\Persistence\Games\FileGameRepository;
use MySelf\Scrabble\Infrastructure\Persistence\Players\FilePlayerRepository;
use PHPUnit\Framework\TestCase;

class CommandTestCase extends TestCase
{
    protected static FilePlayerRepository $playerRepository;
    protected static FileGameRepository $gameRepository;

    public static function setUpBeforeClass(): void
    {
        self::$playerRepository = new FilePlayerRepository('TestPlayerRepository');
        self::$gameRepository = new FileGameRepository('TestGameRepository');
    }

    public static function tearDownAfterClass(): void
    {
        self::$playerRepository->dropRepository();
        self::$gameRepository->dropRepository();
    }
}
