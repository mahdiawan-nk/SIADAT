<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::with('kenegerian:id,nama_kenegerian')->orderBy('id', 'asc');
        if ($request->has('users_id')) {
            $query->where('id', '!=', $request->input('users_id'));
        }
        $data = $query->get();
        $dataTable = DataTables::of($data);
        $dataTable->addIndexColumn()
            ->addColumn('action', function ($row) {
                if ($row->role == 2) {
                    return '<button class="btn btn-sm btn-secondary me-1 reset">Reset Password</button><button class="btn btn-sm btn-secondary me-1 edit">Edit</button><button class="btn btn-sm btn-danger hapus">Hapus</button>';
                }
            })
            ->rawColumns(['action']);

        return $dataTable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request, User $user)
    {
        $user->password = Hash::make(12345678);
        $user->save();
        return response()->json([
            'status' => 'OK',
            'message' => 'Reset Password Berhasil, Password Menjadi Default 12345678',
            'data' => $request->all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input menggunakan metode validate
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'id_kenegerian' => 'required|string|max:255',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'id_kenegerian.required' => 'ID Kenegerian wajib diisi.',
        ]);

        // Hash password sebelum menyimpan ke database
        $password = Hash::make(12345678);

        // Buat user baru
        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'id_kenegerian' => $request->id_kenegerian,
            'role' => 2,
            'password' => $password,
        ]);
        return response()->json([
            'status' => 'OK',
            'message' => 'User Berhasil Di daftarkan, password default 12345678',
            'data' => $request->all()
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
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
        $userUpdateForm = [
            'nama_lengkap' => $request->post('nama_lengkap'),
            'username' => $request->post('username'),
            'email' => $request->post('email'),
            'id_kenegerian' => auth()->user()->role == 1 ? $request->post('id_kenegerian') : auth()->user()->id_kenegerian,
        ];
        if($request->password){
            $userUpdateForm['password'] = Hash::make($request->password);
        }
        $user->fill($userUpdateForm)->save();
        $response = [
            'status' => "Berhasil",
            'message' => 'Berhasil Update',
            'data' => [
                'user' => $user,
                'password'=> $request->password
            ]
        ];
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            // Panggil metode delete untuk menghapus data
            $user->delete();

            // Berhasil menghapus, kembalikan respons JSON
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Data  berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            // Tangkap pengecualian jika terjadi kesalahan saat menghapus
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Gagal menghapus data ' . $e->getMessage()
            ], 500); // Kode status 500 untuk internal server error
        }
    }
}
