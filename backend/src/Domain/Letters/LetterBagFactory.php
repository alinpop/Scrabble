<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Letters;

class LetterBagFactory
{
    public function fromArray(array $array): LetterBag
    {
        $letters = [];
        foreach ($array as $letter) {
            $letters[] = new Letter($letter, Letter::MAP[$letter]['value']);
        }

        return new LetterBag(...$letters);
    }

    public function new(): LetterBag
    {
        $letters = [];
        foreach (Letter::MAP as $letter => $letterDetails) {
            $count = Letter::MAP[$letter]['count'];
            while ($count > 0) {
                $letters[] = new Letter($letter, Letter::MAP[$letter]['value']);
                $count--;
            }
        }

        return new LetterBag(...$letters);
    }
}
