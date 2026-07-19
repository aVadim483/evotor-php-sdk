<?php

namespace avadim\Evotor\Operations;

use avadim\Evotor\Client;

interface OperationInterface
{
    public function __construct(Client $client, string $name, array $arguments);
    public function run();
}
