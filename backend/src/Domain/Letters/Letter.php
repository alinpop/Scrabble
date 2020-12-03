<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Letters;

class Letter
{
    public const MAP = [
        'A' => ['value' => 1, 'count' => 11],
        'B' => ['value' => 9, 'count' => 2],
        'C' => ['value' => 1, 'count' => 5],
        'D' => ['value' => 2, 'count' => 4],
        'E' => ['value' => 1, 'count' => 9],
        'F' => ['value' => 8, 'count' => 2],
        'G' => ['value' => 9, 'count' => 2],
        'H' => ['value' => 10, 'count' => 1],
        'I' => ['value' => 1, 'count' => 10],
        'J' => ['value' => 10, 'count' => 1],
        'L' => ['value' => 1, 'count' => 4],
        'M' => ['value' => 4, 'count' => 3],
        'N' => ['value' => 1, 'count' => 6],
        'O' => ['value' => 1, 'count' => 5],
        'P' => ['value' => 2, 'count' => 4],
        'R' => ['value' => 1, 'count' => 7],
        'S' => ['value' => 1, 'count' => 5],
        'T' => ['value' => 1, 'count' => 7],
        'U' => ['value' => 1, 'count' => 6],
        'V' => ['value' => 8, 'count' => 2],
        'X' => ['value' => 10, 'count' => 1],
        'Z' => ['value' => 10, 'count' => 1],
        '?' => ['value' => 0, 'count' => 2],
    ];

    private string $letter;
    private int $value;

    public function __construct(string $letter, int $value)
    {
        $this->setLetter($letter);
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function getLetter(): string
    {
        return $this->letter;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param string $letter
     */
    private function setLetter(string $letter): void
    {
        preg_match('/^[A-z?]$/', $letter, $result);

        if (!$result) {
            throw new \InvalidArgumentException('Wrong letter provided, "' . $letter . '"');
        }

        $this->letter = $letter;
    }

    /**
     * @param int $value
     */
    private function setValue(int $value): void
    {
        if ($value < 0 || $value > 10) {
            throw new \InvalidArgumentException(
                'The value of a letter must be between 0 and 10, "' . $value . '" provided'
            );
        }

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->letter ?? '';
    }
}
