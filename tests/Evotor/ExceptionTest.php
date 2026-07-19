<?php

declare(strict_types=1);

namespace avadim\Evotor;

use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    /** @var Exception */
    private $exception;

    protected function setUp(): void
    {
        $this->exception = new Exception();
    }

    public function testMissing()
    {
        $this->assertTrue($this->exception instanceof \avadim\Evotor\Exception);
    }
}
