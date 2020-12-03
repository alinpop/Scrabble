<?php

namespace MySelf\Scrabble\Tests\Unit\Domain\Games;

use MySelf\Scrabble\Domain\Boards\Board;
use MySelf\Scrabble\Domain\Games\Game;
use MySelf\Scrabble\Domain\Letters\LetterBag;
use MySelf\Scrabble\Domain\Players\Player;
use MySelf\Scrabble\Tests\Unit\HelperTestCase;

class GameTest extends HelperTestCase
{
    public function testSetPlayOrderRandomly()
    {
        $game = new Game(
            new Player('test_player'),
            new Board(),
            new LetterBag()
        );

        $game->addPlayer(new Player('test_2_player'));
        $game->addPlayer(new Player('test_3_player'));

        $this->assertEquals('', $this->objectToArray($game)['playOrder']);

        $orders = [];

        $game->setPlayOrder();
        $orders[] = $this->objectToArray($game)['playOrder'];

        $game->setPlayOrder();
        $orders[] = $this->objectToArray($game)['playOrder'];

        $game->setPlayOrder();
        $orders[] = $this->objectToArray($game)['playOrder'];

        $this->assertNotEquals('', $orders[0]);

        $this->assertGreaterThan(1, count(array_unique($orders)));
    }
}
