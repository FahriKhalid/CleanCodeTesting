<?php

namespace App\Domain\Warehouse\Services;

use App\Domain\Warehouse\Models\Warehouse;
use Illuminate\Support\Facades\Request;

class CreateWarehouse
{
    public function execute(array $data): Warehouse
    {
        $new = new Warehouse();
        $new->name  = $data['name'];
        $new->save();

        return $new;
    }
}
