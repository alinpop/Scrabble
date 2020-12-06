<?php declare(strict_types=1);

namespace MySelf\Scrabble\Domain\Letters;

class RandomArrayKeys
{
    public function get(array $array, int $count)
    {
        return array_rand($array, $count);
    }
}
