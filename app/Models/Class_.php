<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Class_ extends Model
{
    use HasFactory, FilterQueryString;

    protected $table = 'classes';

    protected $guarded = ['id'];

    protected $filters = ['search', 'sort', 'by_wali_kelas'];

    public function search(Builder $query, $value)
    {
        return $query
            ->when($value, function ($query_) use ($value) {
                $query_
                    ->where('name', 'LIKE', "%$value%");
            });
    }

    public function by_wali_kelas(Builder $query, $value)
    {
        return $query
            ->whereHas('waliKelas', function (Builder $query) use ($value) {
                $query->where('id', $value);
            });
    }

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'wali_kelas_id', 'id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id', 'id');
    }
}
