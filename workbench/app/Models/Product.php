<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Workbench\Database\Factories\ProductFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lines(): MorphMany
    {
        return $this->morphMany(OrderLine::class, 'purchasable');
    }

    protected static function newFactory(): ProductFactory
    {
        return new ProductFactory;
    }
}
