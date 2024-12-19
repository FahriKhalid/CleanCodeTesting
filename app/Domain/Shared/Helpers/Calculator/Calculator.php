<?php

namespace App\Domain\Inventory\Services;

use App\Domain\Inventory\Helpers\Calculator\AddCalculation;
use App\Domain\Inventory\Helpers\Calculator\SubtractCalculation;
use App\Domain\Inventory\Helpers\Calculator\MultiplyCalculation;
use App\Domain\Inventory\Helpers\Calculator\DivideCalculation;

class Calculator
{
    public function add($a, $b)
    {
        return AddCalculation::calculate($a, $b);
    }

    public function subtract($a, $b)
    {
        return SubtractCalculation::calculate($a, $b);
    }

    public function multiply($a, $b)
    {
        return MultiplyCalculation::calculate($a, $b);
    }

    public function divide($a, $b)
    {
        return DivideCalculation::calculate($a, $b);
    }
}
