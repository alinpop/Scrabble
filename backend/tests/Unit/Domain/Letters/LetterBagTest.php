<?php

namespace MySelf\Scrabble\Tests\Unit\Domain\Letters;

use MySelf\Scrabble\Domain\Letters\Letter;
use MySelf\Scrabble\Domain\Letters\LetterBag;
use MySelf\Scrabble\Domain\Letters\RandomArrayKeys;
use PHPUnit\Framework\TestCase;

class LetterBagTest extends TestCase
{
    public function testCount()
    {
        $bag = new LetterBag(
            $this->createMock(RandomArrayKeys::class),
            new Letter('A', 1),
            new Letter('M', 4)
        );

        $this->assertCount(2, $bag);
    }

    public function testExtractingLetter()
    {
        $bag = new LetterBag(
            new RandomArrayKeys(),
            new Letter('A', 1),
            new Letter('M', 4),
            new Letter('N', 1),
            new Letter('R', 1)
        );

        $bag->extractRandomLetters(1);
        $this->assertCount(3, $bag);
    }

    public function testAddingLetter()
    {
        $bag = new LetterBag(
            $this->createMock(RandomArrayKeys::class),
            new Letter('A', 1),
            new Letter('T', 1)
        );

        $bag->addLetters(new Letter('J', 10));
        $this->assertCount(3, $bag);

        $bag->addLetters(
            new Letter('A', 1),
            new Letter('A', 1)
        );
        $this->assertCount(5, $bag);
    }

    public function testExtractingRandomLetters()
    {
        $randomArrayKeys = $this->createMock(RandomArrayKeys::class);
        $randomArrayKeys->method('get')->willReturn(1);

        $bag = new LetterBag(
            $randomArrayKeys,
            new Letter('A', 1),
            new Letter('M', 4),
            new Letter('N', 1),
            new Letter('R', 1)
        );

        $result = $bag->extractRandomLetters(1);
        $bag->addLetters(...$result);
        $anotherResult = $bag->extractRandomLetters(1);
        $bag->addLetters(...$result);
        $andAnotherResult = $bag->extractRandomLetters(1);

        $random = ($result !== $anotherResult) || ($result !== $andAnotherResult) || ($anotherResult !== $andAnotherResult);

        $this->assertTrue($random);
    }
}
