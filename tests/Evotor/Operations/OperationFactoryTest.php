<?php

declare(strict_types=1);

namespace avadim\Evotor\Operations;

use avadim\Evotor\Operations\OperationFactory;
use avadim\Evotor\Exception;
use avadim\Evotor\Operations\Operation;
use PHPUnit\Framework\TestCase;

class OperationFactoryTest extends TestCase
{
    /** @var OperationFactory */
    private $clnt = null;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\avadim\Evotor\Client::class);
    }

    public function testFromNameBad()
    {
        $this->expectException(Exception::class);
        OperationFactory::fromName($this->clnt, '_nonexistent_', []);
    }

    public function testFromNameGood()
    {
        $this->assertTrue(OperationFactory::fromName($this->clnt, 'stores', []) instanceof Operation);
    }
}
