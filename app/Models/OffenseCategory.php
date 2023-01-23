<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class OffenseCategory extends Model
{
    use HasFactory, FilterQueryString;

    protected $guarded = ['id'];
    protected $filters = ['search', 'sort'];

    public function search(Builder $query, $value)
    {
        return $query
            ->where('name', 'LIKE', "%$value%")
            ->orWhere('description', 'LIKE', "%$value%")
            ->orWhere('point', 'LIKE', "%$value%");
    }
}
