<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Tindakan extends Model
{
    use HasFactory, FilterQueryString;

    protected $guarded = ['id'];
    protected $filters = ['search', 'sort'];

    public function search(Builder $query, $value)
    {
        return $query
            ->when($value, function ($query_) use ($value) {
                $query_
                    ->where('name', 'LIKE', "%$value%")
                    ->orWhere('description', 'LIKE', "%$value%")
                    ->orWhere('min_point', 'LIKE', "%$value%")
                    ->orWhere('max_point', 'LIKE', "%$value%");
            });
    }
}
