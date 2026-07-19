<?php

declare(strict_types=1);

namespace avadim\Evotor\Operations;

use PHPUnit\Framework\TestCase;

class DevicesOperationTest extends TestCase
{
    /** @var \avadim\Evotor\Client|\PHPUnit\Framework\MockObject\MockObject */
    private $clnt;

    /** @var DevicesOperation */
    private $devicesOperation;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\avadim\Evotor\Client::class);
        $this->devicesOperation = new DevicesOperation(
            $this->clnt,
            'devices',
            [],
            null
        );
    }

    public function test()
    {
        $this->assertTrue($this->devicesOperation->run() instanceof Operation);
    }
}
