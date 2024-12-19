<?php

namespace App\Domain\Warehouse\Models;

use Database\Factories\WarehouseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return WarehouseFactory::new();
    }
}
