<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, FilterQueryString;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'role'
    ];

    // roles
    public static string $SUPERADMIN = 'superadmin';
    public static string $TEACHER = 'teacher';
    public static string $STUDENT = 'student';
    public static string $PARENT = 'parent';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $filters = ['search', 'sort'];

    public function search(Builder $query, $value)
    {
        return $query
            ->when($value, function ($query_) use ($value) {
                $query_
                    ->where('name', 'LIKE', "%$value%")
                    ->orWhere('email', 'LIKE', "%$value%");
            });
    }

    public function scopeWithoutMe(Builder $query)
    {
        $query->whereNot('id', auth()->id());
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function parent(): HasOne
    {
        return $this->hasOne(_Parent::class);
    }
}
