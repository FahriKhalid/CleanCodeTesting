<?php

namespace App\Domain\Inventory\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'product_id' => 'integer',
        'warehouse_id' => 'integer',
    ];

    public function scopeProductId(Builder $query, int $product_id): void
    {
        $query->where('product_id', $product_id);
    }

    public function scopeWarehouseId(Builder $query, int $warehouse_id): void
    {
        $query->where('warehouse_id', $warehouse_id);
    }

    public function scopeQuantityAvailable(Builder $query): void
    {
        $query->where('quantity', '!=', 0);
    }
}
