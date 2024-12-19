<?php

namespace App\Domain\Inventory\Helpers\Calculator;

use App\Domain\Inventory\Helpers\Calculator\Interfaces\OperationInterface;

class DivideCalculation implements OperationInterface
{
    public static function calculate($a, $b): int|string
    {
        if ($b === 0) {
            return 'Infinity';
        }

        return $a / $b;
    }
}
