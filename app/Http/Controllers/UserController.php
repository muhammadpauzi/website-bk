<?php

namespace App\Http\Controllers;

use App\Models\_Parent;
use App\Models\Student;
use Illuminate\Support\Str;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{

    public static array $customAttributes = [
        'name' => 'Nama Lengkap User',
        'email' => 'Email',
        'password' => 'Password',
        'role' => 'Role / Hak Akses'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query()
            ->withoutMe()
            ->with(['teacher', 'student', 'parent'])
            ->filter()
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('users.index', [
            'title' => 'Daftar Data User',
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', [
            'title' => 'Tambah Data User'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|max:128',
            'email' => 'required|email|unique:users',
            'password' => 'sometimes|confirmed',
        ], customAttributes: self::$customAttributes);

        User::create(array_merge($validatedData, [
            'password' => Hash::make($validatedData['password']),
            'role' => User::$SUPERADMIN
        ]));

        return redirect()
            ->route('users.index')
            ->with('success', 'Data user berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', [
            'title' => 'Detail Data User',
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'title' => 'Edit Data User',
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $emailUniqueValidation = $user->role === User::$SUPERADMIN &&
            $request->email === $user->email ? '' : '|unique:users';

        $usernameUniqueValidation = $user->role !== User::$SUPERADMIN &&
            $request->username === $user->username ? '' : '|unique:users';

        $rules = array_merge(
            [
                'name' => 'required|max:128'
            ],
            $user->role === User::$SUPERADMIN ? [
                'email' => 'required|email' . $emailUniqueValidation
            ] : [
                'username' => 'required|alpha_dash' . $usernameUniqueValidation
            ],
            $request->input('password') ?
                ['password' => 'confirmed'] : []
        );

        $validatedData = $this->validate($request, $rules, customAttributes: self::$customAttributes);

        $user->update(array_merge($validatedData, array_key_exists('password', $validatedData) ? [
            'password' => Hash::make($validatedData['password']),
        ] : []));

        return redirect()
            ->route('users.index')
            ->with('success', 'Data user berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Data user berhasil dihapus.');
    }

    private function synchronizeProcess(array $validatedData)
    {
        // GURU, SISWA & ORANG TUA JIKA BELUM MEMPUNYAI AKSES/AKUN USER
        $method = $validatedData['method'];

        if ($method === 'generate_teachers')
            Teacher::query()
                ->select(['id', 'name'])
                ->where('user_id', null)
                ->chunkById(200, function ($teachers) use ($validatedData) {
                    try {
                        DB::beginTransaction();

                        foreach ($teachers as $teacher) {
                            $user = User::create([
                                'name' => $teacher->name,
                                'password' => Hash::make($validatedData['password']),
                                'username' => Str::slug($teacher['name'] . ' ' . uniqid()),
                                'role' => User::$TEACHER,
                            ]);

                            $teacher->update([
                                'user_id' => $user->id
                            ]);
                        }

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return back()->with('failed', 'Proses synchronize gagal, Silahkan coba lagi!');
                    }
                });


        if ($method === 'generate_students')
            Student::query()
                ->select(['id', 'name'])
                ->where('user_id', null)
                ->chunkById(200, function ($students) use ($validatedData) {
                    try {
                        DB::beginTransaction();

                        foreach ($students as $student) {
                            $user = User::create([
                                'name' => $student->name,
                                'password' => Hash::make($validatedData['password']),
                                'username' => Str::slug($student['name'] . ' ' . uniqid()),
                                'role' => User::$STUDENT,
                            ]);

                            $student->update([
                                'user_id' => $user->id
                            ]);
                        }

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return back()->with('failed', 'Proses synchronize gagal, Silahkan coba lagi!');
                    }
                });

        if ($method === 'generate_parents')
            _Parent::query()
                ->select(['id', 'name'])
                ->where('user_id', null)
                ->chunkById(200, function ($parents) use ($validatedData) {
                    try {
                        DB::beginTransaction();

                        foreach ($parents as $parent) {
                            $user = User::create([
                                'name' => $parent->name,
                                'password' => Hash::make($validatedData['password']),
                                'username' => Str::slug($parent['name'] . ' ' . uniqid()),
                                'role' => User::$PARENT,
                            ]);

                            $parent->update([
                                'user_id' => $user->id
                            ]);
                        }

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return back()->with('failed', 'Proses synchronize gagal, Silahkan coba lagi!');
                    }
                });
        // END: GURU, SISWA & ORANG TUA JIKA BELUM MEMPUNYAI AKSES/AKUN USER

        // GURU, SISWA & ORANG TUA JIKA SUDAH MEMPUNYAI AKSES/AKUN USER, DAN UPDATE KE TERBARU (NAMA)
        if ($method === 'sync_teachers')
            Teacher::query()
                ->select(['id', 'name', 'user_id'])
                ->whereNot('user_id', null)
                ->chunkById(200, function ($teachers) {
                    foreach ($teachers as $teacher) {
                        $user = optional($teacher->user);
                        $user && $user->name !== $teacher->name && $user->update([
                            'name' => $teacher->name
                        ]);
                    }
                });

        if ($method === 'sync_students')
            Student::query()
                ->select(['id', 'name', 'user_id'])
                ->whereNot('user_id', null)
                ->chunkById(200, function ($students) {
                    foreach ($students as $student) {
                        $user = optional($student->user);
                        $user && $user->name !== $student->name && $user->update([
                            'name' => $student->name
                        ]);
                    }
                });

        if ($method === 'sync_parents')
            _Parent::query()
                ->select(['id', 'name', 'user_id'])
                ->whereNot('user_id', null)
                ->chunkById(200, function ($parents) {
                    foreach ($parents as $parent) {
                        $user = optional($parent->user);
                        $user && $user->name !== $parent->name && $user->update([
                            'name' => $parent->name
                        ]);
                    }
                });

        // $studentsAlreadyHasUserForUpdateTheName = Student::query()
        //     ->select(['id', 'name'])
        //     ->whereNot('user_id', null)
        //     ->get();

        // $studentsAlreadyHasUserForUpdateTheName->each(function ($student) {
        //     User::find($student->id)->update([
        //         'name' => $student->name
        //     ]);
        // });

        // $parentsAlreadyHasUserForUpdateTheName = _Parent::query()
        //     ->select(['id', 'name'])
        //     ->whereNot('user_id', null)
        //     ->get();

        // $parentsAlreadyHasUserForUpdateTheName->each(function ($parent) {
        //     User::find($parent->id)->update([
        //         'name' => $parent->name
        //     ]);
        // });
        // END: GURU, SISWA & ORANG TUA JIKA SUDAH MEMPUNYAI AKSES/AKUN USER, DAN UPDATE KE TERBARU (NAMA)
    }

    public function synchronizeUserAccountForTeacherStudentParent(Request $request)
    {
        //     <div class="alert alert-warning">
        //     Memproses data users dari guru, siswa, dan orang tua.
        //     <ul>
        //         <li>Jika data guru, siswa dan orang tua sudah terdaftar sebagai user, maka data user akan
        //             diupdate sesuai dengan data guru, siswa dan orang tua, seperti nama.</li>
        //         <li>Jika belum terdaftar maka akan dibuatkan data user sesuai data guru, siswa & orang tua
        //             dengan password awal yang akan anda masukan dibawah.</li>
        //         <li>Jika data guru, siswa, dan orang tua dihapus, maka data users juga akan terhapus.</li>
        //     </ul>
        // </div>

        $validatedData = $this->validate($request, [
            'method' => 'required',
            'password' => (Str::contains($request->input('method'), 'generate') ? 'required|' : '') .  'confirmed',
        ], customAttributes: self::$customAttributes);

        // // guru yang belum mempunyai akun user
        // $teachersDoesNotHaveUser = Teacher::query()
        //     ->select(['name'])
        //     ->where('user_id', null)
        //     ->get();
        // $teachersDoesNotHaveUser = $teachersDoesNotHaveUser->toArray();
        // $teachersDoesNotHaveUser = array_chunk(array_map(function ($teacher) use ($validatedData) {
        //     return [
        //         'name' => $teacher['name'],
        //         'username' => Str::slug($teacher['name'] . ' ' . uniqid()),
        //         'password' => $validatedData['password'],
        //         'role' => User::$TEACHER,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ];
        // }, $teachersDoesNotHaveUser), 50);

        // // siswa yang belum mempunyai akun user
        // $studentsDoesNotHaveUser = Student::query()
        //     ->select(['name'])
        //     ->where('user_id', null)
        //     ->get();
        // $studentsDoesNotHaveUser = $studentsDoesNotHaveUser->toArray();
        // $studentsDoesNotHaveUser = array_chunk(array_map(function ($student) use ($validatedData) {
        //     return [
        //         'name' => $student['name'],
        //         'username' => Str::slug($student['name'] . ' ' . uniqid()),
        //         'password' => $validatedData['password'],
        //         'role' => User::$STUDENT,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ];
        // }, $studentsDoesNotHaveUser), 50);

        // // orang tua yang belum mempunyai akun user
        // $parentsDoesNotHaveUser = _Parent::query()
        //     ->select(['name'])
        //     ->where('user_id', null)
        //     ->get();
        // $parentsDoesNotHaveUser = $parentsDoesNotHaveUser->toArray();
        // $parentsDoesNotHaveUser = array_chunk(array_map(function ($parent) use ($validatedData) {
        //     return [
        //         'name' => $parent['name'],
        //         'username' => Str::slug($parent['name'] . ' ' . uniqid()),
        //         'password' => $validatedData['password'],
        //         'role' => User::$STUDENT,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ];
        // }, $parentsDoesNotHaveUser), 50);


        // DB::transaction(function () use ($teachersDoesNotHaveUser) {
        //     foreach ($teachersDoesNotHaveUser as $teacher) {
        //         User::insert($teacher);
        //     }
        // });

        DB::transaction(function () use ($validatedData) {
            $this->synchronizeProcess($validatedData);
        });

        return back()->with('success', 'Berhasil');
    }
}
