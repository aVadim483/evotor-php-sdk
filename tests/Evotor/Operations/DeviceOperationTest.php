<?php

declare(strict_types=1);

namespace avadim\Evotor\Operations;

use avadim\Evotor\Exception;
use PHPUnit\Framework\TestCase;

class DeviceOperationTest extends TestCase
{
    /** @var \avadim\Evotor\Client|\PHPUnit\Framework\MockObject\MockObject */
    private $clnt;

    /** @var DeviceOperation */
    private $deviceOperation;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\avadim\Evotor\Client::class);
        $this->deviceOperation = new DeviceOperation(
            $this->clnt,
            'device',
            [123],
            $this->createMock(\avadim\Evotor\Operations\StoresOperation::class)
        );
    }

    public function test()
    {
        $this->assertTrue($this->deviceOperation->run() instanceof Operation);
    }

    public function testException()
    {
        $this->expectException(Exception::class);
        $this->deviceOperation = new DeviceOperation(
            $this->clnt,
            'groups',
            [123],
            null
        );
        $this->deviceOperation->run();
    }

    public function testException2()
    {
        $this->expectException(Exception::class);
        $this->deviceOperation = new DeviceOperation(
            $this->clnt,
            'groups',
            [123],
            $this->createMock(\avadim\Evotor\Operations\Operation::class)
        );
        $this->deviceOperation->run();
    }

    public function testException3()
    {
        $this->expectException(Exception::class);
        $this->deviceOperation = new DeviceOperation(
            $this->clnt,
            'groups',
            [],
            $this->createMock(\avadim\Evotor\Operations\StoresOperation::class)
        );
        $this->deviceOperation->run();
    }
}
