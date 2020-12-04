<?php

namespace MySelf\Scrabble\Tests\Functional;

trait AssertBoardIsDisplayed
{
    private function assertBoardIsDisplayed($output)
    {
        $this->assertStringContainsString('01 02 03 04 05 06 07 08 09 10 11 12 13 14 15', $output);

        preg_match_all('/\n[A-O]./', $output, $regexResult);
        $this->assertCount(15, $regexResult[0]);
    }
}
