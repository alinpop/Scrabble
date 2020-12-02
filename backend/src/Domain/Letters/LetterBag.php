<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Letters;

class LetterBag implements \Countable, \JsonSerializable
{
    /**
     * @var Letter[]
     */
    private array $letters;

    public function __construct(Letter ...$letters)
    {
        $this->letters = $letters;
    }

    public function getLetters()
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

        $randomKeys = array_rand($this->letters, $number);
        foreach ((array) $randomKeys as $key) {
            $letters[] = $this->letters[$key];
            unset($this->letters[$key]);
        }

        return $letters;
    }

    public function jsonSerialize()
    {
        $letters = [];
        foreach ($this->letters as $letter) {
            $letters[] = $letter->getLetter();
        }

        return $letters;
    }
}
