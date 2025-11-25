<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DosenCrudController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of dosen.
     */
    public function index()
    {
        $dosens = Dosen::with('user')->latest()->paginate(10);
        return view('admin.dosen.index', compact('dosens'));
    }

    /**
     * Show the form for creating a new dosen.
     */
    public function create()
    {
        return view('admin.dosen.create');
    }

    /**
     * Store a newly created dosen in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nidn' => 'required|string|unique:dosen,nidn|unique:users,nidn',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:6',
            'bidang_penelitian' => 'required|string',
            'keywords' => 'required|string',
            'kuota_bimbingan' => 'required|integer|min:1|max:20'
        ], [
            'nama.required' => 'Nama dosen wajib diisi',
            'nidn.required' => 'NIDN wajib diisi',
            'nidn.unique' => 'NIDN sudah terdaftar',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'bidang_penelitian.required' => 'Bidang penelitian wajib diisi',
            'keywords.required' => 'Keywords wajib diisi',
            'kuota_bimbingan.required' => 'Kuota bimbingan wajib diisi',
        ]);

        DB::beginTransaction();
        try {
            // Buat user dosen
            $user = User::create([
                'username' => $request->username,
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'dosen',
                'nidn' => $request->nidn,
            ]);

            // Buat data dosen
            Dosen::create([
                'user_id' => $user->id,
                'nidn' => $request->nidn,
                'nama' => $request->nama,
                'bidang_penelitian' => $request->bidang_penelitian,
                'keywords' => $request->keywords,
                'kuota_bimbingan' => $request->kuota_bimbingan,
                'kuota_terpakai' => 0,
            ]);

            DB::commit();
            return redirect()->route('admin.dosen.index')
                ->with('success', 'Data dosen berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan data dosen: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified dosen.
     */
    public function show(string $id)
    {
        $dosen = Dosen::with(['user', 'proposals.mahasiswa'])->findOrFail($id);
        return view('admin.dosen.show', compact('dosen'));
    }

    /**
     * Show the form for editing the specified dosen.
     */
    public function edit(string $id)
    {
        $dosen = Dosen::with('user')->findOrFail($id);
        return view('admin.dosen.edit', compact('dosen'));
    }

    /**
     * Update the specified dosen in storage.
     */
    public function update(Request $request, string $id)
    {
        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nidn' => 'required|string|unique:dosen,nidn,' . $id . '|unique:users,nidn,' . $dosen->user_id,
            'email' => 'required|email|unique:users,email,' . $dosen->user_id,
            'username' => 'required|string|unique:users,username,' . $dosen->user_id,
            'password' => 'nullable|min:6',
            'bidang_penelitian' => 'required|string',
            'keywords' => 'required|string',
            'kuota_bimbingan' => 'required|integer|min:1|max:20'
        ]);

        DB::beginTransaction();
        try {
            // Update user
            $userData = [
                'username' => $request->username,
                'name' => $request->nama,
                'email' => $request->email,
                'nidn' => $request->nidn,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $dosen->user->update($userData);

            // Update dosen
            $dosen->update([
                'nidn' => $request->nidn,
                'nama' => $request->nama,
                'bidang_penelitian' => $request->bidang_penelitian,
                'keywords' => $request->keywords,
                'kuota_bimbingan' => $request->kuota_bimbingan,
            ]);

            DB::commit();
            return redirect()->route('admin.dosen.index')
                ->with('success', 'Data dosen berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate data dosen: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified dosen from storage.
     */
    public function destroy(string $id)
    {
        try {
            $dosen = Dosen::findOrFail($id);
            
            // Cek apakah dosen masih punya mahasiswa bimbingan
            if ($dosen->kuota_terpakai > 0) {
                return back()->with('error', 'Tidak dapat menghapus dosen yang masih membimbing mahasiswa!');
            }

            $dosen->user->delete(); // Akan otomatis delete dosen karena cascade
            
            return redirect()->route('admin.dosen.index')
                ->with('success', 'Data dosen berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data dosen: ' . $e->getMessage());
        }
    }
}