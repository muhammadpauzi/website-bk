<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class _Parent extends Model
{
    use HasFactory, FilterQueryString;

    protected $table = 'parents';
    protected $guarded = ['id'];
    protected $filters = ['search', 'sort'];

    public function search(Builder $query, $value)
    {
        return $query
            ->where('name', 'LIKE', "%$value%")
            ->orWhere('alamat', 'LIKE', "%$value%")
            ->orWhere('phone', 'LIKE', "%$value%");
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'parent_id', 'id');
    }
}
