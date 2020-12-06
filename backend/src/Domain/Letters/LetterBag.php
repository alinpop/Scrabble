<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Letters;

class LetterBag implements \Countable, \JsonSerializable
{
    /** @var Letter[] */
    private array $letters;
    private RandomArrayKeys $randomArrayKey;

    public function __construct(RandomArrayKeys $randomArrayKey, Letter ...$letters)
    {
        $this->letters = $letters;
        $this->randomArrayKey = $randomArrayKey;
    }

    public function getLetters(): array
    {
        return $this->letters;
    }

    public function addLetters(Letter ...$letters): void
    {
        $this->letters = array_merge($this->letters, (array)$letters);
    }

    public function count(): int
    {
        return count($this->letters);
    }

    public function extractRandomLetters(int $number): array
    {
        $letters = [];

        if ($number >= $this->count()) {
            $letters = $this->letters;

            $this->letters = [];
        }

        $randomKeys = $this->randomArrayKey->get($this->letters, $number);
        foreach ((array) $randomKeys as $key) {
            $letters[] = $this->letters[$key];
            $this->letters[$key] = null;
        }

        $this->letters = array_values(array_filter($this->letters));

        return $letters;
    }

    public function jsonSerialize(): array
    {
        $letters = [];
        foreach ($this->letters as $letter) {
            $letters[] = $letter->getLetter();
        }

        return $letters;
    }
}
