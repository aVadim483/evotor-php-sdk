<?php

declare(strict_types=1);

namespace avadim\Evotor\Operations;

use PHPUnit\Framework\TestCase;

class EmployeesOperationTest extends TestCase
{
    /** @var \avadim\Evotor\Client|\PHPUnit\Framework\MockObject\MockObject */
    private $clnt;

    /** @var EmployeesOperation */
    private $employeesOperation;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\avadim\Evotor\Client::class);
        $this->employeesOperation = new EmployeesOperation(
            $this->clnt,
            'employees',
            [],
            null
        );
    }

    public function test()
    {
        $this->assertTrue($this->employeesOperation->run() instanceof Operation);
    }
}
