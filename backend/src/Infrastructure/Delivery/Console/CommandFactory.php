<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Delivery\Console;

interface CommandFactory
{
    public function get();
}
