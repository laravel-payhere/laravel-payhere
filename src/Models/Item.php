<?php

namespace LaravelPayHere\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelPayHere\Database\Factories\ItemFactory;

class Item extends Model
{
    protected $guarded = [];

    protected $table = 'payhere_items';

    public static function factory(): ItemFactory
    {
        return new ItemFactory;
    }
}
