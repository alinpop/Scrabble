<?php declare(strict_types=1);

namespace MySelf\Scrabble\Tests\Unit\Domain\Boards;

use Monolog\Test\TestCase;
use MySelf\Scrabble\Domain\Boards\Square;
use MySelf\Scrabble\Domain\Boards\SquareFactory;

class SquareFactoryTest extends TestCase
{
    private SquareFactory $factory;

    public function setUp(): void
    {
        $this->factory = new SquareFactory();
    }

    public function testFromString()
    {
        $this->assertInstanceOf(Square::class, $this->factory->fromString('8H'));
        $this->assertInstanceOf(Square::class, $this->factory->fromString('H8'));
    }

    /**
     * @dataProvider valuesAreCorrectDataProvider
     */
    public function testValuesAreCorrect(string $string, string $expectedColumn, string $expectedRow)
    {
        $square = $this->factory->fromString($string);

        $this->assertEquals($expectedColumn, $square->getColumn());
        $this->assertEquals($expectedRow, $square->getRow());
    }

    public function valuesAreCorrectDataProvider()
    {
        return [
            'simple square name' => ['F4', '4', 'F'],
            'long square name' => ['11H', '11', 'H'],
        ];
    }

    public function testWithWrongSquareName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->factory->fromString("AG5");
    }
}
