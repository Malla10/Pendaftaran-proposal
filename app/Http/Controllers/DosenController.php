<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:dosen');
    }

    /**
     * Dashboard Dosen
     */
    public function dashboard()
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();

        $mahasiswaBimbingan = Proposal::where('dosen_pembimbing_id', $dosen->id)
            ->where('status', 'pembimbing_ditentukan')
            ->with('mahasiswa')
            ->latest()
            ->get();

        $stats = [
            'total_bimbingan' => $mahasiswaBimbingan->count(),
            'kuota_tersisa' => $dosen->getSisaKuota(),
            'persentase_beban' => $dosen->getPersentaseBeban()
        ];

        return view('dosen.dashboard', compact('mahasiswaBimbingan', 'stats', 'dosen'));
    }

    /**
     * List mahasiswa bimbingan
     */
    public function listMahasiswa()
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();

        $mahasiswa = Proposal::where('dosen_pembimbing_id', $dosen->id)
            ->where('status', 'pembimbing_ditentukan')
            ->with('mahasiswa')
            ->paginate(15);

        return view('dosen.mahasiswa', compact('mahasiswa', 'dosen'));
    }

    /**
     * Detail proposal mahasiswa
     */
    public function showProposal($id)
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();

        $proposal = Proposal::where('dosen_pembimbing_id', $dosen->id)
            ->with('mahasiswa')
            ->findOrFail($id);

        return view('dosen.proposal-detail', compact('proposal'));
    }
}