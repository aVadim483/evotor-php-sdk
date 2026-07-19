<?php

declare(strict_types=1);

namespace avadim\Evotor\Operations;

use avadim\Evotor\Exception;
use PHPUnit\Framework\TestCase;

class DocumentsOperationTest extends TestCase
{
    /** @var \avadim\Evotor\Client|\PHPUnit\Framework\MockObject\MockObject */
    private $clnt;

    /** @var DocumentsOperation */
    private $documentsOperation;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\avadim\Evotor\Client::class);
        $this->documentsOperation = new DocumentsOperation(
            $this->clnt,
            'documents',
            [],
            $this->createMock(\avadim\Evotor\Operations\Operation::class)
        );
    }

    public function test()
    {
        $this->assertTrue($this->documentsOperation->run() instanceof Operation);
    }

    public function testException()
    {
        $this->expectException(Exception::class);
        $this->documentsOperation = new DocumentsOperation(
            $this->clnt,
            'documents',
            [],
            null
        );
        $this->documentsOperation->run();
    }
}
