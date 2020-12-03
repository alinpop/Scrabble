<?php declare(strict_types=1);

namespace MySelf\Scrabble\Tests\Unit;

use PHPUnit\Framework\TestCase;

class HelperTestCase extends TestCase
{
    public function objectToArray($object): array
    {
        return json_decode(json_encode($object), true);
    }
}
