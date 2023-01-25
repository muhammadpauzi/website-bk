<?php

namespace App\Http\Controllers;

use App\Models\_Parent;
use App\Models\Class_;
use App\Models\OffenseCategory;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Tindakan;
use App\Models\User;
use Carbon\Carbon;
use Flowframe\Trend\Trend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $trend = Trend::model(User::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count()
            ->toArray();
        $results = [[], []];
        foreach ($trend as $item) {
            $results[0][] = Carbon::parse($item->date)->monthName;
            $results[1][] = $item->aggregate;
        }

        $cardStats = Cache::remember('card-stats', 60 * 2, function () {
            return [
                [
                    "label" => "User Terdaftar",
                    "prefix" => "Users",
                    "count" => User::count(),
                    "type_color" => "primary",
                    "more_info_link" => route('users.index'),
                    "icon" => "user-check"
                ],
                [
                    "label" => "User (Guru) Terdaftar",
                    "prefix" => "Users (Guru)",
                    "count" => User::where('role', User::$TEACHER)->count(),
                    "type_color" => "primary",
                    "more_info_link" => route('users.index'),
                    "icon" => "user-check"
                ],
                [
                    "label" => "User (Siswa) Terdaftar",
                    "prefix" => "Users (Siswa)",
                    "count" => User::where('role', User::$STUDENT)->count(),
                    "type_color" => "primary",
                    "more_info_link" => route('users.index'),
                    "icon" => "user-check"
                ],
                [
                    "label" => "User (Orang Tua) Terdaftar",
                    "prefix" => "Users (Orang Tua)",
                    "count" => User::where('role', User::$PARENT)->count(),
                    "type_color" => "primary",
                    "more_info_link" => route('users.index'),
                    "icon" => "user-check"
                ],
                [
                    "label" => "User (Superadmin) Terdaftar",
                    "prefix" => "Users (Superadmin)",
                    "count" => User::where('role', User::$SUPERADMIN)->count(),
                    "type_color" => "primary",
                    "more_info_link" => route('users.index'),
                    "icon" => "user-check"
                ],
                [
                    "label" => "Guru",
                    "prefix" => "Guru",
                    "count" => Teacher::count(),
                    "type_color" => "primary",
                    "more_info_link" => route('teachers.index'),
                    "icon" => "user-check"
                ],
                [
                    "label" => "Siswa",
                    "prefix" => "Siswa",
                    "count" => Student::count(),
                    "type_color" => "primary",
                    "more_info_link" => route('students.index'),
                    "icon" => "user-check"
                ],
                [
                    "label" => "Orang Tua",
                    "prefix" => "Orang Tua",
                    "count" => _Parent::count(),
                    "type_color" => "primary",
                    "more_info_link" => route('parents.index'),
                    "icon" => "user-check"
                ],
                [
                    "label" => "Kelas",
                    "prefix" => "Kelas",
                    "count" => Class_::count(),
                    "type_color" => "primary",
                    "more_info_link" => route('classes.index'),
                    "icon" => "user-check"
                ],
                [
                    "label" => "Kategori Pelanggaran",
                    "prefix" => "Kategori Pelanggaran",
                    "count" => OffenseCategory::count(),
                    "type_color" => "primary",
                    "more_info_link" => route('offense-categories.index'),
                    "icon" => "user-check"
                ],
                [
                    "label" => "Tindakan",
                    "prefix" => "Tindakan",
                    "count" => Tindakan::count(),
                    "type_color" => "primary",
                    "more_info_link" => route('tindakans.index'),
                    "icon" => "user-check"
                ],
            ];
        });

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'cardStats' => $cardStats,
            'results' => $results
        ]);
    }
}
