<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Players;

class Player
{
    private string $name;

    public function __construct(string $name)
    {
        if (!$this->isValid($name)) {
            throw new \InvalidArgumentException("The name is invalid");
        }

        if (strlen($name) < 4) {
            throw new \InvalidArgumentException("The name needs to have at least 4 characters");
        }

        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function isValid($name)
    {
        preg_match('/^[A-z0-9_.-]+$/', $name, $regexResult);

        return count($regexResult);
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
