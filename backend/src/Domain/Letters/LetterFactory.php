<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Letters;

class LetterFactory
{
    public static function fromArray(array $array): array
    {
        $letters = [];
        foreach ($array as $letter) {
            $letters[] = new Letter($letter, Letter::MAP[$letter]['value']);
        }

        return $letters;
    }

    public static function fromString(string $string): array
    {
        $string = strtoupper($string);
        $letters = str_split($string);

        return self::fromArray($letters);
    }
}
