<?php

namespace App\Domain\Inventory\Helpers\Calculator\Interfaces;

interface OperationInterface
{
    public static function calculate($a, $b): int|string;
}
