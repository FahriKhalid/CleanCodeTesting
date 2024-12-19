<?php

namespace App\Domain\Inventory\Helpers\Calculator;

use App\Domain\Inventory\Helpers\Calculator\Interfaces\OperationInterface;

class AddCalculation implements OperationInterface
{
    public static function calculate($a, $b): int|string
    {
        return $a + $b;
    }
}
