<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class StudentOffense extends Model
{
    use HasFactory, FilterQueryString;

    protected $guarded = ['id'];

    protected $casts = [
        'reported_at' => 'date',
    ];

    protected $filters = ['search', 'sort'];

    public function search(Builder $query, $value)
    {
        return $query
            ->when($value, function ($query_) use ($value) {
                $query_
                    ->where('reported_at', 'LIKE', "%$value%")
                    ->orWhere('description', 'LIKE', "%$value%");
            });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'reporter_id', 'id');
    }

    public function offenseCategory(): BelongsTo
    {
        return $this->belongsTo(OffenseCategory::class);
    }
}
