<?php

namespace MySelf\Scrabble\Unit\Domain\Letters;

use MySelf\Scrabble\Domain\Letters\Letter;
use MySelf\Scrabble\Domain\Letters\LetterBag;
use MySelf\Scrabble\Domain\Letters\LetterBagFactory;
use PHPUnit\Framework\TestCase;

class LetterBagFactoryTest extends TestCase
{
    private LetterBagFactory $bagFactory;

    public function  setUp(): void
    {
        $this->bagFactory = new LetterBagFactory();
    }

    public function testNewBag()
    {
        $bag = $this->bagFactory->new();

        $this->assertInstanceOf(LetterBag::class, $bag);
        $this->assertCount(100, $bag);
    }

    public function testBagFromArray()
    {
        $bag = $this->bagFactory->fromArray(['A', 'B', 'P']);

        $this->assertInstanceOf(LetterBag::class, $bag);

        foreach ($bag->getLetters() as $letter) {
            $this->assertEquals(Letter::MAP[$letter->getLetter()]['value'], $letter->getValue());
        }
    }
}
