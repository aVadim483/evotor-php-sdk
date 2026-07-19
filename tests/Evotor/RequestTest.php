<?php

declare(strict_types=1);

namespace avadim\Evotor;

use avadim\Evotor\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /** @var Request */
    private $request;

    /** @var avadim\Evotor\Client | PHPUnit_Framework_MockObject_MockObject */
    private $client;

    /** @var string */
    private $name;

    /** @var array */
    private $arguments;

    protected function setUp(): void
    {
        $this->client = $this->createMock(\avadim\Evotor\Client::class);
        $this->name = 'post';
        $this->arguments = [];
        $this->request = new Request(
            $this->client,
            $this->name,
            $this->arguments
        );
    }

    public function testFromName()
    {
        $req = Request::fromName($this->client, 'gEt', [], []);
        $this->assertTrue($req instanceof Request);
        $this->assertTrue($req->name === 'get');

        $req = Request::fromName($this->client, 'pOSt', [], []);
        $this->assertTrue($req instanceof Request);
        $this->assertTrue($req->name === 'post');

        $req = Request::fromName($this->client, 'pUt', [], []);
        $this->assertTrue($req instanceof Request);
        $this->assertTrue($req->name === 'put');

        $req = Request::fromName($this->client, 'bulK', [], []);
        $this->assertTrue($req instanceof Request);
        $this->assertTrue($req->name === 'post');
        $this->assertTrue($req->rname === 'bulk');
    }

    public function testRequest()
    {
        $this->markTestSkipped("To be done");
    }
}
