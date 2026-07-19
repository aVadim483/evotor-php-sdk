<?php

declare(strict_types=1);

namespace avadim\Evotor\Operations;

use avadim\Evotor\Exception;
use avadim\Evotor\Operations\ProductsOperations;
use PHPUnit\Framework\TestCase;

class StoresOperationTest extends TestCase
{
    /** @var \avadim\Evotor\Client|\PHPUnit\Framework\MockObject\MockObject */
    private $clnt;

    /** @var StoresOperation */
    private $storesOperation;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\avadim\Evotor\Client::class);
        $this->storesOperation = new StoresOperation(
            $this->clnt,
            'stores',
            [],
            null
        );
    }

    public function test()
    {
        $this->assertTrue($this->storesOperation->run() instanceof Operation);
    }

    public function testId()
    {
        $this->assertTrue($this->storesOperation->id("123") === null);
        $this->assertTrue($this->storesOperation->id() === "123");
    }

    public function testProductsBad()
    {
        $this->expectException(Exception::class);
        $this->storesOperation->products();
    }

    public function testProductsGood()
    {
        $this->storesOperation->id("123");
        $this->assertTrue($this->storesOperation->products() instanceof ProductsOperation);
    }

    public function testDocumentsBad()
    {
        $this->expectException(Exception::class);
        $this->storesOperation->documents();
    }

    public function testDocumentsGood()
    {
        $this->storesOperation->id("123");
        $this->assertTrue($this->storesOperation->documents() instanceof DocumentsOperation);
    }

    public function testGroupsBad()
    {
        $this->expectException(Exception::class);
        $this->storesOperation->groups();
    }

    public function testGroupsGood()
    {
        $this->storesOperation->id("123");
        $this->assertTrue($this->storesOperation->groups() instanceof GroupsOperation);
    }
}
