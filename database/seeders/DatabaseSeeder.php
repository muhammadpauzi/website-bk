<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Class_;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach (['users', 'students', 'teachers', 'classes'] as $table) {
            Schema::disableForeignKeyConstraints();
            DB::table($table)->truncate();
            Schema::enableForeignKeyConstraints();
        }

        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Muhammad Pauzi',
            'email' => 'muhammadpauzi@gmail.com',
            'role' => 'superadmin'
        ]);

        Student::factory(200)->create();

        Teacher::factory(40)
            ->create()
            ->each(function (Teacher $teacher) {
                Class_::factory(1)->create([
                    'wali_kelas_id' => $teacher->id
                ]);
            });
    }
}
