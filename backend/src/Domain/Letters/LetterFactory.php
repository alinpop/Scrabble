<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Letters;

class LetterFactory
{
    public function fromArray(array $array): array
    {
        $letters = [];
        foreach ($array as $letter) {
            $letters[] = new Letter($letter, Letter::MAP[$letter]['value']);
        }

        return $letters;
    }
}
