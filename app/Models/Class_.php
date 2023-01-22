<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Class_ extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $guarded = ['id'];

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'wali_kelas_id', 'id');
    }
}
