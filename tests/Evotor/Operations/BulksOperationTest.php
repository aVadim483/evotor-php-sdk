<?php

declare(strict_types=1);

namespace avadim\Evotor\Operations;

use avadim\Evotor\Operations\Operation;
use avadim\Evotor\Response;
use PHPUnit\Framework\TestCase;

class BulksOperationTest extends TestCase
{
    /** @var \avadim\Evotor\Client|\PHPUnit\Framework\MockObject\MockObject */
    private $clnt;

    /** @var BulksOperation */
    private $bulksOperation;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\avadim\Evotor\Client::class);
        $this->bulksOperation = new BulksOperation(
            $this->clnt,
            'bulks',
            [],
            null
        );
    }

    public function test()
    {
        $this->assertTrue($this->bulksOperation->run() instanceof Operation);
    }
}
