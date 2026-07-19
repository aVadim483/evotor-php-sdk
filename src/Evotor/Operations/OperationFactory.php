<?php

namespace avadim\Evotor\Operations;

use avadim\Evotor\Client;
use avadim\Evotor\Exception;
use avadim\Evotor\Operations\Operation;

class OperationFactory
{
    public static function fromName(Client $client, string $name, array $arguments, ?Operation $op = null)
    {
        $cls = 'avadim\\Evotor\\Operations\\'.ucfirst($name).'Operation';
        if ($name && class_exists($cls)) {
            return new $cls($client, $name, $arguments, $op);
        }
        throw new Exception('Unable to find method '.$name.' of class '.ucfirst($name).'Operation');
    }
}
