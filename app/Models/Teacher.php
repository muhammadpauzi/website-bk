<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Teacher extends Model
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
                    ->orWhere('nip', 'LIKE', "%$value%")
                    ->orWhere('email', 'LIKE', "%$value%");
            });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
