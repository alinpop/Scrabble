<?php

namespace MySelf\Scrabble\Tests\Unit\Domain\Letters;

use MySelf\Scrabble\Domain\Letters\Letter;
use PHPUnit\Framework\TestCase;

class LetterTest extends TestCase
{
    public function testInstance()
    {
        $letter = new Letter('A', 5);
        $this->assertInstanceOf(Letter::class, $letter);

        $letter = new Letter('?', 0);
        $this->assertInstanceOf(Letter::class, $letter);

    }

    /**
     * @dataProvider letterValidationDataProvider
     */
    public function testLetterValidation($letter, $value)
    {
        $this->expectException(\InvalidArgumentException::class);

        new Letter($letter, $value);
    }

    public function letterValidationDataProvider()
    {
        return [
            'wrong number of letters' => ['Ab', 5],
            'wrong character' => ['$', 5],
            'value bellow 0' => ['?', -3],
            'value over 10' => ['?', 11],
        ];
    }
}
